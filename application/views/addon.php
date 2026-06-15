<style>
  .is-invalid {
    border-color: #dc3545 !important;
  }

  .form-control border rounded-3 px-3 px-3 py-2 text-sm:focus,
  .form-select:focus {
    border-color: #212529;
    box-shadow: 0 0 0 0.25rem rgba(33, 37, 41, 0.1);
  }

  .input-group:focus-within .input-group-text {
    border-color: #212529;
  }

  .tracking-wider {
    letter-spacing: 0.05em;
  }

  .studio-card-custom {
    transition: .25s ease;
  }

  .studio-card-custom:hover {
    transform: translateY(-6px);
  }

  .studio-card-custom:hover .studio-img {
    transform: scale(1.05);
  }
</style>
<div class="container-fluid py-4">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0 fw-bold text-dark">Add-on & Fasilitas</h5>
          <small class="text-muted">Kelola alat tambahan, jasa operator, dan fasilitas extra studio</small>
        </div>
        <button class="btn bg-gradient-dark mb-0 d-flex align-items-center gap-1" id="btn_add_addon" data-bs-toggle="modal" data-bs-target="#modalAddon">
          <i class="material-symbols-rounded text-sm">add</i> Add New Item
        </button>
      </div>
      <hr class="my-4">
      <div class="d-flex align-items-center mb-3 text-secondary">
        <i class="material-symbols-rounded me-2 fs-5">tune</i>
        <span class="fw-bold text-xs text-uppercase tracking-wider">Filter Fasilitas</span>
      </div>
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label text-xs fw-bold text-muted mb-1">Nama Alat / Jasa</label>
          <div class="input-group border rounded-3 px-2 bg-light">
            <input type="text" id="filter_addon_name" class="form-control text-sm bg-transparent border-0 px-3" placeholder="Cari contoh: Kamera Sony, Sound Engineer...">
          </div>
        </div>
        <div class="col-md-4">
          <label class="form-label text-xs fw-bold text-muted mb-1">Kategori</label>
          <div class="input-group border rounded-3 px-2 bg-light">
            <select id="filter_addon_category" class="form-select bg-transparent border-0 px-3">
              <option value="">Semua Kategori</option>
              <option value="Camera">Camera & Video Equipment</option>
              <option value="Audio">Audio Equipment</option>
              <option value="Lighting">Lighting Equipment</option>
              <option value="Property">Property & Backdrop</option>
              <option value="Operator">Crew & Operator</option>
              <option value="Production">Production Service</option>
              <option value="F&B">Food & Beverage</option>
              <option value="Other">Lainnya</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label text-xs fw-bold text-muted mb-1">
            Ketersediaan
          </label>
          <div class="input-group border rounded-3 px-2 bg-light">
            <select id="filter_availability" class="form-select bg-transparent border-0 px-3">
              <option value="">Semua</option>
              <option value="available">Tersedia</option>
              <option value="out_of_stock">Habis</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label text-xs fw-bold text-muted mb-1">
            Status
          </label>
          <div class="input-group border rounded-3 px-2 bg-light">
            <select id="filter_addon_status" class="form-select bg-transparent border-0 px-3">
              <option value="">Semua Status</option>
              <option value="active">Aktif</option>
              <option value="inactive">Non Aktif</option>
            </select>
          </div>
        </div>
      </div>
      <hr>
      <div class="card border-0 shadow-sm rounded-4 mt-4">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table align-items-center mb-0 text-sm" id="tbl_addon">
              <thead class="bg-light text-uppercase text-secondary text-sm font-weight-bolder opacity-7">
                <tr>
                  <th class="text-center text-uppercase" rowspan="2">No</th>
                  <th class="ps-4 py-3 text-uppercase" rowspan="2" style="width: 35%;">Nama Add-on & Kategori</th>
                  <th class="text-end py-3 text-uppercase" rowspan="2">Harga Sewa</th>
                  <th class="text-center text-uppercase" colspan="3">Stok</th>
                  <th class="text-center text-uppercase" rowspan="2">Status</th>
                  <th class="text-center text-uppercase" rowspan="2">Action</th>
                </tr>
                <tr>
                  <th class="text-center text-uppercase">Total</th>
                  <th class="text-center text-uppercase">Terpakai</th>
                  <th class="text-center text-uppercase">Tersedia</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalAddon" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4">
      <form id="form_addon" enctype="multipart/form-data">
        <div class="modal-header border-bottom-0 pb-0 pt-4 px-4 d-flex justify-content-between">
          <div class="d-flex align-items-center">
            <div class="bg-gradient-dark text-white rounded-3 p-2 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width:40px;height:40px;">
              <i class="material-symbols-rounded">inventory_2</i>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-dark mb-0" id="modalAddonLabel">Form Informasi Add On</h5>
              <small class="text-muted text-xs">Kelola data add on studio</small>
            </div>
          </div>
          <button type="button" class="btn-close bg-dark rounded-circle p-2" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <input type="hidden" name="id_addon" id="id_addon">
          <div class="row align-items-center mb-4 bg-light p-3 rounded-4 mx-1">
            <div class="col-auto">
              <div class="position-relative">
                <img id="preview_addon" src="<?= base_url('uploads/addon/default.jpg') ?>" class="rounded-circle object-fit-cover shadow-sm border border-2 border-white" style="width:85px;height:85px;">
                <label for="thumbnail" class="btn btn-sm btn-icon-only bg-gradient-dark position-absolute bottom-0 end-0 mb-n2 me-n2 rounded-circle d-flex align-items-center justify-content-center shadow" style="width:32px;height:32px;cursor:pointer;"><i class="material-symbols-rounded text-xs text-white">photo_camera</i></label>
              </div>
            </div>
            <div class="col">
              <h6 class="text-sm fw-bold text-dark mb-1">Upload Gambar</h6>
              <p class="text-xs text-muted mb-2">PNG, JPG atau JPEG maksimal 2MB</p>
              <input type="file" id="thumbnail" name="thumbnail" class="d-none" accept="image/*" onchange="previewAddon(this)">
              <button type="button" class="btn btn-outline-dark btn-sm mb-0" onclick="$('#thumbnail').click()">Pilih Gambar</button>
            </div>
          </div>
          <div class="row g-3">
            <div class="col-md-6">
              <div class="col-md-12">
                <label class="form-label text-xs fw-bold text-muted">Nama Add On</label>
                <input type="text" name="addon_name" class="form-control border rounded-3 px-3" placeholder="Contoh: Sony A7 IV">
              </div>
              <div class="col-md-12">
                <label class="form-label text-xs fw-bold text-muted">Harga</label>
                <input type="number" name="price" class="form-control border rounded-3 px-3" placeholder="150000">
              </div>
              <div class="col-md-12">
                <label class="form-label text-xs fw-bold text-muted">Stock</label>
                <input type="number" name="stock" class="form-control border rounded-3 px-3" placeholder="10">
              </div>
              <div class="col-md-12">
                <label class="form-label text-xs fw-bold text-muted">Status</label>
                <select name="status" class="form-select border rounded-3 px-3">
                  <option value="active">Aktif </option>
                  <option value="inactive">Non Aktif </option>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="col-md-12">
                <label class="form-label text-xs fw-bold text-muted">Kategori</label>
                <select name="category" class="form-select border rounded-3 px-3">
                  <option value="">Pilih Kategori</option>
                  <option value="Camera">Camera & Video Equipment</option>
                  <option value="Audio">Audio Equipment</option>
                  <option value="Lighting">Lighting Equipment</option>
                  <option value="Property">Property & Backdrop</option>
                  <option value="Operator">Crew & Operator</option>
                  <option value="Production">Production Service</option>
                  <option value="F&B">Food & Beverage</option>
                  <option value="Other">Lainnya</option>
                </select>
              </div>
              <div class="col-md-12">
                <label class="form-label text-xs fw-bold text-muted">Deskripsi</label>
                <textarea name="description" rows="7" class="form-control border rounded-3 px-3" placeholder="Deskripsi add on..."></textarea>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-top-0 pt-0 pb-4 px-4">
          <button type="button" class="btn btn-light mb-0" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn bg-gradient-dark mb-0"><i class="material-symbols-rounded text-sm me-1">save</i>Simpan</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const base_url = '<?= base_url() ?>';

  $(document).ready(function() {
    let table = $('#tbl_addon').DataTable({
      processing: true,
      serverSide: true,
      searching: false,
      lengthChange: false,
      autoWidth: false,
      dom: "<'row'<'col-sm-12'tr>>" +
        "<'row mt-3 align-items-center'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 d-flex justify-content-end'p>>",
      ajax: {
        url: base_url + 'addons/get_data',
        type: 'POST',
        data: function(d) {
          d.addon_name = $('#filter_addon_name').val();
          d.category = $('#filter_addon_category').val();
          d.status = $('#filter_addon_status').val();
          d.availability = $('#filter_availability').val();
        }
      },
      columnDefs: [{
          targets: [0, 3, 4, 5, 6, 7],
          className: 'text-center'
        },
        {
          targets: [2],
          className: 'text-end'
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
          <h5 class="fw-bold text-dark mb-1">Add-on Tidak Ditemukan</h5>
          <p class="text-muted text-sm mx-auto mb-0" style="max-width: 350px;">
            Maaf, kami tidak menemukan fasilitas atau alat tambahan<br>yang cocok dengan filter pencarian kamu.
          </p>
        </div>
      `
      }
    });

    $('#filter_addon_name').keyup(function() {
      table.ajax.reload();
    });

    $('#filter_addon_category, #filter_addon_status, #filter_availability').change(function() {
      table.ajax.reload();
    });

    $('#form_addon input, #form_addon select, #form_addon textarea').on('keyup change', function() {
      $(this).removeClass('is-invalid');
    });

    $('#btn_add_addon').click(function() {
      $('#form_addon')[0].reset();
      $('#id_addon').val('');
      $('#modalAddonLabel').text('Tambah Add-on / Fasilitas');
      $('#preview_addon').attr('src', 'https://placehold.co/600x400?text=Upload+Foto');
    });

    $(document).on('click', '.btn-edit', function() {
      let id_addon = $(this).data('id');
      $.ajax({
        url: base_url + 'addons/get_detail',
        type: 'POST',
        data: {
          id_addon: id_addon
        },
        dataType: 'json',
        success: function(res) {
          $('#modalAddonLabel').text('Edit Add On');
          $('#id_addon').val(res.id_addon);
          $('input[name=addon_name]').val(res.addon_name);
          $('select[name=category]').val(res.category);
          $('input[name=stock]').val(res.stock);
          $('input[name=price]').val(res.price);
          $('textarea[name=description]').val(res.description);
          $('select[name=status]').val(res.status);
          $('#preview_addon').attr('src', res.thumbnail ? base_url + 'uploads/addons/' + res.thumbnail : base_url + 'uploads/addons/default.jpg');
          $('#modalAddon').modal('show');
        }
      });

    });

    $('#form_addon').submit(function(e) {
      e.preventDefault();
      $('.is-invalid').removeClass('is-invalid');

      let error = false;
      ['addon_name', 'stock', 'price'].forEach(function(field) {
        if ($.trim($('[name="' + field + '"]').val()) === '') {
          $('[name="' + field + '"]').addClass('is-invalid');
          error = true;
        }
      });

      if ($('select[name=category]').val() === '') {
        $('select[name=category]').addClass('is-invalid');
        error = true;
      }

      if (error) {
        Swal.fire({
          icon: 'warning',
          title: 'Validasi Gagal',
          text: 'Mohon lengkapi data wajib.'
        });
        return false;
      }

      if (parseInt($('[name=stock]').val()) < 0) {
        $('[name=stock]').addClass('is-invalid');
        Swal.fire({
          icon: 'warning',
          title: 'Stok Tidak Valid'
        });
        return false;
      }

      if (parseFloat($('[name=price]').val()) < 0) {
        $('[name=price]').addClass('is-invalid');
        Swal.fire({
          icon: 'warning',
          title: 'Harga Tidak Valid'
        });
        return false;
      }

      let formData = new FormData(this);
      $.ajax({
        url: base_url + 'addons/save',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
          if (res.status) {
            $('#modalAddon').modal('hide');
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
        }
      });
    });

    $(document).on('click', '.btn-status', function() {
      let id_addon = $(this).data('id');
      Swal.fire({
        title: 'Ubah Ketersediaan Alat?',
        text: 'Status operasional item ini akan diperbarui',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Ubah'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: base_url + 'addons/change_status',
            type: 'POST',
            data: {
              id_addon: id_addon
            },
            dataType: 'json',
            success: function(res) {
              Swal.fire('Berhasil', 'Status ketersediaan berhasil diperbarui', 'success');
              table.ajax.reload(null, false);
            }
          });
        }
      });
    });

    $(document).on('click', '.btn-delete', function() {
      let id_addon = $(this).data('id');
      Swal.fire({
        title: 'Hapus Item Add-on?',
        text: 'Data inventaris alat/jasa yang dihapus tidak bisa dikembalikan.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Hapus Selamanya'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: base_url + 'addons/delete',
            type: 'POST',
            data: {
              id_addon: id_addon
            },
            dataType: 'json',
            success: function(res) {
              if (res.status) {
                Swal.fire({
                  icon: 'success',
                  title: 'Berhasil',
                  text: res.message
                });
                table.ajax.reload(null, false);
              } else {
                Swal.fire({
                  icon: 'warning',
                  title: 'Tidak Dapat Dihapus',
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
        }
      });
    });

  });

  function previewAddon(input) {
    if (input.files && input.files[0]) {
      let reader = new FileReader();
      reader.onload = function(e) {
        $('#preview_addon').attr('src', e.target.result);
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
</script>