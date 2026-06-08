<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Membership extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Membership_model');
    }

    public function index()
    {
        $role_id = $this->session->userdata('role_id');

        $role_id = $this->session->userdata('role_id');

        $data = [
            'role_id' => $role_id,
            'title' => "Membership/Loyalty Tier Management",
            'sub_title' => "List Membership Tier",
            'menu' => "membership",
            'tiers' => $this->Membership_model->get_all_tiers(),
        ];

        $this->display_page('membership', $data);
    }

    public function get_detail()
    {
        $id_tier = $this->input->post('id_tier');
        $tier = $this->Membership_model->get_tier_by_id($id_tier);
        echo json_encode($tier);
    }

    public function save()
    {
        $id_tier = $this->input->post('id_tier');

        $data = [
            'tier_name'         => trim($this->input->post('tier_name')),
            'min_transaction'   => $this->input->post('min_transaction'),
            'discount_percent'  => $this->input->post('discount_percent'),
            'priority_level'    => $this->input->post('priority_level'),
            'bonus_hour'        => $this->input->post('bonus_hour'),
            'status'            => $this->input->post('status'),
            'updated_date'      => date('Y-m-d H:i:s'),
            'updated_by'        => $this->session->userdata('id_user')
        ];

        if (empty($id_tier)) {
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('id_user');

            $this->Membership_model->insert_tier($data);
            echo json_encode(['status' => TRUE, 'message' => 'Tier membership berhasil ditambahkan']);
        } else {
            $this->Membership_model->update_tier($id_tier, $data);
            echo json_encode(['status' => TRUE, 'message' => 'Tier membership berhasil diperbarui']);
        }
    }

    public function change_status()
    {
        $id_tier = $this->input->post('id_tier');

        $tier = $this->Membership_model->get_tier_by_id($id_tier);
        if (!$tier) {
            echo json_encode(['status' => FALSE, 'message' => 'Data tidak ditemukan']);
            return;
        }

        $new_status = $tier['status'] == 'active' ? 'inactive' : 'active';
        $this->Membership_model->update_tier(
            $id_tier,
            [
                'status' => $new_status,
                'updated_by' => $this->session->userdata('id_user')
            ]
        );

        echo json_encode(['status' => TRUE, 'message' => 'Status berhasil diperbarui']);
    }

    public function delete()
    {
        $id_tier = $this->input->post('id_tier');

        $used = $this->db->where('id_tier', $id_tier)->count_all_results('user_memberships');
        if ($used > 0) {
            echo json_encode(['status' => FALSE, 'message' => 'Tier masih digunakan oleh customer']);
            return;
        }

        $this->Membership_model->delete_tier($id_tier);
        echo json_encode(['status' => TRUE, 'message' => 'Tier berhasil dihapus']);
    }

    public function recalculate_all_membership()
    {
        $memberships = $this->db->get('user_memberships')->result_array();
        foreach ($memberships as $row) {
            $this->Membership_model->update_customer_tier($row['id_user']);
        }

        echo json_encode(['status' => TRUE, 'message' => 'Membership customer berhasil diperbarui']);
    }

    private function display_page($main_content, $data = null)
    {
        $this->load->view("header", $data);
        $this->load->view($main_content);
        $this->load->view("footer");
    }
}
