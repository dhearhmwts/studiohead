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
</head>

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
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">

        <li class="nav-item">
          <a class="nav-link <?= ($menu == 'dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
            href="<?= site_url('dashboard') ?>">
            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>

        <?php if ($role_id == 1) : ?>
          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'users') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('users') ?>">
              <i class="material-symbols-rounded opacity-5">group</i>
              <span class="nav-link-text ms-1">User Management</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'studio') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('studio') ?>">
              <i class="material-symbols-rounded opacity-5">podcasts</i>
              <span class="nav-link-text ms-1">Studio Management</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'package') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('package') ?>">
              <i class="material-symbols-rounded opacity-5">inventory_2</i>
              <span class="nav-link-text ms-1">Package Management</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'addon') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('addon') ?>">
              <i class="material-symbols-rounded opacity-5">mic_external_on</i>
              <span class="nav-link-text ms-1">Add-On Equipment</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'booking') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('booking') ?>">
              <i class="material-symbols-rounded opacity-5">event</i>
              <span class="nav-link-text ms-1">Booking Management</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'membership') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('membership') ?>">
              <i class="material-symbols-rounded opacity-5">workspace_premium</i>
              <span class="nav-link-text ms-1">Membership</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'payment') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('payment') ?>">
              <i class="material-symbols-rounded opacity-5">payments</i>
              <span class="nav-link-text ms-1">Payments</span>
            </a>
          </li>

        <?php endif; ?>
        <?php if ($role_id == 2) : ?>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'booking') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('booking') ?>">
              <i class="material-symbols-rounded opacity-5">event</i>
              <span class="nav-link-text ms-1">Booking</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'payment') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('payment') ?>">
              <i class="material-symbols-rounded opacity-5">payments</i>
              <span class="nav-link-text ms-1">Payment Verification</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'schedule') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('schedule') ?>">
              <i class="material-symbols-rounded opacity-5">calendar_month</i>
              <span class="nav-link-text ms-1">Schedule</span>
            </a>
          </li>

        <?php endif; ?>
        <?php if ($role_id == 3) : ?>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'studio') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('studio') ?>">
              <i class="material-symbols-rounded opacity-5">podcasts</i>
              <span class="nav-link-text ms-1">Studio</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'booking') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('booking') ?>">
              <i class="material-symbols-rounded opacity-5">event_available</i>
              <span class="nav-link-text ms-1">My Booking</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'membership') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('membership') ?>">
              <i class="material-symbols-rounded opacity-5">workspace_premium</i>
              <span class="nav-link-text ms-1">Membership</span>
            </a>
          </li>

          <li class="nav-item">
            <a class="nav-link <?= ($menu == 'review') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
              href="<?= site_url('review') ?>">
              <i class="material-symbols-rounded opacity-5">star</i>
              <span class="nav-link-text ms-1">Review & Rating</span>
            </a>
          </li>

        <?php endif; ?>
        <li class="nav-item mt-3">
          <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">
            Account
          </h6>
        </li>

        <li class="nav-item">
          <a class="nav-link <?= ($menu == 'profile') ? 'active bg-gradient-dark text-white' : 'text-dark' ?>"
            href="<?= site_url('profile') ?>">
            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li>

        <li class="nav-item">
          <a class="nav-link text-dark"
            href="<?= site_url('auth/logout') ?>">
            <i class="material-symbols-rounded opacity-5">logout</i>
            <span class="nav-link-text ms-1">Logout</span>
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