<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    private $table = 'users';
    private $secret_key = 'Stud10Head@2026#Booking';

    public function get_user_by_username($username)
    {
        return $this->db->where('username', $username)->get($this->table)->row();
    }

    public function encrypt_password($password)
    {
        return hash('sha256', md5($password . $this->secret_key));
    }

    public function check_username($username)
    {
        return $this->db->where('username', $username)->count_all_results('users');
    }

    public function check_email($email)
    {
        return $this->db->where('email', $email)->count_all_results('users');
    }

    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }
}
