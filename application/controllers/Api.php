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
// ==========================================
    // INTI API GET: STUDIOS, PACKAGES, ADDONS, MEMBERSHIP
    // ==========================================

    // 1. Ambil Semua Daftar Studio
    public function get_all_studios() {
        $data = $this->db->get('studios')->result();
        $this->output
             ->set_content_type('application/json')
             ->set_output(json_encode([
                 'status' => 'success',
                 'data' => $data
             ]));
    }

    // 2. Ambil Satu Studio Berdasarkan ID
    public function get_studio_by_id($id) {
        $data = $this->db->get_where('studios', ['id_studio' => $id])->row();
        if ($data) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'data' => $data]));
        } else {
            $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode(['status' => 'error', 'message' => 'Studio tidak ditemukan']));
        }
    }

    // 3. Ambil Semua Daftar Paket (Packages)
    public function get_all_packages() {
        $data = $this->db->get('packages')->result();
        $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }

    // 4. Ambil Satu Paket Berdasarkan ID
    public function get_package_by_id($id) {
        $data = $this->db->get_where('packages', ['id_package' => $id])->row();
        if ($data) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'data' => $data]));
        } else {
            $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode(['status' => 'error', 'message' => 'Paket tidak ditemukan']));
        }
    }

    // 5. Ambil Semua Daftar Addons
    public function get_all_addons() {
        $data = $this->db->get('addons')->result();
        $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'data' => $data]));
    }

    // 6. Ambil Satu Addon Berdasarkan ID
    public function get_addon_by_id($id) {
        $data = $this->db->get_where('addons', ['id_addon' => $id])->row();
        if ($data) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'data' => $data]));
        } else {
            $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode(['status' => 'error', 'message' => 'Addon tidak ditemukan']));
        }
    }

    // 7. Ambil Satu Tingkat Membership Berdasarkan ID
    public function get_membership_by_id($id) {
        $data = $this->db->get_where('membership_tiers', ['id_tier' => $id])->row();
        if ($data) {
            $this->output->set_content_type('application/json')->set_output(json_encode(['status' => 'success', 'data' => $data]));
        } else {
            $this->output->set_content_type('application/json')->set_status_header(404)->set_output(json_encode(['status' => 'error', 'message' => 'Tingkat membership tidak ditemukan']));
        }
    }
    }