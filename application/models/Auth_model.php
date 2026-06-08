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
        $this->db->trans_start();
        $this->db->insert('users', $data);
        $id_user = $this->db->insert_id();
        $bronze = $this->db->where('LOWER(tier_name)', 'bronze')->get('membership_tiers')->row();
        if ($bronze) {
            $this->db->insert('user_memberships', [
                'id_user'           => $id_user,
                'id_tier'           => $bronze->id_tier,
                'total_booking'     => 0,
                'total_transaction' => 0,
                'joined_at'         => date('Y-m-d H:i:s')
            ]);
        }
        $this->db->trans_complete();
        return $this->db->trans_status();
    }
}
