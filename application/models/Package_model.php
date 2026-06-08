<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Package_model extends CI_Model
{
    private $table = 'packages';
    private $column_order = [null, 'package_name', 'duration_hour', 'price', null];
    private $column_search = ['package_name'];
    private $order = ['id_package' => 'DESC'];

    private function _get_datatables_query()
    {
        $this->db->from('packages');

        if ($this->input->post('package_name'))
            $this->db->like('package_name', $this->input->post('package_name'));

        if (isset($_POST['order']))
            $this->db->order_by(
                $this->column_order[$_POST['order']['0']['column']],
                $_POST['order']['0']['dir']
            );
        else
            $this->db->order_by('id_package', 'DESC');
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
        return $this->db->count_all('packages');
    }

    public function get_all()
    {
        return $this->db
            ->select("
                        p.*,
                        COUNT(DISTINCT pi.id_package_item) total_item,
                        GROUP_CONCAT(
                            DISTINCT a.addon_name
                            ORDER BY a.addon_name
                            SEPARATOR ', '
                        ) items,
                        GROUP_CONCAT(
                            DISTINCT a.id_addon
                            ORDER BY a.id_addon
                            SEPARATOR ','
                        ) addon_ids,
                        GROUP_CONCAT(
                            DISTINCT LOWER(a.addon_name)
                            ORDER BY a.addon_name
                            SEPARATOR ','
                        ) addon_names
                    ")
            ->from('packages p')
            ->join('package_items pi', 'pi.id_package=p.id_package', 'left')
            ->join('addons a', 'a.id_addon=pi.id_addon', 'left')
            ->group_by('p.id_package')
            ->order_by('p.id_package', 'DESC')
            ->get()
            ->result_array();
    }

    public function get_by_id($id_package)
    {
        return $this->db
            ->where('id_package', $id_package)
            ->get('packages')
            ->row_array();
    }

    public function get_items($id_package)
    {
        return $this->db
            ->select("pi.*, a.addon_name, a.category, a.price addon_price")
            ->from('package_items pi')
            ->join('addons a', 'a.id_addon=pi.id_addon')
            ->where('pi.id_package', $id_package)
            ->order_by('a.addon_name', 'ASC')
            ->get()
            ->result_array();
    }

    public function get_addons()
    {
        return $this->db
            ->where('status', 'active')
            ->order_by('addon_name', 'ASC')
            ->get('addons')
            ->result_array();
    }

    public function insert($data)
    {
        $this->db->insert('packages', $data);
        return $this->db->insert_id();
    }

    public function update($id_package, $data)
    {
        return $this->db
            ->where('id_package', $id_package)
            ->update('packages', $data);
    }

    public function delete($id_package)
    {
        $this->db
            ->where('id_package', $id_package)
            ->delete('package_items');

        return $this->db
            ->where('id_package', $id_package)
            ->delete('packages');
    }

    public function insert_items($data)
    {
        return $this->db->insert_batch('package_items', $data);
    }

    public function delete_items($id_package)
    {
        return $this->db
            ->where('id_package', $id_package)
            ->delete('package_items');
    }

    public function get_package_detail($id_package)
    {
        return $this->db
            ->select("p.*, COUNT(pi.id_package_item) total_item")
            ->from('packages p')
            ->join('package_items pi', 'pi.id_package=p.id_package', 'left')
            ->where('p.id_package', $id_package)
            ->group_by('p.id_package')
            ->get()
            ->row_array();
    }
}
