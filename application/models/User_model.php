<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    public function get_by_id($id_user)
    {
        $res = $this->db->query("
            SELECT u.*, r.role_name, um.id_tier, um.joined_at, mt.tier_name
            FROM users u
            JOIN roles r ON r.id_role = u.id_role
            LEFT JOIN user_memberships um ON um.id_user = u.id_user
            LEFT JOIN membership_tiers mt ON mt.id_tier = um.id_tier
            WHERE u.id_user = ?
        ", [$id_user])->row();

        return $res;
    }

    public function update($id_user, $data)
    {
        return $this->db->where('id_user', $id_user)->update('users', $data);
    }
}
