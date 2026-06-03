<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Auth_model');

		if (!$this->session->userdata('logged_in')) {
			redirect('auth/logout');
		}
	}

	public function index()
	{
		$role_id = $this->session->userdata('role_id');

		$page_title = "Dashboard";
		$sub_title = "Dashboard";
		$active_menu = "dashboard";

		$data = [
			'role_id' => $role_id,
			'title' => $page_title,
			'sub_title' => $sub_title,
			'menu' => $active_menu
		];

		$this->display_page('dashboard', $data);
	}

	private function display_page($main_content, $data = null)
	{
		$this->load->view("header", $data);
		$this->load->view($main_content);
		$this->load->view("footer");
	}
}
