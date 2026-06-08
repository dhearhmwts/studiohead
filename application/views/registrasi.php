<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="<?= base_url('assets/img/apple-icon.png') ?>">
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
  <title>StudioHead</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900">
  <link href="<?= base_url('assets/css/nucleo-icons.css') ?>" rel="stylesheet">
  <link href="<?= base_url('assets/css/nucleo-svg.css') ?>" rel="stylesheet">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0">
  <link id="pagestyle" href="<?= base_url('assets/css/material-dashboard.css?v=3.2.0') ?>" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-gray-200">
  <main class="main-content mt-0">
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

                      <h2 class="text-white font-weight-bolder mb-2" style="letter-spacing: 1px;">Buat Akun Baru</h2>
                      <p class="text-white opacity-7 max-w-xs mx-auto text-sm">
                        Daftarkan akun Anda untuk mulai melakukan booking <br> di StudioHead.
                      </p>
                    </div>
                  </div>
                  <div class="col-md-6 bg-white p-5 d-flex flex-column justify-content-center">
                    <div class="px-lg-4">
                      <div class="mb-4">
                        <h3 class="font-weight-bolder text-dark mb-1">Selamat Datang</h3>
                        <p class="text-muted text-sm">Silakan lengkapi data untuk mendaftar</p>
                      </div>

                      <?php if (validation_errors()) : ?>
                        <div class="alert alert-danger text-white text-sm py-2 px-3 rounded mb-3" role="alert">
                          <?= validation_errors('<div class="d-flex align-items-center mb-1"><i class="material-symbols-rounded text-sm me-2">error</i> ', '</div>'); ?>
                        </div>
                      <?php endif; ?>

                      <?php if ($this->session->flashdata('error')) : ?>
                        <div class="alert alert-danger text-white text-sm py-2 px-3 rounded mb-3" role="alert">
                          <div class="d-flex align-items-center">
                            <i class="material-symbols-rounded text-sm me-2">error</i>
                            <?= $this->session->flashdata('error'); ?>
                          </div>
                        </div>
                      <?php endif; ?>

                      <form role="form" method="POST" action="<?= site_url('auth/signup') ?>" class="text-start">
                        <div class="mb-3">
                          <label class="form-label text-xs font-weight-bold text-muted text-uppercase">Nama Lengkap</label>
                          <div class="input-group input-group-outline">
                            <input type="text" name="full_name" class="form-control" placeholder="Masukkan nama lengkap" value="<?= set_value('full_name') ?>" required>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label text-xs font-weight-bold text-muted text-uppercase">Username</label>
                          <div class="input-group input-group-outline">
                            <input type="text" name="username" class="form-control" placeholder="Masukkan username" value="<?= set_value('username') ?>" required>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label text-xs font-weight-bold text-muted text-uppercase">Email</label>
                          <div class="input-group input-group-outline">
                            <input type="email" name="email" class="form-control" placeholder="Masukkan email" value="<?= set_value('email') ?>" required>
                          </div>
                        </div>
                        <div class="mb-3">
                          <label class="form-label text-xs font-weight-bold text-muted text-uppercase">Nomor Telepon</label>
                          <div class="input-group input-group-outline">
                            <input type="text" name="phone" class="form-control" placeholder="Masukkan nomor telepon" value="<?= set_value('phone') ?>" required>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="mb-3">
                              <label class="form-label text-xs font-weight-bold text-muted text-uppercase">Password</label>
                              <div class="input-group input-group-outline">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                              </div>
                              <small id="passwordMessage" class="text-danger style-xs" style="font-size: 11px; display: block; mt-1;"></small>
                            </div>
                          </div>
                          <div class="col-md-6">
                            <div class="mb-3">
                              <label class="form-label text-xs font-weight-bold text-muted text-uppercase">Konfirmasi Password</label>
                              <div class="input-group input-group-outline">
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Konfirmasi Password" required>
                              </div>
                              <small id="confirmMessage" class="text-danger style-xs" style="font-size: 11px; display: block; mt-1;"></small>
                            </div>
                          </div>
                        </div>
                        <button type="submit" id="btnRegister" class="btn bg-gradient-dark w-100 my-2 py-2.5 text-capitalize font-weight-bold shadow">
                          Daftar Sekarang
                        </button>
                        <p class="mt-4 text-sm text-center text-muted mb-0">
                          Sudah memiliki akun?
                          <a href="<?= site_url('auth') ?>" class="text-primary text-gradient font-weight-bold">
                            Masuk di sini
                          </a>
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
                  <a href="https://www.creative-tim.com/presentation" class="nav-link text-white" target="_blank">About Us</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/blog" class="nav-link text-white" target="_blank">Blog</a>
                </li>
                <li class="nav-item">
                  <a href="https://www.creative-tim.com/license" class="nav-link pe-0 text-white" target="_blank">License</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </footer>
    </div>
  </main>
  <script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/core/bootstrap.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/perfect-scrollbar.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/plugins/smooth-scrollbar.min.js') ?>"></script>
  <script src="<?= base_url('assets/js/material-dashboard.min.js?v=3.2.0') ?>"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

  <script>
    $(document).ready(function() {

      function validatePassword() {
        let password = $('#password').val();
        let confirmPassword = $('#confirm_password').val();

        let regexUpper = /[A-Z]/;
        let regexLower = /[a-z]/;
        let regexNumber = /[0-9]/;

        let errors = [];

        if (password.length < 8) {
          errors.push('• Minimal 8 karakter');
        }
        if (!regexUpper.test(password)) {
          errors.push('• Harus ada 1 huruf BESAR');
        }
        if (!regexLower.test(password)) {
          errors.push('• Harus ada 1 huruf kecil');
        }
        if (!regexNumber.test(password)) {
          errors.push('• Harus ada 1 angka');
        }

        if (errors.length > 0) {
          $('#passwordMessage').removeClass('text-success').addClass('text-danger').html(errors.join('<br>'));
          return false;
        }

        $('#passwordMessage').removeClass('text-danger').addClass('text-success').html('Password memenuhi syarat');

        if (confirmPassword.length > 0) {
          if (password !== confirmPassword) {
            $('#confirmMessage').removeClass('text-success').addClass('text-danger').html('Konfirmasi tidak cocok');
            return false;
          }
          $('#confirmMessage').removeClass('text-danger').addClass('text-success').html('Password cocok');
        }

        return true;
      }

      $('#password').on('keyup', function() {
        validatePassword();
      });

      $('#confirm_password').on('keyup', function() {
        validatePassword();
      });

      $('form').on('submit', function(e) {
        if (!validatePassword()) {
          e.preventDefault(); // Menghentikan submit ke server jika JS mendeteksi tidak valid
          Swal.fire({
            icon: 'warning',
            title: 'Syarat Password Kurang!',
            text: 'Pastikan password minimal 8 karakter, memiliki huruf besar, huruf kecil, dan angka.',
            confirmButtonColor: '#3085d6'
          });
        }
      });

    });
  </script>
</body>

</html>