<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addons extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Addons_model');

		if (!$this->session->userdata('logged_in'))
			redirect('auth/logout');
	}

	public function index()
	{
		$role_id = $this->session->userdata('role_id');

		$data = [
			'role_id' => $role_id,
			'title' => 'Add On Management',
			'sub_title' => 'List Add On',
			'menu' => 'addons'
		];

		$this->display_page('addon', $data);
	}

	public function get_data()
	{
		$list = $this->Addons_model->get_datatables();

		$data = [];
		$no = $_POST['start'];

		foreach ($list as $row) {
			$no++;
			$thumbnail = !empty($row->thumbnail) ? base_url('uploads/addons/' . $row->thumbnail) : base_url('uploads/addons/default.jpg');
			$used_stock = (int)$row->used_stock;
			$available_stock = max(0, $row->stock - $used_stock);

			$status = $row->status == 'active' ? '<span class="badge bg-gradient-success">Aktif</span>' : '<span class="badge bg-gradient-secondary">Non Aktif</span>';

			$action = '
								<div class="d-flex justify-content-center gap-1">
										<button class="btn btn-outline-info btn-sm btn-edit mb-0" data-id="' . $row->id_addon . '">
												<i class="material-symbols-rounded text-sm">edit</i>
										</button>
										<button class="btn btn-outline-warning btn-sm btn-status mb-0" data-id="' . $row->id_addon . '">
												<i class="material-symbols-rounded text-sm">sync</i>
										</button>
										<button class="btn btn-outline-danger btn-sm btn-delete mb-0" data-id="' . $row->id_addon . '">
												<i class="material-symbols-rounded text-sm">delete</i>
										</button>
								</div>';

			$addon_info = '
										<div class="d-flex align-items-center">
												<img src="' . $thumbnail . '"
														class="avatar avatar-lg me-3 border-radius-lg shadow-sm"
														style="width:60px;height:60px;object-fit:cover;">

												<div>
														<h6 class="mb-0 text-sm font-weight-bold">' . $row->addon_name . '</h6>
														<span class="text-xs text-secondary">' . $row->category . '</span>
												</div>
										</div>';

			$available_stock = max(0, $row->stock - $used_stock);
			$available_badge = '-';
			if ($row->status == 'inactive') {
				$available_badge = '<span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill">-</span>';
			} else {
				if ($available_stock > 0) {
					$available_badge = '<span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill fw-bold">' . $available_stock . ' Ready</span>';
				} else {
					$available_badge = '<span class="badge bg-danger-subtle text-danger border border-danger-subtle rounded-pill fw-bold">Habis</span>';
				}
			}

			$total_stock_badge = '<span class="badge bg-info-subtle text-info border rounded-pill fw-semibold">' . number_format($row->stock) . ' Unit</span>';

			if ($used_stock > 0) {
				$used_stock_badge = '<span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill fw-bold">' . number_format($used_stock) . ' Dipakai</span>';
			} else {
				$used_stock_badge = '<span class="badge bg-light text-muted border rounded-pill">' . number_format($used_stock) . '</span>';
			}

			$data[] = [
				$no,
				$addon_info,
				'Rp ' . number_format($row->price, 0, ',', '.'),
				$total_stock_badge,
				$used_stock_badge,
				$available_badge,
				$status,
				$action
			];
		}

		echo json_encode([
			"draw" => $_POST['draw'],
			"recordsTotal" => $this->Addons_model->count_all(),
			"recordsFiltered" => $this->Addons_model->count_filtered(),
			"data" => $data
		]);
	}

	public function get_detail()
	{
		$id_addon = $this->input->post('id_addon');
		echo json_encode($this->Addons_model->get_by_id($id_addon));
	}

	public function save()
	{
		$id_addon = $this->input->post('id_addon');

		$data = [
			'addon_name' => trim($this->input->post('addon_name', TRUE)),
			'category' => $this->input->post('category'),
			'description' => $this->input->post('description'),
			'stock' => $this->input->post('stock'),
			'price' => $this->input->post('price'),
			'status' => $this->input->post('status'),
			'updated_date' => date('Y-m-d H:i:s'),
			'updated_by' => $this->session->userdata('id_user')
		];

		if (!empty($_FILES['thumbnail']['name'])) {
			if (!is_dir('./uploads/addons/')) mkdir('./uploads/addons/', 0777, true);

			$config = [
				'upload_path' => './uploads/addons/',
				'allowed_types' => 'jpg|jpeg|png|webp',
				'encrypt_name' => TRUE,
				'max_size' => 2048
			];

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('thumbnail')) {
				$upload = $this->upload->data();
				$data['thumbnail'] = $upload['file_name'];
			}
		}

		if (empty($id_addon)) {
			$data['created_date'] = date('Y-m-d H:i:s');
			$data['created_by'] = $this->session->userdata('id_user');

			$this->Addons_model->insert($data);
		} else {
			$this->Addons_model->update($id_addon, $data);
		}

		echo json_encode(['status' => TRUE, 'message' => 'Data add on berhasil disimpan']);
	}

	public function change_status()
	{
		$id_addon = $this->input->post('id_addon');

		$addon = $this->Addons_model->get_by_id($id_addon);
		$status = $addon->status == 'active' ? 'inactive' : 'active';
		$this->Addons_model->update($id_addon, [
			'status' => $status,
			'updated_date' => date('Y-m-d H:i:s'),
			'updated_by' => $this->session->userdata('id_user')
		]);

		echo json_encode(['status' => TRUE]);
	}

	public function delete()
	{
		$id_addon = $this->input->post('id_addon');

		$cek = $this->db->where('id_addon', $id_addon)->count_all_results('package_items');
		if ($cek > 0) {
			echo json_encode(['status' => false, 'message' => 'Add-on masih digunakan pada package.']);
			return;
		}

		$this->Addons_model->delete($id_addon);
		echo json_encode(['status' => true, 'message' => 'Data berhasil dihapus']);
	}

	private function display_page($content, $data = null)
	{
		$this->load->view('header', $data);
		$this->load->view($content, $data);
		$this->load->view('footer');
	}
}
