<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Booking extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model([
            'Booking_model',
            'Membership_model',
            'Studio_model',
            'Package_model',
            'Addons_model'
        ]);

        $this->expire_payment();

        if (!$this->session->userdata('id_user')) {
            redirect('auth');
        }
    }

    public function create()
    {
        $role_id = $this->session->userdata('role_id');

        $data = [
            'role_id' => $role_id,
            'title' => "Booking&nbsp;&nbsp;/&nbsp;&nbsp;Booking Studio",
            'sub_title' => "Select Studio",
            'menu' => 'booking',
            'studios' => $this->Studio_model->get_all_active()
        ];

        $this->display_page('booking', $data);
    }

    public function create_booking($id_studio)
    {
        $role_id = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id_user');
        $membership_det = $this->Membership_model->get_user_membership($user_id);
        $tier = $membership_det['tier_name'];

        $max_day = 2;
        switch (strtolower($tier)) {
            case 'silver':
                $max_day = 6;
                break;
            case 'gold':
                $max_day = 13;
                break;
            case 'platinum':
                $max_day = 29;
                break;
            case 'vip':
                $max_day = 89;
                break;
        }

        $data = [
            'role_id' => $role_id,
            'title' => "Booking&nbsp;&nbsp;/&nbsp;&nbsp;Booking Studio",
            'sub_title' => "Booking Detail",
            'menu' => 'booking',
            'studio' => $this->Studio_model->get_by_id($id_studio),
            'member_disc' => $membership_det['discount_percent'],
            'packages' => $this->Package_model->get_all(),
            'addons' => $this->Addons_model->get_available(),
            'min_date' => date('Y-m-d'),
            'max_date' => date('Y-m-d', strtotime("+{$max_day} days")),
        ];
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->display_page('detail_booking', $data);
    }

    public function booknow()
    {
        if (!$this->input->is_ajax_request()) show_404();

        $id_user      = $this->session->userdata('id_user');
        $id_studio    = (int)$this->input->post('id_studio');
        $id_package   = $this->input->post('id_package') ?: null;
        $booking_date = $this->input->post('booking_date');
        $start_time   = $this->input->post('start_time');
        $duration     = (int)$this->input->post('duration');
        $addons       = $this->input->post('addons') ?: [];

        if (!$booking_date || !$start_time || $duration < 1) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Data booking tidak lengkap'
                ]));
        }

        if ($booking_date < date('Y-m-d')) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Tanggal booking tidak valid'
                ]));
        }

        $end_time = date('H:i', strtotime($start_time . " +{$duration} hour"));
        $cek_studio = $this->Booking_model->checkSchedule($id_studio, $booking_date, $start_time, $end_time);
        if ($cek_studio > 0) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Jadwal studio sudah terisi. Silahkan pilih kembali waktu lain'
                ]));
        }

        $studio = $this->Studio_model->get_by_id($id_studio);
        if (!$studio) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Studio tidak ditemukan'
                ]));
        }
        $studio_fee = $studio['price_per_hour'] * $duration;

        $package_fee = 0;
        if (!empty($id_package)) {

            $package = $this->Package_model->get_by_id($id_package);

            if ($package) {
                $package_fee = $package['price'];
            }
        }

        $addon_fee = 0;
        $addon_data = [];
        if (!empty($addons)) {
            $addon_data = $this->Addons_model->get_by_ids($addons);
            foreach ($addon_data as $addon) {
                $addon_fee += $addon['price'];
            }
        }

        $subtotal = $studio_fee + $package_fee + $addon_fee;
        $discount = 0;
        $total_price = $subtotal - $discount;

        $this->db->trans_begin();

        $booking = [
            'booking_code'   => $this->Booking_model->generateCode(),
            'id_user'        => $id_user,
            'id_studio'      => $id_studio,
            'id_package'     => $id_package,
            'booking_date'   => $booking_date,
            'start_time'     => $start_time,
            'end_time'       => $end_time,
            'duration_hour'  => $duration,
            'subtotal'       => $subtotal,
            'discount'       => $discount,
            'total_price'    => $total_price,
            'booking_status' => 'pending',
            'created_date'   => date('Y-m-d H:i:s'),
            'created_by'     => $id_user
        ];

        $id_booking = $this->Booking_model->insert($booking);
        if (!empty($addon_data)) {
            $batch = [];
            foreach ($addon_data as $addon) {
                $batch[] = [
                    'id_booking'   => $id_booking,
                    'id_addon'     => $addon['id_addon'],
                    'qty'          => 1,
                    'price'        => $addon['price'],
                    'subtotal'     => $addon['price'],
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by'   => $id_user
                ];
            }
            $this->db->insert_batch(
                'booking_addons',
                $batch
            );
        }

        $this->db->insert('booking_logs', [
            'id_booking'   => $id_booking,
            'changed_by'   => $id_user,
            'status_from'  => null,
            'status_to'    => 'pending',
            'changed_at'   => date('Y-m-d H:i:s'),
            'created_date' => date('Y-m-d H:i:s'),
            'created_by'   => $id_user
        ]);

        $this->db->insert('payments', [
            'id_booking'     => $id_booking,
            'amount'         => $total_price,
            'payment_status' => 'unpaid',
            'expired_at'     => date('Y-m-d H:i:s', strtotime('+30 minutes')),
            'created_date'   => date('Y-m-d H:i:s'),
            'created_by'     => $id_user
        ]);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Booking gagal dibuat'
                ]));
        }

        $this->db->trans_commit();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'message' => 'Booking berhasil dibuat',
                'redirect' => site_url(
                    'booking/detail/' . $id_booking
                )
            ]));
    }

    public function expire_payment()
    {
        $this->db->trans_begin();

        $payments = $this->db
            ->select('p.*, b.id_booking')
            ->from('payments p')
            ->join('bookings b', 'b.id_booking=p.id_booking')
            ->where('p.payment_status', 'unpaid')
            ->where('p.expired_at <=', date('Y-m-d H:i:s'))
            ->get()
            ->result_array();

        foreach ($payments as $payment) {
            $this->db
                ->where('id_booking', $payment['id_booking'])
                ->update('bookings', [
                    'booking_status' => 'cancelled',
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => 'SYSTEM'
                ]);

            $this->db
                ->where('id_payment', $payment['id_payment'])
                ->update('payments', [
                    'payment_status' => 'rejected',
                    'note' => 'Pembayaran tidak dilakukan dalam batas waktu yang ditentukan',
                    'updated_date' => date('Y-m-d H:i:s'),
                    'updated_by' => 'SYSTEM'
                ]);

            $this->db->insert('booking_logs', [
                'id_booking' => $payment['id_booking'],
                'changed_by' => 'SYSTEM',
                'status_from' => 'pending',
                'status_to' => 'cancelled',
                'changed_at' => date('Y-m-d H:i:s'),
                'created_date' => date('Y-m-d H:i:s'),
                'created_by' => 'SYSTEM'
            ]);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
        } else {
            $this->db->trans_commit();
        }
    }

    public function detail($id_booking)
    {
        $role_id = $this->session->userdata('role_id');
        $user_id = $this->session->userdata('id_user');

        $booking = $this->Booking_model->getDetail($id_booking);
        if (!$booking) {
            show_404();
        }

        if ($booking['id_user'] != $user_id && $role_id == 2) {
            show_404();
        }

        $data = [
            'role_id' => $role_id,
            'title' => "Booking&nbsp;&nbsp;/&nbsp;&nbsp;Booking Studio&nbsp;&nbsp;/&nbsp;&nbsp;Booking Detail",
            'sub_title' => "Preview",
            'menu' => 'booking',
            'booking' => $booking,
            'addons' => $this->Booking_model->getBookingAddons($id_booking),
            'logs' => $this->Booking_model->getBookingLogs($id_booking)
        ];
        // echo '<pre>';
        // print_r($data);
        // exit();
        $this->display_page('preview_booking', $data);
    }

    public function mybooking()
    {
        $role_id = $this->session->userdata('role_id');
        $id_user = $this->session->userdata('id_user');

        $data = [
            'role_id' => $role_id,
            'title' => 'Booking',
            'sub_title' => 'My Booking',
            'menu' => 'booking',
            'summary' => $this->Booking_model->get_mybooking_summary($id_user)
        ];

        $this->display_page('my_booking', $data);
    }

    public function getMyBooking()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $list = $this->Booking_model->get_mybooking();
        $data = [];
        $no   = $this->input->post('start', TRUE) ?? 0;

        foreach ($list as $row) {
            $no++;

            if ($row->booking_status === 'pending') {
                $booking_status = '<span class="badge px-2.5 py-1 rounded bg-warning text-dark fw-bold text-uppercase" style="font-size: 10px;">Pending</span>';
            } elseif ($row->booking_status === 'waiting_approval') {
                $booking_status = '<span class="badge px-2.5 py-1 rounded bg-info text-white fw-bold text-uppercase" style="font-size: 10px;">Waiting Approval</span>';
            } elseif ($row->booking_status === 'approved') {
                $booking_status = '<span class="badge px-2.5 py-1 rounded bg-success text-white fw-bold text-uppercase" style="font-size: 10px;">Approved</span>';
            } elseif ($row->booking_status === 'ongoing') {
                $booking_status = '<span class="badge px-2.5 py-1 rounded bg-primary text-white fw-bold text-uppercase" style="font-size: 10px;">Ongoing</span>';
            } elseif ($row->booking_status === 'completed') {
                $booking_status = '<span class="badge px-2.5 py-1 rounded bg-dark text-white fw-bold text-uppercase" style="font-size: 10px;">Completed</span>';
            } else {
                $booking_status = '<span class="badge px-2.5 py-1 rounded bg-danger text-white fw-bold text-uppercase" style="font-size: 10px;">Cancelled</span>';
            }

            if ($row->payment_status === 'unpaid') {
                $payment_status = '<span class="badge px-2.5 py-1 rounded bg-warning text-dark fw-bold text-uppercase" style="font-size: 10px;">Unpaid</span>';
            } elseif ($row->payment_status === 'waiting' || $row->payment_status === 'waiting_verification') {
                $payment_status = '<span class="badge px-2.5 py-1 rounded bg-info text-white fw-bold text-uppercase" style="font-size: 10px;">Waiting</span>';
            } elseif ($row->payment_status === 'paid') {
                $payment_status = '<span class="badge px-2.5 py-1 rounded bg-success text-white fw-bold text-uppercase" style="font-size: 10px;">Paid</span>';
            } else {
                $payment_status = '<span class="badge px-2.5 py-1 rounded bg-danger text-white fw-bold text-uppercase" style="font-size: 10px;">Rejected</span>';
            }

            $data[] = [
                $no,
                '<span class="fw-bold text-dark">' . $row->booking_code . '</span>',
                $row->studio_name,
                date('d M Y', strtotime($row->booking_date)),
                substr($row->start_time, 0, 5) . ' - ' . substr($row->end_time, 0, 5),
                '<span class="fw-semibold text-dark">Rp' . number_format($row->total_price, 0, ',', '.') . '</span>',
                $booking_status,
                $payment_status,
                '<a href="' . site_url('booking/detail/' . $row->id_booking) . '" class="btn btn-dark btn-sm rounded-3 shadow-xs px-3">Detail</a>'
            ];
        }

        $output = [
            "draw"            => $this->input->post('draw', TRUE),
            "recordsTotal"    => $this->Booking_model->count_all_mybooking(),
            "recordsFiltered" => $this->Booking_model->count_filtered_mybooking(),
            "data"            => $data
        ];

        $this->output->set_content_type('application/json')->set_output(json_encode($output));
    }

    public function upload_payment($id_booking)
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $booking = $this->Booking_model->getDetail($id_booking);

        if (!$booking) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Data booking tidak ditemukan'
                ]));
        }

        if ($booking['payment_status'] != 'unpaid') {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Bukti pembayaran sudah pernah dikirim'
                ]));
        }

        if (empty($_FILES['transfer_proof']['name'])) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Pilih file bukti transfer terlebih dahulu'
                ]));
        }

        $config['upload_path']   = './uploads/payments/';
        $config['allowed_types'] = 'jpg|jpeg|png|pdf';
        $config['encrypt_name']  = true;
        $config['max_size']      = 5120;

        $this->load->library('upload', $config);
        if (!$this->upload->do_upload('transfer_proof')) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => strip_tags(
                        $this->upload->display_errors()
                    )
                ]));
        }

        $file = $this->upload->data();
        $this->db->trans_begin();
        $this->db
            ->where('id_booking', $id_booking)
            ->update('bookings', [
                'booking_status' => 'waiting_approval',
                'updated_date' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('id_user')
            ]);

        $this->db
            ->where('id_booking', $id_booking)
            ->update('payments', [
                'transfer_proof' => $file['file_name'],
                'payment_status' => 'waiting',
                'payment_date' => date('Y-m-d H:i:s'),
                'updated_date' => date('Y-m-d H:i:s'),
                'updated_by' => $this->session->userdata('id_user')
            ]);

        $this->db->insert('booking_logs', [
            'id_booking' => $id_booking,
            'changed_by' => $this->session->userdata('id_user'),
            'status_from' => 'pending',
            'status_to' => 'waiting_approval',
            'changed_at' => date('Y-m-d H:i:s'),
            'created_date' => date('Y-m-d H:i:s'),
            'created_by' => $this->session->userdata('id_user')
        ]);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Upload bukti pembayaran gagal'
                ]));
        }

        $this->db->trans_commit();
        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'message' => 'Bukti pembayaran berhasil dikirim'
            ]));
    }

    public function paymentApproval()
    {
        $role_id = $this->session->userdata('role_id');

        $data = [
            'role_id' => $role_id,
            'title' => 'Booking&nbsp;&nbsp;/&nbsp;&nbsp;Payment Approval',
            'sub_title' => 'Waiting Verification',
            'menu' => 'payment',
            'studios' => $this->Studio_model->get_all_active(),
            'summary' => $this->Booking_model->get_payment_approval_summary()
        ];

        $this->display_page('payment_approval', $data);
    }

    public function getPaymentApproval()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $list = $this->Booking_model->get_payment_approval();
        $data = [];
        $no = $_POST['start'];
        foreach ($list as $row) {
            $no++;
            $data[] = [
                $no,
                $row->booking_code,
                $row->full_name,
                $row->studio_name,
                date('d M Y', strtotime($row->booking_date)),
                'Rp ' . number_format($row->amount, 0, ',', '.'),
                date('d M Y H:i', strtotime($row->payment_date)),
                '<span class="badge bg-info">Waiting Verification</span>',
                '
                <button
                    type="button"
                    class="btn btn-dark btn-sm btn-review"
                    data-id="' . $row->id_booking . '">
                    Review
                </button>
            '
            ];
        }

        echo json_encode([
            'draw' => $_POST['draw'],
            'recordsTotal' => $this->Booking_model->count_all_payment_approval(),
            'recordsFiltered' => $this->Booking_model->count_filtered_payment_approval(),
            'data' => $data
        ]);
    }

    public function getPaymentDetail()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_booking = $this->input->post('id_booking');
        $data = $this->Booking_model->get_payment_detail($id_booking);
        if (!$data) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]));
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'data' => $data
            ]));
    }

    public function verifyPayment()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $staff_id = $this->session->userdata('id_user');
        $id_booking = $this->input->post('id_booking');
        $action = $this->input->post('action');
        $note = $this->input->post('note');

        $booking = $this->Booking_model->get_payment_detail($id_booking);
        if (!$booking) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ]));
        }

        $this->db->trans_begin();
        if ($action == 'approve') {
            $this->db
                ->where('id_booking', $id_booking)
                ->update('bookings', [
                    'booking_status' => 'approved',
                    'updated_by' => $staff_id,
                    'updated_date' => date('Y-m-d H:i:s')
                ]);

            $this->db
                ->where('id_booking', $id_booking)
                ->update('payments', [
                    'payment_status' => 'paid',
                    'verified_by' => $staff_id,
                    'verified_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $staff_id,
                    'updated_date' => date('Y-m-d H:i:s')
                ]);

            $this->Booking_model->insertLog($id_booking, 'waiting_approval', 'approved', $staff_id);
        } else {
            $this->db
                ->where('id_booking', $id_booking)
                ->update('bookings', [
                    'booking_status' => 'pending',
                    'updated_by' => $staff_id,
                    'updated_date' => date('Y-m-d H:i:s')
                ]);

            $this->db
                ->where('id_booking', $id_booking)
                ->update('payments', [
                    'payment_status' => 'rejected',
                    'note' => $note,
                    'verified_by' => $staff_id,
                    'verified_at' => date('Y-m-d H:i:s'),
                    'updated_by' => $staff_id,
                    'updated_date' => date('Y-m-d H:i:s')
                ]);

            $this->Booking_model->insertLog($id_booking, 'waiting_approval', 'cancelled', $staff_id);
        }

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Verifikasi pembayaran gagal'
                ]));
        }
        $this->db->trans_commit();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'message' => 'Verifikasi pembayaran berhasil'
            ]));
    }

    public function list()
    {
        $role_id = $this->session->userdata('role_id');

        $data = [
            'role_id' => $role_id,
            'title' => 'Booking&nbsp;&nbsp;/&nbsp;&nbsp;Booking List',
            'sub_title' => 'Manage Booking',
            'menu' => 'booking_list',
            'studios' => $this->Studio_model->get_all_active(),
            'summary' => $this->Booking_model->get_booking_list_summary()
        ];

        $this->display_page('booking_list', $data);
    }

    public function getBookingList()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $list = $this->Booking_model->get_booking_list();
        $data = [];
        $no   = $_POST['start'];

        foreach ($list as $row) {
            $no++;

            if ($row->booking_status === 'pending') {
                $booking_status = '<span class="badge px-3 py-1.5 rounded-pill bg-warning text-dark fw-bold text-uppercase text-xxs shadow-none">Pending</span>';
            } elseif ($row->booking_status === 'waiting_approval') {
                $booking_status = '<span class="badge px-3 py-1.5 rounded-pill bg-info text-white fw-bold text-uppercase text-xxs shadow-none">Waiting Approval</span>';
            } elseif ($row->booking_status === 'approved') {
                $booking_status = '<span class="badge px-3 py-1.5 rounded-pill bg-success text-white fw-bold text-uppercase text-xxs shadow-none">Approved</span>';
            } elseif ($row->booking_status === 'ongoing') {
                $booking_status = '<span class="badge px-3 py-1.5 rounded-pill bg-primary text-white fw-bold text-uppercase text-xxs shadow-none">Ongoing</span>';
            } elseif ($row->booking_status === 'completed') {
                $booking_status = '<span class="badge px-3 py-1.5 rounded-pill bg-dark text-white fw-bold text-uppercase text-xxs shadow-none">Completed</span>';
            } else {
                $booking_status = '<span class="badge px-3 py-1.5 rounded-pill bg-danger text-white fw-bold text-uppercase text-xxs shadow-none">Cancelled</span>';
            }

            if ($row->payment_status === 'unpaid') {
                $payment_status = '<span class="badge px-3 py-1.5 rounded-pill bg-warning text-dark fw-bold text-uppercase text-xxs shadow-none">Unpaid</span>';
            } elseif ($row->payment_status === 'waiting' || $row->payment_status === 'waiting_verification') {
                $payment_status = '<span class="badge px-3 py-1.5 rounded-pill bg-info text-white fw-bold text-uppercase text-xxs shadow-none">Waiting</span>';
            } elseif ($row->payment_status === 'paid') {
                $payment_status = '<span class="badge px-3 py-1.5 rounded-pill bg-success text-white fw-bold text-uppercase text-xxs shadow-none">Paid</span>';
            } else {
                $payment_status = '<span class="badge px-3 py-1.5 rounded-pill bg-danger text-white fw-bold text-uppercase text-xxs shadow-none">Rejected</span>';
            }

            $action = '
            <div class="d-flex gap-2 justify-content-center align-items-center">
                <button type="button" title="Detail" 
                        class="btn btn-icon-only btn-sm btn-outline-dark btn-delete mb-0 d-flex align-items-center justify-content-center rounded-circle btn-detail"
                        data-id="' . $row->id_booking . '"
                        style="width:30px; height:30px;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">visibility</span>
                </button>';

            if (in_array($row->booking_status, ['pending', 'waiting_approval', 'approved'])) {
                $action .= '
                <button type="button" title="Reschedule"
                        class="btn btn-icon-only btn-sm btn-outline-warning btn-delete mb-0 d-flex align-items-center justify-content-center rounded-circl btn-reschedule"
                        data-id="' . $row->id_booking . '"
                        style="width:30px; height:30px;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">update</span>
                </button>

                <button type="button" title="Cancel" 
                        class="btn btn-icon-only btn-sm btn-outline-danger btn-delete mb-0 d-flex align-items-center justify-content-center rounded-circle btn-cancel" 
                        data-id="' . $row->id_booking . '"
                        style="width:30px; height:30px;">
                    <span class="material-symbols-outlined" style="font-size: 16px;">block</span>
                </button>';
            }

            $action .= '</div>';

            $data[] = [
                $no,
                '<span class="fw-bold text-dark text-sm">' . $row->booking_code . '</span>',
                '<div class="fw-semibold text-dark text-sm">' . $row->full_name . '</div>',
                '<div class="text-secondary text-sm">' . $row->studio_name . '</div>',
                '<div class="text-dark text-sm">' . date('d M Y', strtotime($row->booking_date)) . '</div>',
                '<span class="badge bg-light text-dark border text-xxs px-2 py-1"><span class="material-symbols-outlined align-middle text-xxs me-1">schedule</span>' . substr($row->start_time, 0, 5) . ' - ' . substr($row->end_time, 0, 5) . '</span>',
                $booking_status,
                $payment_status,
                $action
            ];
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                "draw"            => intval($_POST['draw']),
                "recordsTotal"    => $this->Booking_model->count_all_booking_list(),
                "recordsFiltered" => $this->Booking_model->count_filtered_booking_list(),
                "data"            => $data,
            ]));
    }

    public function getBookingDetail()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_booking = $this->input->post('id_booking');
        $booking = $this->Booking_model->getDetail($id_booking);
        if (!$booking) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode([
                    'status' => false,
                    'message' => 'Data booking tidak ditemukan'
                ]));
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode([
                'status' => true,
                'data' => $booking,
                'addons' => $this->Booking_model->getBookingAddons($id_booking),
                'logs' => $this->Booking_model->getBookingLogs($id_booking)
            ]));
    }

    public function cancelBooking()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $staff_id   = $this->session->userdata('id_user');
        $id_booking = $this->input->post('id_booking');
        $reason     = trim($this->input->post('reason'));
        $booking    = $this->Booking_model->getDetail($id_booking);
        if (!$booking) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Data booking tidak ditemukan']));
        }

        if (in_array($booking['booking_status'], ['completed', 'cancelled'])) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Booking tidak dapat dibatalkan']));
        }

        $this->db->trans_begin();
        $this->db
            ->where('id_booking', $id_booking)
            ->update('bookings', [
                'booking_status' => 'cancelled',
                'updated_by'     => $staff_id,
                'updated_date'   => date('Y-m-d H:i:s')
            ]);

        $this->Booking_model->insertLog($id_booking, $booking['booking_status'], 'cancelled', $staff_id);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Booking gagal dibatalkan']));
        }
        $this->db->trans_commit();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => true, 'message' => 'Booking berhasil dibatalkan']));
    }

    public function rescheduleBooking()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $staff_id     = $this->session->userdata('id_user');
        $id_booking   = $this->input->post('id_booking');
        $booking_date = $this->input->post('booking_date');
        $start_time   = $this->input->post('start_time');
        $note         = trim($this->input->post('note'));

        $booking      = $this->Booking_model->getDetail($id_booking);
        if (!$booking) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Data booking tidak ditemukan']));
        }

        if (in_array($booking['booking_status'], ['ongoing', 'completed', 'cancelled'])) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Booking tidak dapat direschedule']));
        }

        $end_time = date('H:i', strtotime($start_time . " +{$booking['duration_hour']} hour"));
        $cek = $this->Booking_model->checkSchedule($booking['id_studio'], $booking_date, $start_time, $end_time);
        // print_r($this->db->last_query());
        // exit();
        if ($cek > 0) {
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Jadwal studio bentrok dengan booking lain']));
        }

        $this->db->trans_begin();
        $this->db
            ->where('id_booking', $id_booking)
            ->update('bookings', [
                'booking_date' => $booking_date,
                'start_time'   => $start_time,
                'end_time'     => $end_time,
                'updated_by'   => $staff_id,
                'updated_date' => date('Y-m-d H:i:s')
            ]);

        $this->Booking_model->insertLog($id_booking, $booking['booking_status'], $booking['booking_status'] . "- reschedule", $staff_id);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['status' => false, 'message' => 'Reschedule gagal']));
        }

        $this->db->trans_commit();

        return $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['status' => true, 'message' => 'Jadwal booking berhasil diperbarui']));
    }

    public function calendar()
    {
        $role_id = $this->session->userdata('role_id');
        $studios = $this->db->get('studios')->result_array();
        $summary = $this->Booking_model->get_schedule_summary();

        $data = [
            'role_id'        => $role_id,
            'title'          => "Booking&nbsp;&nbsp;/&nbsp;&nbsp;Booking Calendar",
            'sub_title'      => "Today's Schedule",
            'menu'           => "booking_cal",
            'studios'        => $studios,
            'summary'        => $summary,
            'total_bookings' => $summary['total'] ?? 0
        ];

        $this->display_page('booking_calendar', $data);
    }

    public function getCalendarEvents()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $events = [];
        $bookings = $this->Booking_model->get_today_schedule();
        foreach ($bookings as $booking) {
            $events[] = [
                'id'         => $booking['id_booking'],
                'resourceId' => $booking['id_studio'],
                'title'      => $booking['booking_code'] . ' - ' . $booking['full_name'],
                'start'      => $booking['booking_date'] . 'T' . $booking['start_time'],
                'end'        => $booking['booking_date'] . 'T' . $booking['end_time'],
                'status'     => $booking['booking_status']
            ];
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($events));
    }

    public function getScheduleDetail()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $id_booking = $this->input->post('id_booking');
        $booking = $this->Booking_model->get_schedule_detail($id_booking);
        if (!$booking) {
            $response = [
                'status' => false,
                'message' => 'Booking tidak ditemukan'
            ];
        } else {
            $response = [
                'status' => true,
                'booking' => $booking,
                'addons' => $this->Booking_model->get_schedule_addons($id_booking),
                'logs' => $this->Booking_model->get_schedule_logs($id_booking)
            ];
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));
    }

    public function startSession()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $staff_id = $this->session->userdata('id_user');
        $id_booking = $this->input->post('id_booking');

        $booking = $this->Booking_model->get_schedule_detail($id_booking);

        $response = [
            'status' => false,
            'message' => 'Terjadi kesalahan'
        ];

        if (!$booking) {
            $response['message'] = 'Booking tidak ditemukan';
        } elseif ($booking['booking_status'] != 'approved') {
            $response['message'] = 'Booking tidak dapat dimulai';
        } else {
            $this->db->trans_begin();
            $this->db
                ->where('id_booking', $id_booking)
                ->update('bookings', [
                    'booking_status' => 'ongoing',
                    'updated_by' => $staff_id,
                    'updated_date' => date('Y-m-d H:i:s')
                ]);

            $this->Booking_model->insertLog($id_booking, 'approved', 'ongoing', $staff_id);
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $response['message'] = 'Gagal memulai sesi';
            } else {
                $this->db->trans_commit();
                $response = [
                    'status' => true,
                    'message' => 'Session berhasil dimulai'
                ];
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));
    }

    public function completeSession()
    {
        if (!$this->input->is_ajax_request()) {
            show_404();
        }

        $staff_id = $this->session->userdata('id_user');
        $id_booking = $this->input->post('id_booking');

        $booking = $this->Booking_model->get_schedule_detail($id_booking);

        $response = [
            'status' => false,
            'message' => 'Terjadi kesalahan'
        ];

        if (!$booking) {
            $response['message'] = 'Booking tidak ditemukan';
        } elseif ($booking['booking_status'] != 'ongoing') {
            $response['message'] = 'Booking belum berlangsung';
        } else {
            $this->db->trans_begin();
            $this->db
                ->where('id_booking', $id_booking)
                ->update('bookings', [
                    'booking_status' => 'completed',
                    'updated_by' => $staff_id,
                    'updated_date' => date('Y-m-d H:i:s')
                ]);

            $this->Booking_model->insertLog($id_booking, 'ongoing', 'completed', $staff_id);
            if ($this->db->trans_status() === false) {
                $this->db->trans_rollback();
                $response['message'] = 'Gagal menyelesaikan sesi';
            } else {
                $this->db->trans_commit();
                $response = [
                    'status' => true,
                    'message' => 'Booking berhasil diselesaikan'
                ];
            }
        }

        return $this->output
            ->set_content_type('application/json')
            ->set_status_header(200)
            ->set_output(json_encode($response));
    }

    private function display_page($main_content, $data = null)
    {
        $this->load->view("header", $data);
        $this->load->view($main_content);
        $this->load->view("footer");
    }
}
