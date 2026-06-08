<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Auth_model');
    }

    public function index()
    {
        if ($this->session->userdata('logged_in')) {
            $this->_redirect_by_role();
        }

        $this->load->view('login');
    }

    public function login()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('login');
            return;
        }

        $username = trim($this->input->post('username', TRUE));
        $password = $this->input->post('password');
        $user = $this->Auth_model->get_user_by_username($username);

        // validasi
        if (!$user) {
            $this->session->set_flashdata('error', 'Username atau Password salah');
            redirect('auth');
        }

        if ($user->status != 'active') {
            $this->session->set_flashdata('error', 'Akun tidak aktif');
            redirect('auth');
        }

        $encrypted_password = $this->Auth_model->encrypt_password($password);
        if ($encrypted_password !== $user->password) {
            $this->session->set_flashdata('error', 'Username atau Password salah');
            redirect('auth');
        }

        // session
        $session_data = [
            'id_user'   => $user->id,
            'role_id'   => $user->role_id,
            'username'  => $user->username,
            'fullname'  => $user->full_name,
            'logged_in' => TRUE
        ];

        $this->session->set_userdata($session_data);
        $this->_redirect_by_role();
    }

    public function logout()
    {
        $this->session->sess_destroy();
        redirect('auth');
    }

    private function _redirect_by_role()
    {
        $role_id = $this->session->userdata('role_id');
        switch ($role_id) {
            case 1:
                redirect('admin/dashboard');
                break;
            case 2:
                redirect('staff/dashboard');
                break;
            case 3:
                redirect('customer/dashboard');
                break;
            default:
                redirect('auth/logout');
                break;
        }
    }

    public function registrasi()
    {
        $this->load->view('registrasi');
    }

    public function signup()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('full_name', 'Nama Lengkap', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('phone', 'No HP', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('confirm_password', 'Konfirmasi Password', 'required|matches[password]');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('registrasi');
            return;
        }

        $username = $this->input->post('username', TRUE);
        if ($this->Auth_model->check_username($username) > 0) {
            $this->session->set_flashdata('error', 'Username sudah digunakan');
            redirect('auth/registrasi');
        }

        $email = $this->input->post('email', TRUE);
        if ($this->Auth_model->check_email($email) > 0) {
            $this->session->set_flashdata('error', 'Email sudah digunakan');
            redirect('auth/registrasi');
        }

        $data = [
            'id_role'         => 3,
            'username'        => $username,
            'full_name'       => $this->input->post('full_name', TRUE),
            'email'           => $email,
            'password'        => $this->Auth_model->encrypt_password($this->input->post('password')),
            'phone'           => $this->input->post('phone', TRUE),
            'profile_picture' => 'default.png',
            'status'          => 'active',
            'created_date'    => date('Y-m-d H:i:s'),
            'created_by'      => "REGISTER"
        ];

        $this->Auth_model->insert_user($data);

        $this->session->set_flashdata('success', 'Registrasi berhasil. Silakan login.');
        redirect('auth');
    }
}
