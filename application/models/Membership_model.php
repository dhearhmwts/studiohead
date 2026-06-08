<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Membership_model extends CI_Model
{
    private $table_tier = 'membership_tiers';
    private $table_user = 'user_memberships';

    public function get_all_tiers()
    {
        return $this->db
            ->order_by('min_transaction', 'ASC')
            ->get($this->table_tier)
            ->result_array();
    }

    public function get_tier_by_id($id_tier)
    {
        return $this->db
            ->where('id_tier', $id_tier)
            ->get($this->table_tier)
            ->row_array();
    }

    public function insert_tier($data)
    {
        $this->db->insert($this->table_tier, $data);
        return $this->db->insert_id();
    }

    public function update_tier($id_tier, $data)
    {
        return $this->db
            ->where('id_tier', $id_tier)
            ->update($this->table_tier, $data);
    }

    public function delete_tier($id_tier)
    {
        return $this->db
            ->where('id_tier', $id_tier)
            ->delete($this->table_tier);
    }

    public function get_membership_progress($id_user)
    {
        $membership = $this->get_user_membership($id_user);
        if (!$membership) {
            return null;
        }

        $next_tier = $this->get_next_tier($membership['total_transaction']);
        if (!$next_tier) {
            $membership['progress_percent'] = 100;
            $membership['remaining_transaction'] = 0;
            return $membership;
        }

        $membership['remaining_transaction'] = $next_tier['min_transaction'] - $membership['total_transaction'];
        $membership['progress_percent'] = ($membership['total_transaction'] / $next_tier['min_transaction']) * 100;
        $membership['next_tier_name'] = $next_tier['tier_name'];

        return $membership;
    }

    public function get_user_membership($id_user)
    {
        return $this->db
            ->select('
                um.*,
                mt.tier_name,
                mt.discount_percent,
                mt.priority_level,
                mt.bonus_hour
            ')
            ->from('user_memberships um')
            ->join('membership_tiers mt', 'mt.id_tier = um.id_tier')
            ->where('um.id_user', $id_user)
            ->get()
            ->row_array();
    }

    public function create_user_membership($data)
    {
        $this->db->insert($this->table_user, $data);
        return $this->db->insert_id();
    }

    public function update_user_membership($id_user, $data)
    {
        return $this->db
            ->where('id_user', $id_user)
            ->update($this->table_user, $data);
    }

    public function get_tier_by_transaction($total_transaction)
    {
        return $this->db
            ->where('status', 'active')
            ->where('min_transaction <=', $total_transaction)
            ->order_by('min_transaction', 'DESC')
            ->limit(1)
            ->get($this->table_tier)
            ->row_array();
    }

    public function update_customer_tier($id_user)
    {
        $membership = $this->db
            ->where('id_user', $id_user)
            ->get($this->table_user)
            ->row_array();

        if (!$membership) {
            return false;
        }

        $tier = $this->get_tier_by_transaction(
            $membership['total_transaction']
        );

        if (!$tier) {
            return false;
        }

        return $this->db
            ->where('id_user', $id_user)
            ->update(
                $this->table_user,
                [
                    'id_tier'      => $tier['id_tier'],
                    'updated_date' => date('Y-m-d H:i:s')
                ]
            );
    }

    public function get_next_tier($total_transaction)
    {
        return $this->db
            ->where('status', 'active')
            ->where('min_transaction >', $total_transaction)
            ->order_by('min_transaction', 'ASC')
            ->limit(1)
            ->get($this->table_tier)
            ->row_array();
    }
}
