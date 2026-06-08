<style>
  .is-invalid {
    border-color: #dc3545 !important;
  }
</style>
<div class="container-fluid py-4">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0">User Management</h5>
          <small class="text-muted">Kelola akun Admin, Staff dan Customer</small>
        </div>
        <button class="btn bg-gradient-dark mb-0" id="btn_add" data-bs-toggle="modal" data-bs-target="#modalUser">
          <i class="material-symbols-rounded text-sm">add</i>&nbsp;Add User
        </button>
      </div>
      <hr>
      <div class="d-flex align-items-center mb-3 text-secondary">
        <i class="material-symbols-rounded me-2 fs-5">tune</i>
        <span class="fw-bold text-xs text-uppercase tracking-wider">Filter Pencarian</span>
      </div>
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label for="filter_username" class="form-label text-xs fw-bold text-muted mb-1">Username</label>
          <div class="input-group input-group-alternative border rounded-3 px-2 bg-light">
            <span class="input-group-text bg-transparent border-0 text-muted pe-1">
              <i class="material-symbols-rounded text-sm">person_search</i>
            </span>
            <input type="text" id="filter_username" class="form-control bg-transparent border-0 ps-2 py-2" placeholder="Cari username...">
          </div>
        </div>
        <div class="col-md-4">
          <label for="filter_name" class="form-label text-xs fw-bold text-muted mb-1">Nama Lengkap</label>
          <div class="input-group input-group-alternative border rounded-3 px-2 bg-light">
            <span class="input-group-text bg-transparent border-0 text-muted pe-1">
              <i class="material-symbols-rounded text-sm">badge</i>
            </span>
            <input type="text" id="filter_name" class="form-control bg-transparent border-0 ps-2 py-2" placeholder="Cari nama...">
          </div>
        </div>
        <div class="col-md-2">
          <label for="filter_role" class="form-label text-xs fw-bold text-muted mb-1">Role</label>
          <div class="input-group input-group-alternative border rounded-3 px-2 bg-light">
            <span class="input-group-text bg-transparent border-0 text-muted pe-1">
              <i class="material-symbols-rounded text-sm">manage_accounts</i>
            </span>
            <select id="filter_role" class="form-select bg-transparent border-0 ps-2 py-2">
              <option value="">Semua Role</option>
              <option value="1">Admin</option>
              <option value="2">Staff</option>
              <option value="3">Customer</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <label for="filter_status" class="form-label text-xs fw-bold text-muted mb-1">Status</label>
          <div class="input-group input-group-alternative border rounded-3 px-2 bg-light">
            <span class="input-group-text bg-transparent border-0 text-muted pe-1">
              <i class="material-symbols-rounded text-sm">toggle_on</i>
            </span>
            <select id="filter_status" class="form-select bg-transparent border-0 ps-2 py-2">
              <option value="">Semua Status</option>
              <option value="active">Aktif</option>
              <option value="inactive">Non Aktif</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table id="tbl_user" class="table align-items-center mb-0">
        <thead>
          <tr>
            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" width="50">No</th>
            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Username</th>
            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Nama Lengkap</th>
            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7">Email</th>
            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Role</th>
            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Status</th>
            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Dibuat</th>
            <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" width="130">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- modal crud -->
<div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <form id="form" enctype="multipart/form-data">
        <div class="modal-header border-bottom-0 pb-0 pt-4 px-4 d-flex align-items-center justify-content-between">
          <div class="d-flex align-items-center">
            <div class="bg-gradient-dark text-white rounded-3 p-2 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px;">
              <i class="material-symbols-rounded fs-4">person_add</i>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-dark mb-0" id="modalUserLabel">Form Informasi User</h5>
              <small class="text-muted text-xs">Isi data akun secara lengkap di bawah ini</small>
            </div>
          </div>
          <button type="button" class="btn-close bg-dark rounded-circle p-2" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <input type="hidden" id="id_user" name="id_user">
          <div class="row align-items-center mb-4 bg-light p-3 rounded-4 mx-1">
            <div class="col-auto">
              <div class="position-relative">
                <img id="preview_avatar" src="https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-dashboard/assets/img/placeholder.jpg"
                  class="rounded-circle object-fit-cover shadow-sm border border-2 border-white"
                  alt="Profile Preview"
                  style="width: 85px; height: 85px;">

                <label for="profile_picture" class="btn btn-sm btn-icon-only bg-gradient-dark position-absolute bottom-0 end-0 mb-n2 me-n2 rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 32px; height: 32px; cursor: pointer;">
                  <i class="material-symbols-rounded text-xs text-white">photo_camera</i>
                </label>
              </div>
            </div>
            <div class="col">
              <h6 class="text-sm fw-bold text-dark mb-1">Foto Profil</h6>
              <p class="text-xs text-muted mb-2">Pilih foto terbaik format PNG, JPG atau JPEG (Maks. 2MB)</p>

              <input type="file" id="profile_picture" name="profile_picture" class="form-control form-control-sm border rounded-3 px-2 d-none" accept="image/*" onchange="previewImage(this)">

              <button type="button" class="btn btn-outline-dark btn-sm mb-0 py-1.5 px-3 rounded-3 text-xs" onclick="document.getElementById('profile_picture').click()">
                Pilih Foto
              </button>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-muted mb-1">Nama Lengkap</label>
              <input type="text" name="full_name" class="form-control border rounded-3 px-3 py-2 text-sm" placeholder="Masukkan nama lengkap">
            </div>
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-muted mb-1">Username</label>
              <input type="text" name="username" class="form-control border rounded-3 px-3 py-2 text-sm" placeholder="Masukkan username unik">
            </div>
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-muted mb-1">Alamat Email</label>
              <input type="email" name="email" class="form-control border rounded-3 px-3 py-2 text-sm" placeholder="contoh@email.com">
            </div>
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-muted mb-1">No. Handphone</label>
              <input type="text" name="phone" class="form-control border rounded-3 px-3 py-2 text-sm" placeholder="Contoh: 081234567xx">
            </div>
            <div class="col-12 my-2">
              <hr class="horizontal dark opacity-6 my-1">
            </div>
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-muted mb-1">Hak Akses / Role</label>
              <select name="id_role" class="form-select border rounded-3 px-3 py-2 text-sm">
                <option value="1">Admin</option>
                <option value="2">Staff</option>
                <option value="3">Customer</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-muted mb-1">Status Akun</label>
              <select name="status" class="form-select border rounded-3 px-3 py-2 text-sm">
                <option value="active">Aktif</option>
                <option value="inactive">Non Aktif</option>
              </select>
            </div>
            <div class="col-md-12">
              <label class="form-label text-xs fw-bold text-muted mb-1">Password</label>
              <input type="password" name="password" class="form-control border rounded-3 px-3 py-2 text-sm" placeholder="••••••••">
              <div class="d-flex align-items-center mt-1 text-muted" id="label_passw">
                <i class="material-symbols-rounded text-xs me-1">info</i>
                <small class="text-xs">Kosongkan jika tidak ingin mengubah password lama.</small>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top-0 pt-0 pb-4 px-4 gap-2">
          <button type="button" class="btn btn-light rounded-3 text-sm px-4 py-2 mb-0" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn bg-gradient-dark rounded-3 text-sm px-4 py-2 mb-0 d-flex align-items-center">
            <i class="material-symbols-rounded text-sm me-1">save</i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const base_url = '<?= base_url() ?>';

  $(document).ready(function() {
    let table = $('#tbl_user').DataTable({
      processing: true,
      serverSide: true,
      searching: false,
      lengthChange: false,
      autoWidth: false,

      dom: "<'row'<'col-sm-12'tr>>" +
        "<'row mt-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",

      ajax: {
        url: base_url + 'users/get_data',
        type: 'POST',
        data: function(d) {
          d.username = $('#filter_username').val();
          d.full_name = $('#filter_name').val();
          d.role_id = $('#filter_role').val();
          d.status = $('#filter_status').val();
        }
      },
      columnDefs: [{
          targets: [0, 4, 5, 6, 7],
          className: 'text-center alignment-fixed'
        },
        {
          targets: [7],
          orderable: false
        }
      ],
      language: {
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
        infoFiltered: "(disaring dari _MAX_ total entri)",
        paginate: {
          previous: "<i class='material-symbols-rounded text-sm'>chevron_left</i>",
          next: "<i class='material-symbols-rounded text-sm'>chevron_right</i>"
        },
        zeroRecords: `
                      <div class="text-center py-5 my-3">
                        <div class="avatar avatar-xl bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                          <i class="material-symbols-rounded text-secondary" style="font-size: 45px;">search_off</i>
                        </div>
                        <h5 class="fw-bold text-dark mb-1">Data Tidak Ditemukan</h5>
                        <p class="text-muted text-sm mx-auto mb-0" style="max-width: 350px;">
                          Maaf, kami tidak menemukan data yang cocok<br>dengan kata kunci atau filter pencarian kamu.
                        </p>
                      </div>
                    `
      }
    });

    $('#filter_username,#filter_name').keyup(function() {
      table.ajax.reload();
    });

    $('#filter_role,#filter_status').change(function() {
      table.ajax.reload();
    });

    $('#btn_add').click(function() {
      $('#form')[0].reset();
      $('#id_user').val('');
      $('#label_passw').hide();
      $('#modalUserLabel').text('Tambah User');
      $('#preview_avatar').attr(
        'src',
        'https://raw.githubusercontent.com/creativetimofficial/public-assets/master/soft-ui-dashboard/assets/img/placeholder.jpg'
      );

    });

    $(document).on('click', '.btn-edit', function() {
      $('#label_passw').show();

      let id_user = $(this).data('id');
      $.ajax({
        url: base_url + 'users/get_detail',
        type: 'POST',
        data: {
          id_user: id_user
        },
        dataType: 'json',
        success: function(res) {
          $('#modalUserLabel').text('Edit User');
          $('#id_user').val(res.id_user);
          $('input[name=full_name]').val(res.full_name);
          $('input[name=username]').val(res.username);
          $('input[name=email]').val(res.email);
          $('input[name=phone]').val(res.phone);
          $('select[name=id_role]').val(res.id_role);
          $('select[name=status]').val(res.status);
          $('input[name=password]').val('');
          if (res.profile_picture) {
            $('#preview_avatar').attr(
              'src',
              base_url + 'uploads/profile/' + res.profile_picture
            );
          }
          $('#modalUser').modal('show');
        }
      });
    });

    $('#form').on('submit', function(e) {

      e.preventDefault();

      let id_user = $('#id_user').val();
      let full_name = $.trim($('input[name=full_name]').val());
      let username = $.trim($('input[name=username]').val());
      let email = $.trim($('input[name=email]').val());
      let phone = $.trim($('input[name=phone]').val());
      let password = $.trim($('input[name=password]').val());

      $('.is-invalid').removeClass('is-invalid');

      let error = false;

      if (full_name === '') {
        $('input[name=full_name]').addClass('is-invalid');
        error = true;
      }

      if (username === '') {
        $('input[name=username]').addClass('is-invalid');
        error = true;
      }

      if (email === '') {
        $('input[name=email]').addClass('is-invalid');
        error = true;
      }

      if (phone === '') {
        $('input[name=phone]').addClass('is-invalid');
        error = true;
      }

      if (error) {
        Swal.fire({
          icon: 'warning',
          title: 'Validasi Gagal',
          text: 'Mohon lengkapi seluruh data wajib.'
        });
        return false;
      }

      let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        $('input[name=email]').addClass('is-invalid');
        Swal.fire({
          icon: 'warning',
          title: 'Email Tidak Valid',
          text: 'Format email tidak sesuai.'
        });
        return false;
      }

      if (phone.length < 10) {
        $('input[name=phone]').addClass('is-invalid');
        Swal.fire({
          icon: 'warning',
          title: 'Nomor HP Tidak Valid',
          text: 'Minimal 10 digit.'
        });
        return false;
      }

      if (id_user === '' && password === '') {
        $('input[name=password]').addClass('is-invalid');
        Swal.fire({
          icon: 'warning',
          title: 'Password Wajib',
          text: 'Password wajib diisi untuk user baru.'
        });
        return false;
      }

      if (password !== '') {
        let errors = [];
        if (password.length < 8) errors.push('Minimal 8 karakter');
        if (!/[A-Z]/.test(password)) errors.push('Huruf besar');
        if (!/[a-z]/.test(password)) errors.push('Huruf kecil');
        if (!/[0-9]/.test(password)) errors.push('Angka');
        if (errors.length > 0) {
          $('input[name=password]').addClass('is-invalid');
          Swal.fire({
            icon: 'warning',
            title: 'Password Tidak Valid',
            html: errors.join('<br>')
          });
          return false;
        }
      }

      let formData = new FormData(this);
      $.ajax({
        url: base_url + 'users/save',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
          if (res.status) {
            $('#modalUser').modal('hide');
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message
            });
            table.ajax.reload(null, false);
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: res.message
            });
          }
        },
        error: function() {
          Swal.fire({
            icon: 'error',
            title: 'Server Error',
            text: 'Terjadi kesalahan pada server.'
          });
        }
      });

    });

    $(document).on('click', '.btn-status', function() {
      let id_user = $(this).data('id');
      Swal.fire({
        title: 'Ubah Status?',
        text: 'Status akun akan diperbarui',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: base_url + 'users/change_status',
            type: 'POST',
            data: {
              id_user: id_user
            },
            dataType: 'json',
            success: function() {
              Swal.fire(
                'Berhasil',
                'Status user berhasil diperbarui',
                'success'
              );
              table.ajax.reload(null, false);
            }
          });
        }
      });
    });

    $(document).on('click', '.btn-delete', function() {
      let id_user = $(this).data('id');
      Swal.fire({
        title: 'Hapus User?',
        text: 'Data yang dihapus tidak dapat dikembalikan',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: base_url + 'users/delete',
            type: 'POST',
            data: {
              id_user: id_user
            },
            dataType: 'json',
            success: function() {
              Swal.fire(
                'Berhasil',
                'Data berhasil dihapus',
                'success'
              );
              table.ajax.reload(null, false);
            }
          });
        }
      });
    });

  });

  function previewImage(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        document.getElementById('preview_avatar').src = e.target.result;
      }
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>