<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Studio extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Studio_model');

		if (!$this->session->userdata('logged_in'))
			redirect('auth/logout');
	}

	public function index()
	{
		$role_id = $this->session->userdata('role_id');
		$data = [
			'role_id' => $role_id,
			'title' => 'Studio Management',
			'sub_title' => 'List Studio',
			'menu' => 'studio',
			'studios' => $this->Studio_model->get_all()
		];

		$this->display_page('studio', $data);
	}

	public function view()
	{
		$role_id = $this->session->userdata('role_id');
		$data = [
			'role_id' => $role_id,
			'title' => 'Studio',
			'sub_title' => 'List Studio',
			'menu' => 'studio',
			'studios' => $this->Studio_model->get_all()
		];

		$this->display_page('studio_view', $data);
	}

	public function get_detail()
	{
		$id_studio = $this->input->post('id_studio');
		echo json_encode([
			'studio' => $this->Studio_model->get_by_id($id_studio),
			'images' => $this->Studio_model->get_images($id_studio)
		]);
	}

	public function save()
	{
		$id_studio = $this->input->post('id_studio');

		$data = [
			'studio_name'    => trim($this->input->post('studio_name', TRUE)),
			'category'       => $this->input->post('category'),
			'description'    => $this->input->post('description'),
			'price_per_hour' => $this->input->post('price_per_hour'),
			'capacity'       => $this->input->post('capacity'),
			'status'         => $this->input->post('status'),
			'updated_date'   => date('Y-m-d H:i:s'),
			'updated_by'     => $this->session->userdata('id_user')
		];

		$is_new = empty($id_studio);

		if ($is_new) {
			$data['created_date'] = date('Y-m-d H:i:s');
			$data['created_by']   = $this->session->userdata('id_user');
			$id_studio = $this->Studio_model->insert($data);
		} else {
			$this->Studio_model->update($id_studio, $data);
		}

		if (!empty($_FILES['studio_images']['name'][0])) {
			if (!is_dir('./uploads/studio/')) {
				mkdir('./uploads/studio/', 0777, TRUE);
			}

			$config = [
				'upload_path'   => './uploads/studio/',
				'allowed_types' => 'jpg|jpeg|png|webp',
				'encrypt_name'  => TRUE,
				'max_size'      => 2048
			];

			$this->load->library('upload');

			$image_batch = [];
			$existing_images = $this->Studio_model->get_images($id_studio);
			$studio = $this->Studio_model->get_by_id($id_studio);
			$thumbnail_set = !empty($studio['thumbnail']);
			$sort_order = count($existing_images) + 1;
			$total = count($_FILES['studio_images']['name']);
			for ($i = 0; $i < $total; $i++) {
				$_FILES['file']['name']     = $_FILES['studio_images']['name'][$i];
				$_FILES['file']['type']     = $_FILES['studio_images']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['studio_images']['tmp_name'][$i];
				$_FILES['file']['error']    = $_FILES['studio_images']['error'][$i];
				$_FILES['file']['size']     = $_FILES['studio_images']['size'][$i];
				$this->upload->initialize($config);
				if ($this->upload->do_upload('file')) {
					$upload = $this->upload->data();
					$image_batch[] = [
						'id_studio'  => $id_studio,
						'image_path' => $upload['file_name'],
						'sort_order' => $sort_order++
					];
					if (!$thumbnail_set) {
						$this->Studio_model->update($id_studio, ['thumbnail' => $upload['file_name']]);
						$thumbnail_set = TRUE;
					}
				}
			}

			if (!empty($image_batch)) {
				$this->Studio_model->insert_images($image_batch);
			}
		}

		echo json_encode(['status'  => TRUE, 'message' => 'Data studio berhasil disimpan']);
	}

	public function change_status()
	{
		$id_studio = $this->input->post('id_studio');
		$studio = $this->Studio_model->get_by_id($id_studio);
		$status = $studio['status'] == 'active' ? 'inactive' : 'active';

		$this->Studio_model->update($id_studio, [
			'status' => $status,
			'updated_date' => date('Y-m-d H:i:s'),
			'updated_by' => $this->session->userdata('id_user')
		]);

		echo json_encode(['status' => TRUE]);
	}

	public function delete()
	{
		$id_studio = $this->input->post('id_studio');
		$this->Studio_model->delete($id_studio);
		echo json_encode(['status' => TRUE, 'message' => 'Data berhasil dihapus']);
	}

	private function display_page($content, $data = null)
	{
		$this->load->view('header', $data);
		$this->load->view($content, $data);
		$this->load->view('footer');
	}
}
