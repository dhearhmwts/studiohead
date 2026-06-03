<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
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
		$id_user = $this->session->userdata('id_user');

		$data = [
			'role_id'   => $this->session->userdata('role_id'),
			'title'     => 'Profile',
			'sub_title' => 'Profile User',
			'menu'      => 'profile',
			'user'      => $this->User_model->get_by_id($id_user)
		];

		$this->display_page('profile', $data);
	}

	public function update()
	{
		$id_user = $this->session->userdata('id_user');

		$data = [
			'full_name'   => $this->input->post('full_name', true),
			'email'       => $this->input->post('email', true),
			'phone'       => $this->input->post('phone', true),
			'updated_date' => date('Y-m-d H:i:s'),
			'updated_by'  => $id_user
		];

		if (!empty($_FILES['profile_picture']['name'])) {
			$config['upload_path']   = './uploads/profile/';
			$config['allowed_types'] = 'jpg|jpeg|png';
			$config['encrypt_name']  = TRUE;

			$this->load->library('upload', $config);

			if ($this->upload->do_upload('profile_picture')) {
				$upload = $this->upload->data();
				$data['profile_picture'] = $upload['file_name'];
			}
		}

		$this->User_model->update($id_user, $data);

		$this->session->set_flashdata(
			'success',
			'Profile berhasil diperbarui'
		);

		redirect('profile');
	}

	public function change_password()
	{
		$id_user = $this->session->userdata('id_user');

		$old_password     = $this->input->post('old_password');
		$new_password     = $this->input->post('new_password');
		$confirm_password = $this->input->post('confirm_password');

		$user = $this->User_model->get_by_id($id_user);

		if ($this->Auth_model->encrypt_password($old_password) != $user->password) {
			$this->session->set_flashdata(
				'error',
				'Password lama tidak sesuai'
			);

			redirect('profile');
		}

		if ($new_password != $confirm_password) {
			$this->session->set_flashdata(
				'error',
				'Konfirmasi password tidak sesuai'
			);

			redirect('profile');
		}

		$data = [
			'password'     => $this->Auth_model->encrypt_password($new_password),
			'updated_date' => date('Y-m-d H:i:s'),
			'updated_by'   => $id_user
		];

		$this->User_model->update($id_user, $data);

		$this->session->set_flashdata(
			'success',
			'Password berhasil diperbarui'
		);

		redirect('profile');
	}

	private function display_page($main_content, $data = null)
	{
		$this->load->view('header', $data);
		$this->load->view($main_content, $data);
		$this->load->view('footer');
	}
}
