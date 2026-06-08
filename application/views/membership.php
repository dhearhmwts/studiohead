<style>
  .is-invalid {
    border-color: #dc3545 !important;
  }

  .form-control border rounded-3 px-3 py-2 text-sm:focus,
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
          <h5 class="mb-0">Membership Tier Management</h5>
          <small class="text-muted">Kelola level membership customer berdasarkan total transaksi</small>
        </div>
        <button class="btn bg-gradient-dark mb-0" id="btn_add" data-bs-toggle="modal" data-bs-target="#modalTier">
          <i class="material-symbols-rounded text-sm">add</i>&nbsp;Add Tier
        </button>
      </div>
      <hr>
      <div class="d-flex align-items-center mb-3 text-secondary">
        <i class="material-symbols-rounded me-2 fs-5">tune</i>
        <span class="fw-bold text-xs text-uppercase">Filter Pencarian</span>
      </div>
      <div class="row g-3 align-items-end mb-4">
        <div class="col-md-9">
          <label class="form-label text-xs fw-bold text-uppercase text-muted mb-1">Nama Tier</label>
          <div class="input-group bg-white rounded-3 shadow-sm">
            <input type="text" id="filter_tier_name" class="form-control border-0 py-2" placeholder="Cari nama tier...">
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label text-xs fw-bold text-uppercase text-muted mb-1">Status</label>
          <div class="input-group bg-white rounded-3 shadow-sm">
            <select id="filter_status" class="form-select border-0 py-2">
              <option value="">Semua Status</option>
              <option value="active">Aktif</option>
              <option value="inactive">Non Aktif</option>
            </select>
          </div>
        </div>
      </div>
      <hr>
      <?php if (!empty($tiers)): ?>
        <div class="row" id="tier_container">
          <?php foreach ($tiers as $tier): ?>
            <div class="col-lg-3 col-md-6 mb-4 tier-item" data-name="<?= strtolower($tier['tier_name']) ?>" data-priority="<?= $tier['priority_level'] ?>" data-status="<?= strtolower($tier['status']) ?>">
              <div class="card h-100 border-0 shadow-sm">
                <div class="position-relative">
                  <div class="card-header bg-gradient-dark text-white text-center py-4 border-0">
                    <div class="mb-2"><i class="material-symbols-rounded" style="font-size:42px;">workspace_premium</i></div>
                    <h4 class="mb-0 fw-bold text-white">
                      <?= $tier['tier_name'] ?>
                    </h4>
                    <small>Loyalty Membership Tier</small>
                  </div>
                  <?php if ($tier['status'] == 'active'): ?>
                    <span class="position-absolute top-0 end-0 m-3 badge bg-gradient-success">Aktif</span>
                  <?php else: ?>
                    <span class="position-absolute top-0 end-0 m-3 badge bg-gradient-secondary">Non Aktif</span>
                  <?php endif; ?>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                  <div>
                    <div class="text-center mb-4">
                      <div class="text-xs text-uppercase text-muted fw-bold">Minimal Transaksi</div>
                      <h5 class="fw-bold text-primary mb-0">
                        Rp <?= number_format($tier['min_transaction'], 0, ',', '.') ?>
                      </h5>
                    </div>
                    <div class="bg-light rounded-3 p-3 mb-3">
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted text-sm">Discount</span>
                        <span class="fw-bold text-success">
                          <?= $tier['discount_percent'] ?>%
                        </span>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted text-sm">Priority Level</span>
                        <span class="fw-semibold">
                          <?= $tier['priority_level'] ?>
                        </span>
                      </div>
                      <div class="d-flex justify-content-between">
                        <span class="text-muted text-sm">Bonus Hour</span>
                        <span class="fw-semibold">
                          <?= $tier['bonus_hour'] ?> Menit
                        </span>
                      </div>
                    </div>
                    <?php if (!empty($tier['description'])): ?>
                      <p class="text-sm text-muted mb-0" style="min-height:60px;">
                        <?= character_limiter(strip_tags($tier['description']), 90) ?>
                      </p>
                    <?php endif; ?>
                  </div>
                  <div class="d-flex gap-2 mt-auto pt-4">
                    <button type="button" class="btn btn-dark btn-sm flex-fill btn-edit" data-id="<?= $tier['id_tier'] ?>">
                      <i class="material-symbols-rounded text-sm">edit</i>Edit
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm px-3 btn-status" data-id="<?= $tier['id_tier'] ?>">
                      <i class="material-symbols-rounded text-sm">sync</i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm px-3 btn-delete" data-id="<?= $tier['id_tier'] ?>">
                      <i class="material-symbols-rounded text-sm">delete</i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div id="empty_result" class="text-center py-5 d-none">
          <i class="material-symbols-rounded text-secondary" style="font-size:64px;">workspace_premium</i>
          <h5 class="mt-3 mb-1">Membership Tier Tidak Ditemukan</h5>
          <p class="text-muted">Coba ubah kata kunci atau filter pencarian.</p>
        </div>
      <?php else: ?>
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center py-6">
            <div class="mb-4">
              <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width:100px;height:100px;">
                <i class="material-symbols-rounded text-secondary" style="font-size:48px;">workspace_premium</i>
              </div>
            </div>
            <h4 class="fw-bold text-dark mb-2">
              Belum Ada Membership Tier
            </h4>
            <p class="text-muted mb-4">
              Belum terdapat data tier membership.<br>
              Tambahkan tier pertama untuk memulai sistem loyalty customer.
            </p>
            <button class="btn bg-gradient-dark" data-bs-toggle="modal" data-bs-target="#modalTier">
              <i class="material-symbols-rounded me-1">add</i>Tambah Tier Pertama
            </button>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="modal fade" id="modalTier" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-xl rounded-4 overflow-hidden">
      <form id="form_tier">
        <div class="modal-header border-0 pb-0 px-4 pt-4 bg-white">
          <div class="d-flex align-items-center">
            <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width:46px;height:46px;">
              <i class="material-symbols-rounded">workspace_premium</i>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-dark mb-0" id="modalTierLabel">Form Membership Tier</h5>
              <small class="text-muted">Kelola level loyalty customer berdasarkan total transaksi</small>
            </div>
          </div>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <input type="hidden" name="id_tier" id="id_tier">
          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-secondary mb-1">Nama Tier</label>
              <input type="text" name="tier_name" class="form-control border border-secondary rounded-3 px-3 py-2 bg-white text-dark" placeholder="Contoh: Silver">
            </div>
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-secondary mb-1">Status</label>
              <select name="status" class="form-select border border-secondary rounded-3 px-3 py-2 bg-white text-dark">
                <option value="active">Aktif</option>
                <option value="inactive">Non Aktif</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-secondary mb-1">Minimal Transaksi</label>
              <div class="input-group border border-secondary rounded-3 bg-white overflow-hidden">
                <input type="number" name="min_transaction" class="form-control border-0 px-3 py-2 text-dark" placeholder="1000000">
                <span class="input-group-text border-0 bg-transparent text-muted fw-bold text-xs pe-3">Rp</span>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-secondary mb-1">Discount</label>
              <div class="input-group border border-secondary rounded-3 bg-white overflow-hidden">
                <input type="number" name="discount_percent" class="form-control border-0 px-3 py-2 text-dark" placeholder="10">
                <span class="input-group-text border-0 bg-transparent text-muted fw-bold text-xs pe-3">%</span>
              </div>
            </div>
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-secondary mb-1">Priority Level</label>
              <select name="priority_level" class="form-select border border-secondary rounded-3 px-3 py-2 bg-white text-dark">
                <option value="1">Level 1</option>
                <option value="2">Level 2</option>
                <option value="3">Level 3</option>
                <option value="4">Level 4</option>
                <option value="5">Level 5</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label text-xs fw-bold text-secondary mb-1">Bonus Jam Booking</label>
              <div class="input-group border border-secondary rounded-3 bg-white overflow-hidden">
                <input type="number" name="bonus_hour" class="form-control border-0 px-3 py-2 text-dark" placeholder="2">
                <span class="input-group-text border-0 bg-transparent text-muted fw-bold text-xs pe-3">Menit</span>
              </div>
            </div>
            <div class="col-12">
              <label class="form-label text-xs fw-bold text-secondary mb-1">Benefit / Deskripsi Tier</label>
              <textarea name="description" rows="3" class="form-control border border-secondary rounded-3 px-3 py-2 text-dark" placeholder="Contoh: Diskon 10%, prioritas booking, bonus 2 jam gratis setiap bulan"></textarea>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 px-4 pb-4 pt-0 bg-white">
          <button type="button" class="btn btn-light border mb-0" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-dark d-flex align-items-center gap-2 mb-0 shadow-sm">
            <i class="material-symbols-rounded">save</i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const base_url = '<?= base_url() ?>';

  $(document).ready(function() {
    $('#filter_tier_name').on('keyup', filterTier);
    $('#filter_priority,#filter_status').on('change', filterTier);

    $('#btn_add').click(function() {
      $('#form_tier')[0].reset();
      $('#id_tier').val('');
      $('#modalTierLabel').text('Tambah Membership Tier');
    });

    $(document).on('click', '.btn-edit', function() {
      let id_tier = $(this).data('id');
      $.ajax({
        url: base_url + 'membership/get_detail',
        type: 'POST',
        data: {
          id_tier: id_tier
        },
        dataType: 'json',
        success: function(res) {
          $('#modalTierLabel').text('Edit Membership Tier');
          $('#id_tier').val(res.id_tier);
          $('input[name=tier_name]').val(res.tier_name);
          $('input[name=min_transaction]').val(res.min_transaction);
          $('input[name=discount_percent]').val(res.discount_percent);
          $('select[name=priority_level]').val(res.priority_level);
          $('input[name=bonus_hour]').val(res.bonus_hour);
          $('select[name=status]').val(res.status);
          $('textarea[name=description]').val(res.description);
          $('#modalTier').modal('show');
        }
      });

    });

    $('#form_tier').submit(function(e) {
      e.preventDefault();
      $('.is-invalid').removeClass('is-invalid');
      let error = false;

      if ($.trim($('input[name=tier_name]').val()) == '') {
        $('input[name=tier_name]').addClass('is-invalid');
        error = true;
      }

      if ($.trim($('input[name=min_transaction]').val()) == '') {
        $('input[name=min_transaction]').addClass('is-invalid');
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

      let discount = parseInt($('input[name=discount_percent]').val());
      if (discount < 0 || discount > 100) {
        $('input[name=discount_percent]').addClass('is-invalid');
        Swal.fire({
          icon: 'warning',
          title: 'Diskon Tidak Valid',
          text: 'Diskon harus berada di antara 0 - 100%.'
        });
        return false;
      }

      let formData = new FormData(this);
      $.ajax({
        url: base_url + 'membership/save',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(res) {
          if (res.status) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message
            }).then(() => {
              location.reload();
            });
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
      let id_tier = $(this).data('id');
      Swal.fire({
        title: 'Ubah Status Tier?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post(
            base_url + 'membership/change_status', {
              id_tier: id_tier
            },
            function(res) {
              Swal.fire(
                'Berhasil',
                'Status tier berhasil diperbarui',
                'success'
              ).then(() => {
                location.reload();
              });
            },
            'json'
          );

        }

      });

    });

    $(document).on('click', '.btn-delete', function() {
      let id_tier = $(this).data('id');
      Swal.fire({
        title: 'Hapus Tier?',
        text: 'Data tier akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post(
            base_url + 'membership/delete', {
              id_tier: id_tier
            },
            function(res) {
              Swal.fire(
                'Berhasil',
                'Tier berhasil dihapus',
                'success'
              ).then(() => {
                location.reload();
              });
            },
            'json'
          );
        }
      });

    });

    $('#form_tier input,#form_tier select,#form_tier textarea').on('keyup change', function() {
      $(this).removeClass('is-invalid');
    });

  });

  function filterTier() {
    let keyword = $('#filter_tier_name').val().toLowerCase();
    let priority = $('#filter_priority').val();
    let status = $('#filter_status').val().toLowerCase();
    let visible = 0;
    $('.tier-item').each(function() {
      let name = $(this).data('name');
      let pri = $(this).data('priority');
      let stat = $(this).data('status');
      let show = true;

      if (keyword && !name.includes(keyword)) show = false;
      if (priority && pri != priority) show = false;
      if (status && stat != status) show = false;

      $(this).toggle(show);
      if (show)
        visible++;
    });

    $('#empty_result').toggleClass('d-none', visible > 0);
  }
</script>