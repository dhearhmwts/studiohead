<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // Memuat model autentikasi utama
        $this->load->model('Auth_model');
        
        // Memastikan output dari controller ini selalu berformat JSON resmi
        header('Content-Type: application/json');
    }

    // --- 1. POST /api/register ---
    // URL Akses: http://localhost/TEKWEB/studiohead/api/register
    public function register()
    {
        $username   = $this->input->post('username', TRUE);
        $full_name  = $this->input->post('full_name', TRUE);
        $email      = $this->input->post('email', TRUE);
        $phone      = $this->input->post('phone', TRUE);
        $password   = $this->input->post('password');

        // Validasi data tidak boleh kosong
        if (empty($username) || empty($full_name) || empty($email) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Semua field wajib diisi']);
            return;
        }

        // Cek duplikasi username
        if ($this->Auth_model->check_username($username) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Username sudah digunakan']);
            return;
        }

        // Cek duplikasi email
        if ($this->Auth_model->check_email($email) > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Email sudah digunakan']);
            return;
        }

        // Menyusun data baru untuk dimasukkan ke tabel database
        $data = [
            'id_role'         => 3, // Otomatis sebagai Customer sesuai setelan tim dan database
            'username'        => $username,
            'full_name'       => $full_name,
            'email'           => $email,
            'password'        => $this->Auth_model->encrypt_password($password),
            'phone'           => $phone,
            'profile_picture' => 'default.png',
            'status'          => 'active',
            'created_date'    => date('Y-m-d H:i:s'),
            'created_by'      => 'API_REGISTER'
        ];

        if ($this->Auth_model->insert_user($data)) {
            echo json_encode(['status' => 'success', 'message' => 'Registrasi via API Berhasil']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ke database']);
        }
    }

    // --- 2. POST /api/login ---
    // URL Akses: http://localhost/TEKWEB/studiohead/api/login
    public function login()
    {
        $username = $this->input->post('username', TRUE);
        $password = $this->input->post('password');

        if (empty($username) || empty($password)) {
            echo json_encode(['status' => 'error', 'message' => 'Username dan Password wajib diisi']);
            return;
        }

        // Ambil data user dari database berdasarkan username
        $user = $this->Auth_model->get_user_by_username($username);

        if (!$user) {
            echo json_encode(['status' => 'error', 'message' => 'Username atau Password salah']);
            return;
        }

        if ($user->status != 'active') {
            echo json_encode(['status' => 'error', 'message' => 'Akun Anda tidak aktif']);
            return;
        }

        // Verifikasi password terenkripsi hash bawaan tim
        $encrypted_password = $this->Auth_model->encrypt_password($password);
        if ($encrypted_password !== $user->password) {
            echo json_encode(['status' => 'error', 'message' => 'Username atau Password salah']);
            return;
        }

        // Membuat tanda pengenal session login di sistem (sudah disamakan dengan database)
        $session_data = [
            'id_user'   => $user->id_user, 
            'role_id'   => $user->id_role,
            'username'  => $user->username,
            'fullname'  => $user->full_name,
            'logged_in' => TRUE
        ];
        $this->session->set_userdata($session_data);

        // Mengembalikan data JSON sukses untuk frontend temanmu (sudah disamakan dengan database)
        echo json_encode([
            'status' => 'success',
            'message' => 'Login via API Berhasil',
            'user' => [
                'id_user'  => $user->id_user,
                'role_id'  => $user->id_role,
                'username' => $user->username,
                'fullname' => $user->full_name
            ]
        ]);
    }

    // --- 3. POST /api/logout ---
    // URL Akses: http://localhost/TEKWEB/studiohead/api/logout
    public function logout()
    {
        $this->session->sess_destroy();
        echo json_encode(['status' => 'success', 'message' => 'Logout via API Berhasil']);
    }
}