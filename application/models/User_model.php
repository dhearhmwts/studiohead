<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User_model extends CI_Model
{
    private $table = 'users';

    private function _query()
    {
        $this->db->select('u.*,r.role_name');
        $this->db->from('users u');
        $this->db->join('roles r', 'r.id_role=u.id_role');

        if (!empty($_POST['username'])) $this->db->like('u.username', $_POST['username']);
        if (!empty($_POST['full_name'])) $this->db->like('u.full_name', $_POST['full_name']);
        if (!empty($_POST['role_id'])) $this->db->where('u.id_role', $_POST['role_id']);
        if (!empty($_POST['status'])) $this->db->where('u.status', $_POST['status']);

        $order_column = [
            '',
            'u.username',
            'u.full_name',
            'u.email',
            'r.role_name',
            'u.status',
            'u.created_date'
        ];

        if (isset($_POST['order'])) {
            $this->db->order_by($order_column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('u.id_user', 'DESC');
        }
    }

    public function get_datatable()
    {
        $this->_query();

        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        return $this->db->get()->result();
    }

    public function count_filtered()
    {
        $this->_query();
        return $this->db->get()->num_rows();
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function insert($data)
    {
        $this->db->insert('users', $data);
        $id_user = $this->db->insert_id();

        return $id_user;
    }

    public function get_by_id($id_user)
    {
        $sql = "SELECT u.*, r.role_name, 
                   um.id_tier, um.joined_at, um.total_transaction, um.total_booking_hours,
                   mt.tier_name, mt.discount_percent, mt.min_transaction
            FROM users u
            JOIN roles r ON r.id_role = u.id_role
            LEFT JOIN user_memberships um ON um.id_user = u.id_user
            LEFT JOIN membership_tiers mt ON mt.id_tier = um.id_tier
            WHERE u.id_user = ?";

        $user = $this->db->query($sql, [$id_user])->row();
        if (!$user) {
            return null;
        }

        if ($user->id_role == 3 && !empty($user->id_tier)) {
            $user->next_tier = $this->db->where('min_transaction >', $user->min_transaction)
                ->order_by('min_transaction', 'ASC')
                ->limit(1)
                ->get('membership_tiers')
                ->row();

            if ($user->next_tier) {
                $current_target = (float) $user->min_transaction;
                $next_target    = (float) $user->next_tier->min_transaction;
                $current_total  = (float) $user->total_transaction;

                // hitung progress dan limit nilai = rentang 0 - 100%
                $progress       = (($current_total - $current_target) / ($next_target - $current_target)) * 100;
                $user->progress = max(0, min(100, $progress));
                $user->remaining_transaction = max(0, $next_target - $current_total);
            } else {
                $user->progress = 100;
                $user->remaining_transaction = 0;
            }
        }
        // echo '<pre>';
        // print_r($user);
        // exit();
        return $user;
    }

    public function update($id_user, $data)
    {
        return $this->db->where('id_user', $id_user)->update('users', $data);
    }

    public function delete($id_user)
    {
        return $this->db->where('id_user', $id_user)->delete('users');
    }

    public function change_status($id_user)
    {
        $user = $this->db->where('id_user', $id_user)->get('users')->row();
        $status = $user->status == 'active' ? 'inactive' : 'active';

        return $this->db->where('id_user', $id_user)->update('users', ['status' => $status, 'updated_date' => date('Y-m-d H:i:s')]);
    }
}
