<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Packages extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Package_model');

        if (!$this->session->userdata('logged_in'))
            redirect('auth/logout');
    }

    public function index()
    {
        $role_id = $this->session->userdata('role_id');

        $data = [
            'role_id' => $role_id,
            'title' => 'Packages Management',
            'sub_title' => 'List Package',
            'menu' => 'packages',
            'packages' => $this->Package_model->get_all(),
            'addons' => $this->Package_model->get_addons()
        ];

        $this->display_page('package', $data);
    }

    public function view()
    {
        $role_id = $this->session->userdata('role_id');

        $data = [
            'role_id' => $role_id,
            'title' => 'Packages',
            'sub_title' => 'List Package',
            'menu' => 'packages',
            'packages' => $this->Package_model->get_all(),
            'addons' => $this->Package_model->get_addons()
        ];

        $this->display_page('package_view', $data);
    }

    public function get_detail()
    {
        $id_package = $this->input->post('id_package');

        $data = [
            'package' => $this->Package_model->get_by_id($id_package),
            'items' => $this->Package_model->get_items($id_package)
        ];

        echo json_encode($data);
    }

    public function save()
    {
        $id_package = $this->input->post('id_package');

        $data = [
            'package_name' => trim($this->input->post('package_name', TRUE)),
            'description' => $this->input->post('description'),
            'duration_hour' => $this->input->post('duration_hour'),
            'price' => str_replace(',', '', $this->input->post('price')),
            'updated_date' => date('Y-m-d H:i:s'),
            'updated_by' => $this->session->userdata('id_user')
        ];

        if (!empty($_FILES['thumbnail']['name'])) {
            if (!is_dir('./uploads/packages/'))
                mkdir('./uploads/packages/', 0777, true);

            $config = [
                'upload_path' => './uploads/packages/',
                'allowed_types' => 'jpg|jpeg|png|webp',
                'encrypt_name' => TRUE,
                'max_size' => 2048
            ];

            $this->load->library('upload', $config);

            if ($this->upload->do_upload('thumbnail')) {
                $upload = $this->upload->data();
                $data['thumbnail'] = $upload['file_name'];
            }
        }

        if (empty($id_package)) {
            $data['created_date'] = date('Y-m-d H:i:s');
            $data['created_by'] = $this->session->userdata('id_user');

            $id_package = $this->Package_model->insert($data);
        } else {
            $this->Package_model->update($id_package, $data);
            $this->Package_model->delete_items($id_package);
        }

        $addons = $this->input->post('id_addon');
        $qtys = $this->input->post('qty');

        if (!empty($addons)) {
            $items = [];

            foreach ($addons as $key => $id_addon) {
                if (empty($id_addon)) continue;

                $items[] = [
                    'id_package' => $id_package,
                    'id_addon' => $id_addon,
                    'qty' => !empty($qtys[$key]) ? $qtys[$key] : 1,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('id_user'),
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => $this->session->userdata('id_user')
                ];
            }

            if (!empty($items))
                $this->Package_model->insert_items($items);
        }

        echo json_encode([
            'status' => TRUE,
            'message' => 'Package berhasil disimpan'
        ]);
    }

    public function delete()
    {
        $id_package = $this->input->post('id_package');

        $this->Package_model->delete($id_package);

        echo json_encode([
            'status' => TRUE,
            'message' => 'Package berhasil dihapus'
        ]);
    }

    private function display_page($content, $data = null)
    {
        $this->load->view('header', $data);
        $this->load->view($content, $data);
        $this->load->view('footer');
    }
}
