<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard_model extends CI_Model
{
    public function getUpcomingBooking($id_user)
    {
        return $this->db
            ->select('b.id_booking, b.booking_code, b.booking_date, b.start_time, b.end_time, b.booking_status, s.studio_name')
            ->from('bookings b')
            ->join('studios s', 's.id_studio = b.id_studio')
            ->where('b.id_user', $id_user)
            ->where_in('b.booking_status', ['pending', 'waiting_approval', 'approved'])
            ->order_by('b.booking_date', 'ASC')
            ->order_by('b.start_time', 'ASC')
            ->limit(3)
            ->get()
            ->row();
    }

    public function getMembershipInfo($id_user)
    {
        return $this->db
            ->select('mt.*, u.full_name, u.profile_picture')
            ->from('users u')
            ->join('user_memberships um', 'um.id_user = u.id_user', 'left')
            ->join('membership_tiers mt', 'mt.id_tier = um.id_tier', 'left')
            ->where('u.id_user', $id_user)
            ->get()
            ->row();
    }

    public function getBookingStatistics($id_user)
    {
        return $this->db
            ->select("
                COUNT(*) AS total_booking,
                SUM(CASE WHEN booking_status = 'completed' THEN 1 ELSE 0 END) AS completed,
                SUM(CASE WHEN booking_status IN ('pending', 'waiting_approval', 'approved') THEN 1 ELSE 0 END) AS upcoming,
                SUM(CASE WHEN booking_status = 'cancelled' THEN 1 ELSE 0 END) AS cancelled
            ", FALSE)
            ->from('bookings')
            ->where('id_user', $id_user)
            ->get()
            ->row();
    }

    public function getDashboardCustSummary($id_user)
    {
        $active_booking = $this->db
            ->where('id_user', $id_user)
            ->where_in('booking_status', ['Pending', 'Waiting Approval', 'Approved'])
            ->count_all_results('bookings');

        $completed_booking = $this->db
            ->where('id_user', $id_user)
            ->where('booking_status', 'Completed')
            ->count_all_results('bookings');

        $total_spending = $this->db
            ->select_sum('p.amount')
            ->from('payments p')
            ->join('bookings b', 'b.id_booking = p.id_booking')
            ->where('b.id_user', $id_user)
            ->where('p.payment_status', 'paid')
            ->get()
            ->row()
            ->amount ?? 0;

        return (object) [
            'active_booking'    => $active_booking,
            'completed_booking' => $completed_booking,
            'total_spending'    => $total_spending
        ];
    }

    public function getRecentTransactions($id_user, $limit = 6)
    {
        return $this->db
            ->select('p.id_payment, p.amount, p.payment_status, p.payment_date, b.booking_code, s.studio_name')
            ->from('payments p')
            ->join('bookings b', 'b.id_booking = p.id_booking')
            ->join('studios s', 's.id_studio = b.id_studio')
            ->where('b.id_user', $id_user)
            ->order_by('p.updated_date', 'DESC')
            ->limit($limit)
            ->get()
            ->result();
    }

    public function getFavoritePackage($id_user)
    {
        return $this->db
            ->select('p.id_package, p.package_name, p.price, p.duration_hour, COUNT(b.id_booking) total_booking')
            ->from('bookings b')
            ->join('packages p', 'p.id_package = b.id_package')
            ->where('b.id_user', $id_user)
            ->group_by('p.id_package')
            ->order_by('total_booking', 'DESC')
            ->limit(1)
            ->get()
            ->row();
    }

    public function getFavoriteStudio($id_user)
    {
        return $this->db
            ->select('s.id_studio, s.studio_name, s.thumbnail, COUNT(b.id_booking) total_booking, SUM(b.duration_hour) total_hour')
            ->from('bookings b')
            ->join('studios s', 's.id_studio = b.id_studio')
            ->where('b.id_user', $id_user)
            ->group_by('s.id_studio')
            ->order_by('total_booking', 'DESC')
            ->limit(1)
            ->get()
            ->row();
    }

    public function getActiveBookingUser($id_user, $limit = 5)
    {
        return $this->db
            ->select('b.id_booking, b.booking_code, b.booking_date, b.start_time, b.end_time, b.booking_status, s.studio_name
            ')
            ->from('bookings b')
            ->join('studios s', 's.id_studio = b.id_studio')
            ->where('b.id_user', $id_user)
            ->where_in('b.booking_status', [
                'Pending',
                'Waiting Approval',
                'Approved'
            ])
            ->order_by('b.booking_date', 'ASC')
            ->order_by('b.start_time', 'ASC')
            ->limit($limit)
            ->get()
            ->result();
    }
}
