<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking_model extends CI_Model
{
    protected $table = 'bookings';

    public function insert($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function insertAddons($data)
    {
        return $this->db->insert_batch('booking_addons', $data);
    }

    public function insertLog($id_booking, $status_from, $status_to, $changed_by)
    {
        return $this->db->insert('booking_logs', [
            'id_booking'   => $id_booking,
            'changed_by'   => $changed_by,
            'status_from'  => $status_from,
            'status_to'    => $status_to,
            'changed_at'   => date('Y-m-d H:i:s'),
            'created_date' => date('Y-m-d H:i:s'),
            'created_by'   => $changed_by
        ]);
    }

    public function getById($id_booking)
    {
        return $this->db->where('id_booking', $id_booking)->get($this->table)->row();
    }

    public function getByCode($booking_code)
    {
        return $this->db->where('booking_code', $booking_code)->get($this->table)->row();
    }

    public function getCustomerBookings($id_user)
    {
        return $this->db
            ->select('b.*, s.studio_name')
            ->from('bookings b')
            ->join('studios s', 's.id_studio = b.id_studio')
            ->where('b.id_user', $id_user)
            ->order_by('b.booking_date', 'DESC')
            ->get()
            ->result();
    }

    public function update($id_booking, $data)
    {
        return $this->db->where('id_booking', $id_booking)->update($this->table, $data);
    }

    public function checkSchedule($id_studio, $booking_date, $start_time, $end_time)
    {
        return $this->db
            ->where('id_studio', $id_studio)
            ->where('booking_date', $booking_date)
            ->where("booking_status IN ('pending','waiting_approval','approved','ongoing')")
            ->group_start()
            ->where('start_time <', $end_time)
            ->where('end_time >', $start_time)
            ->group_end()
            ->count_all_results('bookings');
    }

    public function generateCode()
    {
        $date = date('Ymd');

        $last = $this->db
            ->like('booking_code', 'BK-' . $date, 'after')
            ->order_by('id_booking', 'DESC')
            ->get('bookings')
            ->row();

        if ($last) {
            $number = substr($last->booking_code, -4);
            $number++;
        } else {
            $number = 1;
        }

        return 'BK-' . $date . '-' . str_pad($number, 4, '0', STR_PAD_LEFT);
    }

    public function getBookingAddons($id_booking)
    {
        return $this->db
            ->select('ba.*, a.addon_name')
            ->from('booking_addons ba')
            ->join('addons a', 'a.id_addon = ba.id_addon')
            ->where('ba.id_booking', $id_booking)
            ->get()
            ->result_array();
    }

    public function getDetail($id_booking)
    {
        return $this->db
            ->select("b.*, s.studio_name, s.category, s.capacity, s.thumbnail, p.package_name, p.description AS package_description, pay.id_payment, pay.payment_method, pay.transfer_proof, pay.amount, pay.payment_status, pay.payment_date, pay.expired_at, pay.note, u.full_name")
            ->from('bookings b')
            ->join('studios s', 's.id_studio=b.id_studio')
            ->join('users u', 'u.id_user=b.id_user')
            ->join('packages p', 'p.id_package=b.id_package', 'left')
            ->join('payments pay', 'pay.id_booking=b.id_booking', 'left')
            ->where('b.id_booking', $id_booking)
            ->get()
            ->row_array();
    }

    public function getBookingLogs($id_booking)
    {
        return $this->db
            ->order_by('changed_at', 'ASC')
            ->get_where('booking_logs', [
                'id_booking' => $id_booking
            ])
            ->result_array();
    }

    // datatable - list booking user
    private $datatable = 'bookings b';
    private $column_order = [null, 'b.booking_code', 's.studio_name', 'b.booking_date', 'b.start_time', 'b.total_price', 'b.booking_status', 'pay.payment_status'];
    private $column_search = ['b.booking_code', 's.studio_name'];
    private $order = ['b.id_booking' => 'DESC'];

    private function _get_mybooking_query()
    {
        $this->db->select("b.id_booking, b.booking_code, b.booking_date, b.start_time, b.end_time, b.total_price, b.booking_status, s.studio_name, pay.payment_status");
        $this->db->from($this->datatable);
        $this->db->join('studios s', 's.id_studio=b.id_studio');
        $this->db->join('payments pay', 'pay.id_booking=b.id_booking', 'left');
        $this->db->where('b.id_user', $this->session->userdata('id_user'));

        if ($this->input->post('booking_status'))
            $this->db->where('b.booking_status', $this->input->post('booking_status'));

        if ($this->input->post('payment_status'))
            $this->db->where('pay.payment_status', $this->input->post('payment_status'));

        if ($this->input->post('date_from'))
            $this->db->where('b.booking_date >=', $this->input->post('date_from'));

        if ($this->input->post('date_to'))
            $this->db->where('b.booking_date <=', $this->input->post('date_to'));

        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by(key($this->order), $this->order[key($this->order)]);
        }
    }

    public function get_mybooking()
    {
        $this->_get_mybooking_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        return $this->db->get()->result();
    }

    public function count_filtered_mybooking()
    {
        $this->_get_mybooking_query();
        return $this->db->get()->num_rows();
    }

    public function count_all_mybooking()
    {
        $this->db->from('bookings');
        $this->db->where('id_user', $this->session->userdata('id_user'));
        return $this->db->count_all_results();
    }

    public function get_mybooking_summary($id_user)
    {
        $total = $this->db
            ->where('id_user', $id_user)
            ->count_all_results('bookings');

        $upcoming = $this->db
            ->where('id_user', $id_user)
            ->where_in('booking_status', ['pending', 'waiting_approval', 'approved'])
            ->count_all_results('bookings');

        $unpaid = $this->db
            ->from('bookings b')
            ->join('payments p', 'p.id_booking = b.id_booking')
            ->where('b.id_user', $id_user)
            ->where('p.payment_status', 'unpaid')
            ->count_all_results();

        $completed = $this->db
            ->where('id_user', $id_user)
            ->where('booking_status', 'completed')
            ->count_all_results('bookings');

        return [
            'total'     => $total,
            'upcoming'  => $upcoming,
            'unpaid'    => $unpaid,
            'completed' => $completed
        ];
    }

    // list payment approval
    private $payment_column_order = [null, 'b.booking_code', 'u.full_name', 's.studio_name', 'b.booking_date', 'pay.amount', 'pay.payment_date'];
    private $payment_column_search = ['b.booking_code', 'u.full_name', 's.studio_name'];

    private function _get_payment_approval_query()
    {
        $this->db->select("b.id_booking, b.booking_code, b.booking_date, b.start_time, b.booking_status, u.full_name, s.studio_name, pay.id_payment, pay.amount, pay.payment_status, pay.payment_date, pay.transfer_proof");

        $this->db->from('payments pay');
        $this->db->join('bookings b', 'b.id_booking=pay.id_booking');
        $this->db->join('users u', 'u.id_user=b.id_user');
        $this->db->join('studios s', 's.id_studio=b.id_studio');

        $this->db->where('pay.payment_status', 'waiting');

        if ($this->input->post('booking_code'))
            $this->db->like('b.booking_code', $this->input->post('booking_code'));

        if ($this->input->post('customer'))
            $this->db->like('u.full_name', $this->input->post('customer'));

        if ($this->input->post('studio'))
            $this->db->where('s.id_studio', $this->input->post('studio'));

        if ($this->input->post('date_from'))
            $this->db->where('b.booking_date >=', $this->input->post('date_from'));

        if ($this->input->post('date_to'))
            $this->db->where('b.booking_date <=', $this->input->post('date_to'));

        $i = 0;
        foreach ($this->payment_column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->payment_column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->payment_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('pay.payment_date', 'ASC');
        }
    }

    public function get_payment_approval()
    {
        $this->_get_payment_approval_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);

        return $this->db->get()->result();
    }

    public function count_filtered_payment_approval()
    {
        $this->_get_payment_approval_query();
        return $this->db->get()->num_rows();
    }

    public function count_all_payment_approval()
    {
        return $this->db
            ->where('payment_status', 'waiting_verification')
            ->count_all_results('payments');
    }

    public function get_payment_detail($id_booking)
    {
        return $this->db
            ->select("b.*, u.full_name, u.email, s.studio_name, s.thumbnail, pay.id_payment, pay.amount, pay.payment_status, pay.transfer_proof, pay.payment_date")
            ->from('bookings b')
            ->join('users u', 'u.id_user=b.id_user')
            ->join('studios s', 's.id_studio=b.id_studio')
            ->join('payments pay', 'pay.id_booking=b.id_booking')
            ->where('b.id_booking', $id_booking)
            ->get()
            ->row_array();
    }

    public function get_payment_approval_summary()
    {
        $today = date('Y-m-d');
        return [
            'waiting_verification' => $this->db
                ->where('payment_status', 'waiting')
                ->count_all_results('payments'),
            'approved_today' => $this->db
                ->where('payment_status', 'paid')
                ->like('verified_at', $today, 'after')
                ->count_all_results('payments'),
            'rejected_today' => $this->db
                ->where('payment_status', 'rejected')
                ->like('updated_date', $today, 'after')
                ->count_all_results('payments')
        ];
    }

    // list booking
    private $booking_list_column_order = [null, 'b.booking_code', 'u.full_name', 's.studio_name', 'b.booking_date', 'b.start_time', 'b.booking_status', 'p.payment_status'];
    private $booking_list_column_search = ['b.booking_code', 'u.full_name', 's.studio_name'];

    private function _get_booking_list_query()
    {
        $this->db->select("b.id_booking, b.booking_code, b.booking_date, b.start_time, b.end_time, b.total_price,b.booking_status, u.full_name, s.studio_name, p.payment_status");

        $this->db->from('bookings b');
        $this->db->join('users u', 'u.id_user=b.id_user');
        $this->db->join('studios s', 's.id_studio=b.id_studio');
        $this->db->join('payments p', 'p.id_booking=b.id_booking', 'left');

        if ($this->input->post('booking_status'))
            $this->db->where('b.booking_status', $this->input->post('booking_status'));

        if ($this->input->post('payment_status'))
            $this->db->where('p.payment_status', $this->input->post('payment_status'));

        if ($this->input->post('studio'))
            $this->db->where('b.id_studio', $this->input->post('studio'));

        if ($this->input->post('date_from'))
            $this->db->where('b.booking_date >=', $this->input->post('date_from'));

        if ($this->input->post('date_to'))
            $this->db->where('b.booking_date <=', $this->input->post('date_to'));

        $i = 0;
        foreach ($this->booking_list_column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->booking_list_column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->booking_list_column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else {
            $this->db->order_by('b.booking_date', 'DESC');
        }
    }

    public function get_booking_list()
    {
        $this->_get_booking_list_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'],  $_POST['start']);

        return $this->db->get()->result();
    }

    public function count_filtered_booking_list()
    {
        $this->_get_booking_list_query();
        return $this->db->get()->num_rows();
    }

    public function count_all_booking_list()
    {
        return $this->db->count_all('bookings');
    }

    public function get_booking_list_summary()
    {
        return [
            'pending' => $this->db
                ->where_in('booking_status', ['pending', 'waiting'])
                ->count_all_results('bookings'),
            'approved' => $this->db
                ->where('booking_status', 'approved')
                ->count_all_results('bookings'),
            'ongoing' => $this->db
                ->where('booking_status', 'ongoing')
                ->count_all_results('bookings'),
            'completed' => $this->db
                ->where('booking_status', 'completed')
                ->count_all_results('bookings')
        ];
    }

    // booking calendar
    public function get_today_schedule()
    {
        return $this->db
            ->select("b.id_booking, b.booking_code, b.booking_date, b.start_time, b.end_time, b.duration_hour, b.total_price, b.booking_status, u.full_name, s.id_studio, s.studio_name, s.category")
            ->from('bookings b')
            ->join('users u', 'u.id_user=b.id_user')
            ->join('studios s', 's.id_studio=b.id_studio')
            ->where('b.booking_date', date('Y-m-d'))
            ->where_in('b.booking_status', [
                'approved',
                'ongoing',
                'completed'
            ])
            ->order_by('b.start_time', 'ASC')
            ->get()
            ->result_array();
    }

    public function get_schedule_summary()
    {
        return [
            'approved' => $this->db
                ->where('booking_date', date('Y-m-d'))
                ->where('booking_status', 'approved')
                ->count_all_results('bookings'),

            'ongoing' => $this->db
                ->where('booking_date', date('Y-m-d'))
                ->where('booking_status', 'ongoing')
                ->count_all_results('bookings'),

            'completed' => $this->db
                ->where('booking_date', date('Y-m-d'))
                ->where('booking_status', 'completed')
                ->count_all_results('bookings'),

            'total' => $this->db
                ->where('booking_date', date('Y-m-d'))
                ->where_in('booking_status', [
                    'approved',
                    'ongoing',
                    'completed'
                ])
                ->count_all_results('bookings')
        ];
    }

    public function get_schedule_detail($id_booking)
    {
        return $this->db
            ->select("b.*,u.full_name,u.email,u.phone,s.studio_name,s.category,p.payment_status,pk.package_name")
            ->from('bookings b')
            ->join('users u', 'u.id_user=b.id_user')
            ->join('studios s', 's.id_studio=b.id_studio')
            ->join('payments p', 'p.id_booking=b.id_booking', 'left')
            ->join('packages pk', 'pk.id_package=b.id_package', 'left')
            ->where('b.id_booking', $id_booking)
            ->get()
            ->row_array();
    }

    public function get_schedule_addons($id_booking)
    {
        return $this->db
            ->select("ba.qty, ba.price, a.addon_name")
            ->from('booking_addons ba')
            ->join('addons a', 'a.id_addon=ba.id_addon')
            ->where('ba.id_booking', $id_booking)
            ->get()
            ->result_array();
    }

    public function get_schedule_logs($id_booking)
    {
        return $this->db
            ->select("bl.*, u.full_name")
            ->from('booking_logs bl')
            ->join('users u', 'u.id_user=bl.changed_by', 'left')
            ->where('bl.id_booking', $id_booking)
            ->order_by('bl.changed_at', 'ASC')
            ->get()
            ->result_array();
    }
}
