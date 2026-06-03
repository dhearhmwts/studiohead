<div class="container-fluid px-2 px-md-4">
  <div class="page-header min-height-300 border-radius-xl mt-4" style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
    <span class="mask bg-gradient-dark opacity-6"></span>
  </div>

  <div class="card card-body mx-3 mx-md-4 mt-n6 shadow-lg">
    <div class="row g-4">
      <div class="col-lg-4">
        <div class="card card-plain border border-radius-xl">
          <div class="card-body text-center d-flex flex-column justify-content-center py-5">
            <div class="avatar avatar-xxl mx-auto mb-3 shadow">
              <img src="<?= base_url('uploads/profile/' . ($user->profile_picture ? $user->profile_picture : 'default.jpg')) ?>" class="w-100 border-radius-circle" style="height: 110px; width: 110px; object-fit: cover; border-radius: 50%;">
            </div>
            <h5 class="font-weight-bold mb-1"><?= $user->full_name ?></h5>
            <p class="text-sm text-muted mb-3">
              @<?= strtolower($user->username) ?>
            </p>
            <div class="mt-2">
              <span class="badge badge-sm bg-gradient-success px-3 py-2 border-radius-md">
                <?= ucfirst($user->status) ?>
              </span>
            </div>
          </div>
        </div>

        <?php
        $badge = 'secondary';
        $discount = '0%';
        switch (strtolower($user->tier_name ?? 'bronze')) {
          case 'silver':
            $badge = 'info';
            $discount = '5%';
            break;
          case 'gold':
            $badge = 'warning';
            $discount = '10%';
            break;
          case 'platinum':
            $badge = 'dark';
            $discount = '15%';
            break;
        }
        ?>

        <?php if (isset($user->role_id) && $user->role_id == 3) : ?>
          <div class="card card-plain border border-radius-xl mt-4 bg-gray-100">
            <div class="card-body">
              <div class="d-flex justify-content-between align-items-center mb-3">
                <h6 class="mb-0">Membership Information</h6>
                <span class="badge bg-gradient-<?= $badge ?>">
                  <?= $user->tier_name ?? 'Bronze' ?>
                </span>
              </div>
              <div class="row">
                <div class="col-6 mb-3">
                  <small class="text-muted">Discount</small>
                  <h6 class="mb-0"><?= $discount ?></h6>
                </div>
                <div class="col-6 mb-3">
                  <small class="text-muted">Status</small>
                  <h6 class="mb-0 text-success">Active</h6>
                </div>
                <div class="col-6 mb-3">
                  <small class="text-muted">Total Booking</small>
                  <h6 class="mb-0"><?= $user->total_booking ?? 0 ?></h6>
                </div>
                <div class="col-6 mb-3">
                  <small class="text-muted">Total Transaction</small>
                  <h6 class="mb-0">
                    Rp <?= number_format($user->total_transaction ?? 0, 0, ',', '.') ?>
                  </h6>
                </div>
              </div>
              <button type="button" class="btn btn-outline-dark btn-sm mb-0 w-100" data-bs-toggle="modal" data-bs-target="#membershipBenefitModal">View Benefits</button>
            </div>
          </div>
        <?php endif; ?>
      </div>

      <div class="col-lg-8">
        <div class="card card-plain border border-radius-xl">
          <div class="card-header pb-0 bg-transparent">
            <h6 class="font-weight-bolder text-dark mb-0">Edit Informasi Profil</h6>
            <p class="text-sm mb-0">Perbarui data personal dan kontak Anda di sini.</p>
          </div>
          <div class="card-body">
            <form method="post" action="<?= site_url('profile/update') ?>" enctype="multipart/form-data">
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-sm">Nama Lengkap</label>
                  <input type="text" name="full_name" class="form-control border px-3" value="<?= $user->full_name ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-sm">Username</label>
                  <input type="text" class="form-control border px-3 bg-light" value="<?= $user->username ?>" readonly>
                </div>
                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-sm">Email</label>
                  <input type="email" name="email" class="form-control border px-3" value="<?= $user->email ?>" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-sm">Nomor Telepon</label>
                  <input type="text" name="phone" class="form-control border px-3" value="<?= $user->phone ?>">
                </div>
                <div class="col-12">
                  <label class="form-label font-weight-bold text-sm">Ganti Foto Profil</label>
                  <input type="file" name="profile_picture" class="form-control border px-2">
                </div>
              </div>
              <div class="text-end mt-4">
                <button type="submit" class="btn bg-gradient-dark mb-0 px-4">Simpan Perubahan</button>
              </div>
            </form>
          </div>
        </div>

        <div class="card card-plain border border-radius-xl mt-4">
          <div class="card-header pb-0 bg-transparent">
            <h6 class="font-weight-bolder text-dark mb-0">Keamanan & Password</h6>
            <p class="text-sm mb-0">Ubah password Anda secara berkala untuk menjaga keamanan akun.</p>
          </div>
          <div class="card-body">
            <form method="post" id="form_passw" action="<?= site_url('profile/change_password') ?>">
              <div class="row g-3">
                <div class="col-12">
                  <label class="form-label font-weight-bold text-sm">Password Lama</label>
                  <input type="password" name="old_password" class="form-control border px-3" placeholder="Masukkan password saat ini" required>
                </div>
                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-sm">Password Baru</label>
                  <input type="password" name="new_password" id="new_password" class="form-control border px-3" placeholder="Minimal 8 karakter" required>
                  <small id="passwordMessage" class="text-danger"></small>
                </div>
                <div class="col-md-6">
                  <label class="form-label font-weight-bold text-sm">Konfirmasi Password Baru</label>
                  <input type="password" name="confirm_password" id="confirm_password" class="form-control border px-3" placeholder="Ulangi password baru" required>
                  <small id="confirmMessage" class="text-danger"></small>
                </div>
              </div>
              <div class="text-end mt-4">
                <button type="submit" class="btn bg-gradient-primary mb-0 px-4">Update Password</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>

  </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<script src="<?= base_url('assets/js/core/popper.min.js') ?>"></script>
<script src="<?= base_url('assets/js/core/bootstrap.min.js') ?>"></script>
<script>
  $(function() {
    function validatePassword() {
      let password = $('#new_password').val().trim();
      let confirmPassword = $('#confirm_password').val().trim();
      let errors = [];

      if (password.length < 8) errors.push('Minimal 8 karakter');
      if (!/[A-Z]/.test(password)) errors.push('Harus mengandung huruf besar');
      if (!/[a-z]/.test(password)) errors.push('Harus mengandung huruf kecil');
      if (!/[0-9]/.test(password)) errors.push('Harus mengandung angka');

      if (errors.length > 0) {
        $('#passwordMessage').removeClass('text-success').addClass('text-danger').html(errors.join('<br>'));
      } else {
        $('#passwordMessage').removeClass('text-danger').addClass('text-success').html('✓ Password valid');
      }

      if (confirmPassword !== '') {
        if (password === confirmPassword) {
          $('#confirmMessage').removeClass('text-danger').addClass('text-success').html('✓ Password cocok');
        } else {
          $('#confirmMessage').removeClass('text-success').addClass('text-danger').html('✗ Password tidak cocok');
        }
      } else {
        $('#confirmMessage').html('');
      }

      return errors.length === 0 && password === confirmPassword;
    }

    $('#new_password, #confirm_password').on('keyup blur', function() {
      validatePassword();
    });

    $('#form_passw').on('submit', function(e) {
      let oldPassword = $('#old_password').val().trim();
      let newPassword = $('#new_password').val().trim();
      let confirmPassword = $('#confirm_password').val().trim();

      if (oldPassword === '') {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'Validasi Gagal',
          text: 'Password lama wajib diisi'
        });
        return false;
      }

      if (!validatePassword()) {
        e.preventDefault();
        Swal.fire({
          icon: 'error',
          title: 'Validasi Gagal',
          html: `
                    Password harus:
                    <br>• Minimal 8 karakter
                    <br>• Mengandung huruf besar
                    <br>• Mengandung huruf kecil
                    <br>• Mengandung angka
                    <br>• Password dan konfirmasi harus sama
                `
        });

        return false;
      }

      if (oldPassword === newPassword) {
        e.preventDefault();
        Swal.fire({
          icon: 'warning',
          title: 'Password Tidak Valid',
          text: 'Password baru tidak boleh sama dengan password lama'
        });

        return false;
      }
    });
  });
</script>