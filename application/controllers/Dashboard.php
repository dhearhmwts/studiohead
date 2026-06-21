<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->load->model('Auth_model');
		$this->load->model('Dashboard_model');
		$this->load->model('Booking_model');

		$this->role_id = $this->session->userdata('role_id');
		$this->id_user = $this->session->userdata('id_user');
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
			'user' => $this->Dashboard_model->getUserInfo($this->id_user),
			'summary' => $this->Dashboard_model->getAdminSummary(),
			'waiting_verification' => $this->Dashboard_model->get_waiting_verification(),
			'booking_chart' => $this->Dashboard_model->getBookingChart(),
			'revenue_chart' => $this->Dashboard_model->getRevenueChart(),
			'revenueDaily_chart' => $this->Dashboard_model->getRevenueChartDaily(),
			'need_start' => $this->Dashboard_model->get_need_start_session(),
			'need_complete' => $this->Dashboard_model->get_need_complete_session(),
			'today_schedule' => $this->Booking_model->get_today_schedule(),
			'studio_status' => $this->Dashboard_model->get_studio_status(),
			'activities' => $this->Dashboard_model->get_recent_activities(),
			'membership' => $this->Dashboard_model->getMembershipSummary(),
			'top_addons' => $this->Dashboard_model->getTopAddons(),
		];
		// echo '<pre>';
		// print_r($data['revenueDaily_chart']);
		// exit();
		$this->display_page('dashboard_admin', $data);
	}

	private function dashboard_staff()
	{
		$data = [
			'role_id' => $this->role_id,
			'title' => 'Dashboard',
			'sub_title' => 'Dashboard Staff',
			'menu' => 'dashboard',
			'summary' => $this->Dashboard_model->getDashboardStaffSummary(),
			'waiting_verification' => $this->Dashboard_model->get_waiting_verification(),
			'need_start' => $this->Dashboard_model->get_need_start_session(),
			'need_complete' => $this->Dashboard_model->get_need_complete_session(),
			'today_schedule' => $this->Booking_model->get_today_schedule(),
			'studio_status' => $this->Dashboard_model->get_studio_status(),
			'activities' => $this->Dashboard_model->get_recent_activities(),
			'user' => $this->Dashboard_model->getUserInfo($this->id_user),
		];
		// echo '<pre>';
		// print_r($data);
		// exit();
		$this->display_page('dashboard_staff', $data);
	}

	private function dashboard_customer()
	{
		$data = [
			'role_id' => $this->role_id,
			'title' => 'Dashboard',
			'sub_title' => 'Dashboard Customer',
			'menu' => 'dashboard',
			'summary' => $this->Dashboard_model->getDashboardCustSummary($this->id_user),
			'membership' => $this->Dashboard_model->getMembershipInfo($this->id_user),
			'active_bookings' => $this->Dashboard_model->getActiveBookingUser($this->id_user),
			'transactions' => $this->Dashboard_model->getRecentTransactions($this->id_user),
			'favorite_package' => $this->Dashboard_model->getFavoritePackage($this->id_user),
			'favorite_studio' => $this->Dashboard_model->getFavoriteStudio($this->id_user)
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
