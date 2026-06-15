<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Auth_model');
		$this->load->model('Dashboard_model');

		$this->role_id = $this->session->userdata('role_id');
		if (!$this->session->userdata('logged_in')) {
			redirect('auth/logout');
		}
	}

	public function index()
	{
		$role_id = $this->role_id;
		switch ($role_id) {
			case 1:
				$this->dashboard_admin();
				break;
			case 2:
				$this->dashboard_staff();
				break;
			case 3:
				$this->dashboard_customer();
				break;
			default:
				redirect('auth/logout');
				break;
		}
	}

	private function dashboard_admin()
	{
		$data = [
			'role_id' => $this->role_id,
			'title' => 'Dashboard',
			'sub_title' => 'Dashboard Admin',
			'menu' => 'dashboard',
		];

		$this->display_page('dashboard', $data);
	}

	private function dashboard_staff()
	{
		$data = [
			'role_id' => $this->role_id,
			'title' => 'Dashboard',
			'sub_title' => 'Dashboard Staff',
			'menu' => 'dashboard',

		];

		$this->display_page('dashboard', $data);
	}

	private function dashboard_customer()
	{
		$id_user = $this->session->userdata('id_user');

		$data = [
			'role_id' => $this->role_id,
			'title' => 'Dashboard',
			'sub_title' => 'Dashboard Customer',
			'menu' => 'dashboard',
			'summary' => $this->Dashboard_model->getDashboardCustSummary($id_user),
			'membership' => $this->Dashboard_model->getMembershipInfo($id_user),
			'active_bookings' => $this->Dashboard_model->getActiveBookingUser($id_user),
			'transactions' => $this->Dashboard_model->getRecentTransactions($id_user),
			'favorite_package' => $this->Dashboard_model->getFavoritePackage($id_user),
			'favorite_studio' => $this->Dashboard_model->getFavoriteStudio($id_user)
		];
		// echo '<pre>';
		// print_r($data['summary']);
		// exit();
		$this->display_page('dashboard_cust', $data);
	}

	private function display_page($main_content, $data = null)
	{
		$this->load->view("header", $data);
		$this->load->view($main_content);
		$this->load->view("footer");
	}
}
