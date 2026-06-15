<?php
defined('BASEPATH') or exit('No direct script access allowed');

function booking_badge($status)
{
    $class = [
        'pending' => 'warning',
        'waiting_approval' => 'info',
        'approved' => 'primary',
        'ongoing' => 'success',
        'completed' => 'dark',
        'cancelled' => 'danger'
    ];

    return '<span class="badge bg-' . $class[$status] . '">' .
        ucwords(str_replace('_', ' ', $status)) .
        '</span>';
}

function payment_badge($status)
{
    $class = [
        'unpaid' => 'warning',
        'waiting' => 'info',
        'paid' => 'success',
        'rejected' => 'danger'
    ];

    return '<span class="badge bg-' . $class[$status] . '">' .
        ucwords(str_replace('_', ' ', $status)) .
        '</span>';
}
