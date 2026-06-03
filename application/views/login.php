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
  <title>StudioHead</title>
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900">
  <!-- Nucleo -->
  <link href="<?= base_url('assets/css/nucleo-icons.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/css/nucleo-svg.css') ?>" rel="stylesheet">
  <!-- Font Awesome -->
  <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
  <!-- Material Icons -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
  <!-- Material Dashboard -->
  <link id="pagestyle" href="<?= base_url('assets/css/material-dashboard.css?v=3.2.0') ?>" rel="stylesheet">
</head>

<body class="bg-gray-200">
  <main class="main-content  mt-0">
    <div class="page-header align-items-start min-vh-100" style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
      <span class="mask bg-gradient-dark opacity-6"></span>
      <div class="container my-auto">
        <div class="container-fluid">
          <div class="row min-vh-100 align-items-center justify-content-center">
            <div class="col-xl-10 col-lg-11 col-12">

              <div class="card shadow-lg border-0 overflow-hidden" style="border-radius: 20px;">
                <div class="row g-0">
                  <div class="col-md-6 bg-gradient-dark d-flex flex-column justify-content-center align-items-center p-5 text-center position-relative">
                    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-1" style="background-image: url('https://www.transparenttextures.com/patterns/cubes.png');"></div>

                    <div class="position-relative z-index-2">
                      <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-4 shadow" style="width: 90px; height: 90px;">
                        <h2>SH</h2>
                      </div>

                      <h2 class="text-white font-weight-bolder mb-2" style="letter-spacing: 1px;">StudioHead</h2>
                      <p class="text-white opacity-7 max-w-xs mx-auto text-sm">
                        StudioHead menghadirkan solusi booking studio yang cepat, praktis, dan terintegrasi untuk kebutuhan podcast, live streaming, dan produksi konten.
                      </p>
                    </div>
                  </div>
                  <div class="col-md-6 bg-white p-5 d-flex flex-column justify-content-center">
                    <div class="px-lg-4">

                      <div class="mb-4">
                        <h3 class="font-weight-bolder text-dark mb-1">Selamat Datang</h3>
                        <p class="text-muted text-sm">Silakan masuk menggunakan akun Anda</p>
                      </div>

                      <form role="form" method="POST" action="<?= site_url('auth/login') ?>" class="text-start">

                        <div class="mb-3">
                          <label class="form-label text-xs font-weight-bold text-muted text-uppercase">Username</label>
                          <div class="input-group input-group-outline position-relative">
                            <span class="position-absolute start-0 top-50 translate-middle-y ms-3 text-secondary opacity-6">
                              <i class="fas fa-user text-xs"></i>
                            </span>
                            <input type="text" name="username" id="username" class="form-control ps-5" placeholder="Masukkan username Anda" required style="border-radius: 8px; height: 45px;">
                          </div>
                        </div>

                        <div class="mb-3">
                          <label class="form-label text-xs font-weight-bold text-muted text-uppercase">Password</label>
                          <div class="input-group input-group-outline position-relative">
                            <span class="position-absolute start-0 top-50 translate-middle-y ms-3 text-secondary opacity-6">
                              <i class="fas fa-lock text-xs"></i>
                            </span>
                            <input type="password" name="password" id="password" class="form-control ps-5" placeholder="Masukkan password Anda" required style="border-radius: 8px; height: 45px;">
                          </div>
                        </div>

                        <button type="submit" class="btn bg-gradient-dark w-100 my-2 py-2.5 text-capitalize font-weight-bold shadow" style="border-radius: 8px;">
                          Sign In
                        </button>

                        <p class="mt-4 text-sm text-center text-muted mb-0">
                          Belum memiliki akun? <a href="<?= site_url('auth/registrasi') ?>" class="text-primary text-gradient font-weight-bold" style="text-decoration: none;">Daftar di sini</a>
                        </p>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="footer position-absolute bottom-2 py-2 w-100">
        <div class="container">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-12 col-md-6 my-auto">
              <div class="copyright text-center text-sm text-white text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script> by Kelompok 2
              </div>
            </div>
            <div class="col-12 col-md-6">
              <ul class="nav nav-footer justify-content-center justify-content-lg-end">
                <li class="nav-item">
                  <a href="https://www.creative-tim.com" class="nav-link text-white" target="_blank">Creative Tim</a>
                </li>
                <li class="nav-item">
                  <a href="javascript:void(0)" class="nav-link text-white" data-bs-toggle="modal" data-bs-target="#aboutUsModal">About Us</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>

  <!-- about us -->
  <div class="modal fade" id="aboutUsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content border-0 shadow">
        <div class="modal-header bg-gradient-dark border-0">
          <h5 class="modal-title text-white font-weight-bold">
            <i class="fas fa-info-circle me-2"></i> About Us
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <div class="text-center mb-4">
            <h3 class="font-weight-extrabold text-dark mb-2">
              StudioHead
            </h3>
            <p class="text-sm text-muted mx-auto" style="max-width: 500px;">
              Platform booking studio modern untuk kebutuhan podcast, live streaming, webinar, dan content production Anda.
            </p>
          </div>
          <hr class="horizontal dark my-4">
          <div class="d-flex align-items-center mb-3">
            <h6 class="font-weight-bold text-uppercase text-xs text-secondary letter-spacing-2 mb-0">
              Tim Pengembang
            </h6>
          </div>
          <div class="row g-3">
            <div class="col-md-4">
              <div class="card h-100 border shadow-none bg-gray-100 border-radius-lg text-center p-3">
                <div class="avatar avatar-lg bg-gradient-primary rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white font-weight-bold shadow-sm" style="width: 60px; height: 60px;">
                  PM
                </div>
                <h6 class="mb-1 text-dark font-weight-bold text-sm">Dhea Rahmawati S.</h6>
                <p class="text-xs text-muted mb-2">2350085001</p>
                <span class="badge bg-sm bg-gradient-primary border-radius-sm mx-auto">Fullstack Dev</span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card h-100 border shadow-none bg-gray-100 border-radius-lg text-center p-3">
                <div class="avatar avatar-lg bg-gradient-info rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white font-weight-bold shadow-sm" style="width: 60px; height: 60px;">
                  BE
                </div>
                <h6 class="mb-1 text-dark font-weight-bold text-sm">Indra Gemanurlingga</h6>
                <p class="text-xs text-muted mb-2">2350085005</p>
                <span class="badge bg-sm bg-gradient-info border-radius-sm mx-auto">Backend Dev</span>
              </div>
            </div>
            <div class="col-md-4">
              <div class="card h-100 border shadow-none bg-gray-100 border-radius-lg text-center p-3">
                <div class="avatar avatar-lg bg-gradient-success rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center text-white font-weight-bold shadow-sm" style="width: 60px; height: 60px;">
                  FE
                </div>
                <h6 class="mb-1 text-dark font-weight-bold text-sm">Rafi Ibrahim</h6>
                <p class="text-xs text-muted mb-2">2350085010</p>
                <span class="badge bg-sm bg-gradient-success border-radius-sm mx-auto">Frontend Dev</span>
              </div>
            </div>
          </div>
          <hr class="horizontal dark my-4">
          <div class="text-center">
            <small class="text-xs text-muted font-weight-bold">
              StudioHead v1.0 • © <?= date('Y') ?> by Kelompok 2
            </small>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/core/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/perfect-scrollbar.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/smooth-scrollbar.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/material-dashboard.min.js?v=3.2.0') ?>"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <?php if ($this->session->flashdata('error')) : ?>
    <script>
      Swal.fire({
        icon: 'error',
        title: 'Login Gagal',
        text: '<?= $this->session->flashdata('error'); ?>'
      });
    </script>
  <?php endif; ?>
  <?php if ($this->session->flashdata('success')) : ?>
    <script>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '<?= $this->session->flashdata('success'); ?>'
      });
    </script>
  <?php endif; ?>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
</body>

</html>