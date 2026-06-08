<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Customer extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Memastikan user sudah login dan role-nya adalah Customer (3)
        //if (!$this->session->userdata('logged_in') || $this->session->userdata('role_id') != 3) {
        //    $this->session->set_flashdata('error', 'Silakan login terlebih dahulu.');
        //    redirect('auth');
        //}
    }

    public function dashboard()
    {
        // Mengambil data nama dari session login untuk dipajang di dashboard
        $data['fullname'] = $this->session->userdata('fullname');
        
        // Memuat halaman tampilan dashboard
        $this->load->view('customer/dashboard', $data);
    }
}