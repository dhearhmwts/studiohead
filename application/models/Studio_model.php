<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Studio_model extends CI_Model
{
    public function get_all($name = '', $type = '', $status = '')
    {
        $this->db->select('s.*, GROUP_CONCAT(si.image_path) as all_images');
        $this->db->from('studios s');
        $this->db->join('studio_images si', 'si.id_studio=s.id_studio', 'left');

        if ($name != '') $this->db->like('s.studio_name', $name);
        if ($type != '')  $this->db->where('s.studio_type', $type);
        if ($status != '') $this->db->where('s.status', $status);

        $this->db->group_by('s.id_studio');
        $this->db->order_by('s.studio_name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_all_active($name = '', $type = '', $status = '')
    {
        $this->db->select('s.*, GROUP_CONCAT(si.image_path) as all_images');
        $this->db->from('studios s');
        $this->db->join('studio_images si', 'si.id_studio=s.id_studio', 'left');

        if ($name != '') $this->db->like('s.studio_name', $name);
        if ($type != '')  $this->db->where('s.studio_type', $type);
        $this->db->where('s.status', 'active');

        $this->db->group_by('s.id_studio');
        $this->db->order_by('s.studio_name', 'ASC');
        return $this->db->get()->result_array();
    }

    public function get_by_id($id_studio)
    {
        return $this->db->where('id_studio', $id_studio)->get('studios')->row_array();
    }

    public function insert($data)
    {
        $this->db->insert('studios', $data);
        return $this->db->insert_id();
    }

    public function update($id_studio, $data)
    {
        return $this->db->where('id_studio', $id_studio)->update('studios', $data);
    }

    public function delete($id_studio)
    {
        return $this->db->where('id_studio', $id_studio)->delete('studios');
    }

    public function get_images($id_studio)
    {
        return $this->db->where('id_studio', $id_studio)->order_by('sort_order', 'ASC')->get('studio_images')->result_array();
    }

    public function insert_images($data)
    {
        return $this->db->insert_batch('studio_images', $data);
    }

    public function delete_images($id_studio)
    {
        return $this->db->where('id_studio', $id_studio)->delete('studio_images');
    }

    public function get_thumbnail($id_studio)
    {
        return $this->db->where('id_studio', $id_studio)->where('is_thumbnail', 1)->get('studio_images')->row_array();
    }

    public function count_all()
    {
        return $this->db->count_all('studios');
    }

    public function count_active()
    {
        return $this->db->where('status', 'active')->count_all_results('studios');
    }

    public function count_inactive()
    {
        return $this->db->where('status', 'inactive')->count_all_results('studios');
    }
}
