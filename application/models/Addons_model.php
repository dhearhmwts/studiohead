<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Addons_model extends CI_Model
{
    private $table = 'addons';
    private $column_order = [null, 'a.addon_name', 'a.price', 'a.stock', null, null, 'a.status', null];
    private $column_search = ['addon_name', 'category'];
    private $order = ['id_addon' => 'DESC'];

    private function _get_datatables_query()
    {
        $this->db->select("a.*, COALESCE(SUM(CASE WHEN b.booking_status IN ('pending','confirmed') THEN ba.qty ELSE 0 END), 0) AS used_stock");

        $this->db->from('addons a');
        $this->db->join('booking_addons ba', 'ba.id_addon=a.id_addon', 'left');
        $this->db->join('bookings b', 'b.id_booking=ba.id_booking', 'left');

        if ($this->input->post('addon_name'))
            $this->db->like('a.addon_name', $this->input->post('addon_name'));

        if ($this->input->post('category'))
            $this->db->where('a.category', $this->input->post('category'));

        if ($this->input->post('status'))
            $this->db->where('a.status', $this->input->post('status'));

        $this->db->group_by('a.id_addon');

        $availability = $this->input->post('availability');

        if ($availability == 'available')
            $this->db->having('(a.stock - used_stock) >', 0);

        if ($availability == 'out_of_stock')
            $this->db->having('(a.stock - used_stock) <=', 0);

        if (isset($_POST['order']))
            $this->db->order_by(
                $this->column_order[$_POST['order']['0']['column']],
                $_POST['order']['0']['dir']
            );
        else
            $this->db->order_by('a.id_addon', 'DESC');
    }

    public function get_datatables()
    {
        $this->_get_datatables_query();

        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        return $this->db->get()->result();
    }

    public function count_filtered()
    {
        $this->_get_datatables_query();
        return $this->db->get()->num_rows();
    }

    public function count_all()
    {
        return $this->db->count_all($this->table);
    }

    public function get_by_id($id_addon)
    {
        return $this->db->where('id_addon', $id_addon)->get($this->table)->row();
    }

    public function get_by_ids($id)
    {
        return $this->db->where_in('id_addon', $id)->get('addons')->result_array();
    }

    private function available_stock_sql()
    {
        return "(a.stock - COALESCE(SUM(
                    CASE
                        WHEN b.booking_status IN ('pending','confirmed')
                        THEN ba.qty
                        ELSE 0
                    END
                ),0))";
    }

    public function get_available()
    {
        $stock = $this->available_stock_sql();
        return $this->db
            ->select("a.id_addon, a.addon_name, a.price, {$stock} AS available_stock")
            ->from('addons a')
            ->join('booking_addons ba', 'ba.id_addon=a.id_addon', 'left')
            ->join('bookings b', 'b.id_booking=ba.id_booking', 'left')
            ->where('a.status', 'active')
            ->group_by('a.id_addon')
            ->having('available_stock >', 0)
            ->get()
            ->result_array();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id_addon, $data)
    {
        return $this->db->where('id_addon', $id_addon)->update($this->table, $data);
    }

    public function delete($id_addon)
    {
        return $this->db->where('id_addon', $id_addon)->delete($this->table);
    }
}
