<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('User_model');
		$this->load->model('Auth_model');

		if (!$this->session->userdata('logged_in')) {
			redirect('auth/logout');
		}
	}

	public function index()
	{
		$role_id = $this->session->userdata('role_id');

		$data = [
			'role_id' => $role_id,
			'title' => "Users Management",
			'sub_title' => "List User",
			'menu' => "users"
		];

		$this->display_page('users', $data);
	}

	public function get_data()
	{
		$result = $this->User_model->get_datatable();

		$data = [];
		$no = $_POST['start'];

		foreach ($result as $row) {
			$badge_role = 'success';
			if ($row->role_name == 'Admin') {
				$badge_role = 'danger';
			} elseif ($row->role_name == 'Staff') {
				$badge_role = 'warning';
			}

			$status = $row->status == 'active'
				? '<span class="badge badge-sm bg-gradient-success text-xxs px-2 py-1 rounded-3">Active</span>'
				: '<span class="badge badge-sm bg-gradient-secondary text-xxs px-2 py-1 rounded-3">Inactive</span>';

			$action = '
            <div class="d-flex align-items-center justify-content-center gap-1">
                <button type="button" class="btn btn-icon-only btn-sm btn-outline-info btn-edit mb-0 d-flex align-items-center justify-content-center rounded-circle" data-id="' . $row->id_user . '" title="Edit User" style="width:30px; height:30px;">
                    <i class="material-symbols-rounded text-sm">edit</i>
                </button>

                <button type="button" class="btn btn-icon-only btn-sm btn-outline-warning btn-status mb-0 d-flex align-items-center justify-content-center rounded-circle" data-id="' . $row->id_user . '" title="Ubah Status" style="width:30px; height:30px;">
                    <i class="material-symbols-rounded text-sm">sync</i>
                </button>

                <button type="button" class="btn btn-icon-only btn-sm btn-outline-danger btn-delete mb-0 d-flex align-items-center justify-content-center rounded-circle" data-id="' . $row->id_user . '" title="Hapus User" style="width:30px; height:30px;">
                    <i class="material-symbols-rounded text-sm">delete</i>
                </button>
            </div>';

			$data[] = [
				'<div class="text-center text-sm font-weight-bold">' . ++$no . '</div>',
				'<p class="text-sm font-weight-bold mb-0">' . htmlspecialchars($row->username) . '</p>',
				'<p class="text-sm text-secondary mb-0">' . htmlspecialchars($row->full_name) . '</p>',
				'<span class="text-xs text-secondary font-weight-normal">' . htmlspecialchars($row->email) . '</span>',
				'<div class="text-center"><span class="badge badge-sm bg-gradient-' . $badge_role . ' text-xxs px-2 py-1 rounded-3">' . $row->role_name . '</span></div>',
				'<div class="text-center">' . $status . '</div>',
				'<div class="text-center"><span class="text-secondary text-xs font-weight-normal">' . date('d M Y', strtotime($row->created_date)) . '</span></div>',
				$action
			];
		}

		echo json_encode([
			"draw"            => intval($_POST['draw']),
			"recordsTotal"    => $this->User_model->count_all(),
			"recordsFiltered" => $this->User_model->count_filtered(),
			"data"            => $data
		]);
	}

	public function get_detail()
	{
		$id_user = $this->input->post('id_user');
		echo json_encode($this->User_model->get_by_id($id_user));
	}

	public function save()
	{
		$id_user = $this->input->post('id_user');

		$data = [
			'id_role'      => $this->input->post('id_role'),
			'username'     => trim($this->input->post('username', TRUE)),
			'full_name'    => trim($this->input->post('full_name', TRUE)),
			'email'        => trim($this->input->post('email', TRUE)),
			'phone'        => trim($this->input->post('phone', TRUE)),
			'status'       => $this->input->post('status'),
			'updated_date' => date('Y-m-d H:i:s'),
			'updated_by'   => $this->session->userdata('id_user')
		];

		if (empty($id_user)) {
			$cek = $this->db->where('username', $data['username'])->or_where('email', $data['email'])->get('users')->num_rows();
			if ($cek > 0) {
				echo json_encode([
					'status'  => false,
					'message' => 'Username atau email sudah digunakan'
				]);
				return;
			}

			if (empty($this->input->post('password'))) {
				echo json_encode([
					'status'  => false,
					'message' => 'Password wajib diisi'
				]);
				return;
			}

			$data['password'] = $this->Auth_model->encrypt_password($this->input->post('password'));

			$data['created_date'] = date('Y-m-d H:i:s');
			$data['created_by']   = $this->session->userdata('id_user');
		}

		if (!empty($this->input->post('password'))) {
			$data['password'] = $this->Auth_model->encrypt_password($this->input->post('password'));
		}

		if (!empty($_FILES['profile_picture']['name'])) {
			$config = [
				'upload_path'   => './uploads/profile/',
				'allowed_types' => 'jpg|jpeg|png',
				'max_size'      => 2048,
				'encrypt_name'  => TRUE
			];

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('profile_picture')) {
				$upload = $this->upload->data();
				$data['profile_picture'] = $upload['file_name'];
			}
		}

		if (empty($id_user)) {
			$userid = $this->User_model->insert($data);
			if ($data['id_role'] == 3) {
				$bronze = $this->db->where('LOWER(tier_name)', 'bronze')->get('membership_tiers')->row();
				if ($bronze) {
					$this->db->insert('user_memberships', [
						'id_user'             => $userid,
						'id_tier'             => $bronze->id_tier,
						'total_transaction'   => 0,
						'total_booking_hours' => 0,
						'joined_at'           => date('Y-m-d H:i:s')
					]);
				}
			}
		} else {
			$this->User_model->update($id_user, $data);
		}

		echo json_encode(['status'  => true, 'message' => 'Data berhasil disimpan']);
	}

	public function change_status()
	{
		$id_user = $this->input->post('id_user');

		$this->User_model->change_status($id_user);
		echo json_encode(['status' => true]);
	}

	public function delete()
	{
		$id_user = $this->input->post('id_user');

		$this->User_model->delete($id_user);
		echo json_encode(['status' => true]);
	}

	private function display_page($main_content, $data = null)
	{
		$this->load->view("header", $data);
		$this->load->view($main_content);
		$this->load->view("footer");
	}
}
