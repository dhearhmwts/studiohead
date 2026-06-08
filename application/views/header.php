<!--
=========================================================
* Material Dashboard 3 - v3.2.0
=========================================================

* Product Page: https://www.creative-tim.com/product/material-dashboard
* Copyright 2024 Creative Tim (https://www.creative-tim.com)
* Licensed under MIT (https://www.creative-tim.com/license)
* Coded by Creative Tim

=========================================================

* The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
-->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/apple-icon.png') ?>">
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/logo.png') ?>">
  <title>
    StudioHead
  </title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="<?= base_url('assets/css/nucleo-icons.css') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/nucleo-svg.css') ?>" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <link id="pagestyle" href="<?= base_url('assets/css/material-dashboard.css?v=3.2.0') ?>" rel="stylesheet" />

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
<style>
  .table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 0 !important;
    margin-left: 2px !important;
    border: none !important;
    background: transparent !important;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: transparent !important;
    border: none !important;
  }

  ul.pagination {
    margin-bottom: 0;
    align-items: center;
  }

  .page-item.active .page-link {
    background-image: linear-gradient(195deg, #42424a 0%, #191919 100%) !important;
    border-color: #344767 !important;
    color: #fff !important;
    border-radius: 50% !important;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .page-link {
    padding: 0;
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #7b809a !important;
    border-radius: 50% !important;
    margin: 0 2px;
    border: none !important;
    background-color: transparent !important;
  }

  .page-link:hover {
    background-color: #eee !important;
    border-radius: 50% !important;
  }

  .dataTables_info {
    margin-left: 20px;
    font-size: 0.775rem !important;
    color: #7b809a !important;
    font-weight: 400;
  }

  ::-webkit-scrollbar {
    width: 6px;
    height: 6px;
  }

  ::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 10px;
  }

  ::-webkit-scrollbar-thumb {
    background: #c1c1c1;
    border-radius: 10px;
    transition: background 0.3s ease;
  }

  ::-webkit-scrollbar-thumb:hover {
    background: #a8a8a8;
  }

  .table-responsive::-webkit-scrollbar {
    height: 5px;
  }

  .table-responsive::-webkit-scrollbar-thumb {
    background-image: linear-gradient(195deg, #7b809a 0%, #42424a 100%);
    opacity: 0.5;
  }

  .table-responsive::-webkit-scrollbar-thumb:hover {
    background-image: linear-gradient(195deg, #42424a 0%, #191919 100%);
  }
</style>

<body class="g-sidenav-show  bg-gray-100">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand px-4 py-3 m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard " target="_blank">
        <img src="<?= base_url('assets/img/logo.png') ?>" class="navbar-brand-img" width="26" height="26" alt="main_logo">
        <span class="ms-1 text-sm text-dark">StudioHead</span>
      </a>
    </div>
    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto d-flex flex-column overflow-hidden" id="sidenav-collapse-main">
      <ul class="navbar-nav flex-grow-1 w-100 px-0 mb-0">
        <li class="nav-item mb-1">
          <a class="nav-link py-2 <?= ($menu == 'dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('dashboard') ?>">
            <i class="material-symbols-rounded opacity-5 text-sm">dashboard</i>
            <span class="nav-link-text ms-1 text-sm">Dashboard</span>
          </a>
        </li>

        <?php if ($role_id == 1) : ?>
          <hr class="border-top">
          <li class="nav-item mt-2 mb-1">
            <h6 class="ps-4 ms-2 text-uppercase text-xxs text-dark font-weight-bolder opacity-5">Booking</h6>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'booking_list') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('booking/list') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">event</i>
              <span class="nav-link-text ms-1 text-sm">Booking List</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'booking_cal') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('booking/calendar') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">event</i>
              <span class="nav-link-text ms-1 text-sm">Booking Calendar</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'payment') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('payment/approval') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">payments</i>
              <span class="nav-link-text ms-1 text-sm">Payments Approval</span>
            </a>
          </li>
          <hr class="border-top">
          <li class="nav-item mt-2 mb-1">
            <h6 class="ps-4 ms-2 text-uppercase text-xxs text-dark font-weight-bolder opacity-5">Management</h6>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'users') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('users') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">group</i>
              <span class="nav-link-text ms-1 text-sm">User</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'studio') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('studio') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">podcasts</i>
              <span class="nav-link-text ms-1 text-sm">Studio</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'packages') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('packages') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">inventory_2</i>
              <span class="nav-link-text ms-1 text-sm">Package</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'addons') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('addons') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">mic_external_on</i>
              <span class="nav-link-text ms-1 text-sm">Add-On</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'membership') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('membership') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">workspace_premium</i>
              <span class="nav-link-text ms-1 text-sm">Membership Tier</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if ($role_id == 2) : ?>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'studio') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('studio/view') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">podcasts</i>
              <span class="nav-link-text ms-1 text-sm">Studio</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'packages') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('packages/view') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">inventory_2</i>
              <span class="nav-link-text ms-1 text-sm">Package</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'membership') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('membership/view') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">workspace_premium</i>
              <span class="nav-link-text ms-1 text-sm">Membership Tier</span>
            </a>
          </li>
          <hr class="border-top">
          <li class="nav-item mt-2 mb-1">
            <h6 class="ps-4 ms-2 text-uppercase text-xxs text-dark font-weight-bolder opacity-5">Booking</h6>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'booking_list') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('booking/list') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">event</i>
              <span class="nav-link-text ms-1 text-sm">Booking List</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'booking_cal') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('booking/calendar') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">event</i>
              <span class="nav-link-text ms-1 text-sm">Booking Calendar</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'payment') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('payment/approval') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">payments</i>
              <span class="nav-link-text ms-1 text-sm">Payments Approval</span>
            </a>
          </li>
        <?php endif; ?>

        <?php if ($role_id == 3) : ?>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'studio') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('studio/view') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">podcasts</i>
              <span class="nav-link-text ms-1 text-sm">Studio</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'packages') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('packages/view') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">inventory_2</i>
              <span class="nav-link-text ms-1 text-sm">Package</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'membership') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('membership/view') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">workspace_premium</i>
              <span class="nav-link-text ms-1 text-sm">Membership Tier</span>
            </a>
          </li>
          <hr class="border-top">
          <li class="nav-item mt-2 mb-1">
            <h6 class="ps-4 ms-2 text-uppercase text-xxs text-dark font-weight-bolder opacity-5">Booking</h6>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'booking_list') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('booking/list') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">event</i>
              <span class="nav-link-text ms-1 text-sm">Booking Studio</span>
            </a>
          </li>
          <li class="nav-item mb-1">
            <a class="nav-link py-2 <?= ($menu == 'booking') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('booking') ?>">
              <i class="material-symbols-rounded opacity-5 text-sm">event_available</i>
              <span class="nav-link-text ms-1 text-sm">My Booking</span>
            </a>
          </li>
        <?php endif; ?>
      </ul>

      <ul class="navbar-nav w-100 px-0 mt-auto border-top pt-2">
        <li class="nav-item mb-1">
          <h6 class="ps-4 ms-2 text-uppercase text-xxs text-dark font-weight-bolder opacity-5 mb-1">Account</h6>
        </li>
        <li class="nav-item mb-1">
          <a class="nav-link py-2 <?= ($menu == 'profile') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="<?= site_url('profile') ?>">
            <i class="material-symbols-rounded opacity-5 text-sm">person</i>
            <span class="nav-link-text ms-1 text-sm">Profile</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link py-2 text-danger" href="<?= site_url('auth/logout') ?>">
            <i class="material-symbols-rounded opacity-8 text-sm text-danger">logout</i>
            <span class="nav-link-text ms-1 text-sm fw-bold">Logout</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 pt-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;"><?= $title ?></a></li>
            <?php
            if ($sub_title) {
              echo '<li class="breadcrumb-item text-sm text-dark active" aria-current="page">' . $sub_title . '</li>';
            }
            ?>
          </ol>
        </nav>
      </div>
    </nav>
    <!-- End Navbar -->