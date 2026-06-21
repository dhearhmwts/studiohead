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

    public function getUserInfo($id_user)
    {
        return $this->db
            ->select('*')
            ->from('users u')
            ->where('u.id_user', $id_user)
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

    public function getDashboardStaffSummary()
    {
        return [
            'waiting_verification' => $this->db
                ->where('payment_status', 'waiting_verification')
                ->count_all_results('payments'),

            'today_booking' => $this->db
                ->where('booking_date', date('Y-m-d'))
                ->where_in('booking_status', [
                    'approved',
                    'ongoing',
                    'completed'
                ])
                ->count_all_results('bookings'),

            'ongoing_session' => $this->db
                ->where('booking_status', 'ongoing')
                ->count_all_results('bookings'),

            'active_booking' => $this->db
                ->where_not_in('booking_status', [
                    'completed',
                    'cancelled'
                ])
                ->count_all_results('bookings')
        ];
    }

    public function get_waiting_verification($limit = 5)
    {
        return $this->db
            ->select("b.id_booking,b.booking_code,u.full_name,p.created_date")
            ->from('payments p')
            ->join('bookings b', 'b.id_booking=p.id_booking')
            ->join('users u', 'u.id_user=b.id_user')
            ->where('p.payment_status', 'waiting_verification')
            ->order_by('p.created_date', 'ASC')
            ->limit($limit)
            ->get()
            ->result_array();
    }

    public function get_need_start_session()
    {
        return $this->db
            ->select("b.id_booking,b.booking_code,u.full_name,s.studio_name,b.start_time, b.end_time")
            ->from('bookings b')
            ->join('users u', 'u.id_user=b.id_user')
            ->join('studios s', 's.id_studio=b.id_studio')
            ->where('b.booking_date', date('Y-m-d'))
            ->where('b.booking_status', 'approved')
            ->where('b.start_time <=', date('H:i:s'))
            ->order_by('b.start_time', 'ASC')
            ->get()
            ->result_array();
    }

    public function get_need_complete_session()
    {
        return $this->db
            ->select("b.id_booking,b.booking_code,u.full_name,s.studio_name,b.start_time, b.end_time")
            ->from('bookings b')
            ->join('users u', 'u.id_user=b.id_user')
            ->join('studios s', 's.id_studio=b.id_studio')
            ->where('b.booking_date', date('Y-m-d'))
            ->where('b.booking_status', 'ongoing')
            ->where('b.start_time <=', date('H:i:s'))
            ->order_by('b.start_time', 'ASC')
            ->get()
            ->result_array();
    }

    public function get_studio_status()
    {
        $studios = $this->db
            ->select('id_studio,studio_name')
            ->from('studios')
            ->where('status', 'active')
            ->get()
            ->result_array();

        foreach ($studios as &$studio) {

            $ongoing = $this->db
                ->select('booking_code')
                ->from('bookings')
                ->where('id_studio', $studio['id_studio'])
                ->where('booking_date', date('Y-m-d'))
                ->where('booking_status', 'ongoing')
                ->get()
                ->row_array();

            if ($ongoing) {
                $studio['status'] = 'ongoing';
                $studio['label'] = 'Ongoing';
                continue;
            }

            $next = $this->db
                ->select('start_time')
                ->from('bookings')
                ->where('id_studio', $studio['id_studio'])
                ->where('booking_date', date('Y-m-d'))
                ->where('booking_status', 'approved')
                ->where('start_time >', date('H:i:s'))
                ->order_by('start_time', 'ASC')
                ->limit(1)
                ->get()
                ->row_array();

            if ($next) {
                $studio['status'] = 'next';
                $studio['label'] = 'Next ' . $next['start_time'];
            } else {
                $studio['status'] = 'available';
                $studio['label'] = 'Available';
            }
        }

        return $studios;
    }

    public function get_recent_activities($limit = 10)
    {
        return $this->db
            ->select("bl.*, b.booking_code, u.full_name")
            ->from('booking_logs bl')
            ->join('bookings b', 'b.id_booking=bl.id_booking')
            ->join('users u', 'u.id_user=bl.changed_by', 'left')
            ->order_by('bl.changed_at', 'DESC')
            ->limit($limit)
            ->get()
            ->result_array();
    }

    public function getAdminSummary()
    {
        $currentMonth = date('Y-m');
        return [
            'total_booking' => $this->db
                ->count_all('bookings'),

            'today_booking' => $this->db
                ->where('DATE(booking_date)', date('Y-m-d'))
                ->count_all_results('bookings'),

            'active_studio' => $this->db
                ->where('status', 'active')
                ->count_all_results('studios'),

            'monthly_revenue' => $this->db
                ->select_sum('amount')
                ->like('payment_date', $currentMonth, 'after')
                ->where('payment_status', 'paid')
                ->get('payments')
                ->row()
                ->amount ?? 0
        ];
    }

    public function getBookingChart()
    {
        return $this->db
            ->select("DATE(booking_date) as booking_date, COUNT(*) as total_booking")
            ->from('bookings')
            ->where('booking_date >=', date('Y-m-d', strtotime('-30 days')))
            ->where_in('booking_status', [
                'approved',
                'ongoing',
                'completed'
            ])
            ->group_by('DATE(booking_date)')
            ->order_by('booking_date', 'ASC')
            ->get()
            ->result();
    }

    public function getRevenueChartDaily()
    {
        $rows = $this->db
            ->select("DATE(payment_date) as payment_date, SUM(amount) as total_revenue")
            ->from('payments')
            ->where('payment_date >=', date('Y-m-d', strtotime('-6 days')))
            ->where('payment_status', 'paid')
            ->group_by('DATE(payment_date)')
            ->get()
            ->result_array();

        $revenueMap = array_column($rows, 'total_revenue', 'payment_date');
        $result = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i} days"));
            $result[] = [
                'date' => $date,
                'total_revenue' => $revenueMap[$date] ?? 0
            ];
        }

        return $result;
    }

    public function getRevenueChart()
    {
        return $this->db
            ->select("DATE_FORMAT(payment_date,'%Y-%m') as month, SUM(amount) as total")
            ->from('payments')
            ->where('payment_status', 'paid')
            ->group_by("DATE_FORMAT(payment_date,'%Y-%m')")
            ->order_by('month', 'ASC')
            ->get()
            ->result();
    }

    public function getTopAddons()
    {
        return $this->db
            ->select("a.addon_name, COUNT(*) as total_used")
            ->from('booking_addons ba')
            ->join('addons a', 'a.id_addon=ba.id_addon')
            ->group_by('a.id_addon')
            ->order_by('total_used', 'DESC')
            ->limit(5)
            ->get()
            ->result();
    }

    public function getMembershipSummary()
    {
        return $this->db
            ->select("um.id_tier, mt.tier_name, COUNT(*) as total")
            ->from('user_memberships um')
            ->join('membership_tiers mt', 'mt.id_tier = um.id_tier', 'left')
            ->group_by('id_tier')
            ->get()
            ->result();
    }
}
