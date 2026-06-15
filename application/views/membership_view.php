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
          <small class="text-muted">Tingkatkan level membership berdasarkan total transaksi</small>
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
                    <button type="button" class="btn btn-dark btn-sm flex-fill btn-preview" data-id="<?= $tier['id_tier'] ?>">
                      Lihat Detail
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
              Belum terdapat data tier membership.
            </p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="modal fade" id="modalTier" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 shadow-xl rounded-4 overflow-hidden bg-light">
      <div class="modal-header border-0 pb-0 px-4 pt-4 bg-white">
        <div class="d-flex align-items-center w-100 justify-content-between">
          <div class="d-flex align-items-center">
            <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width:46px;height:46px;">
              <i class="material-symbols-rounded text-warning">workspace_premium</i>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-dark mb-0" id="modalTierLabel">Detail Membership Tier</h5>
              <small class="text-muted">Informasi lengkap level loyalty customer</small>
            </div>
          </div>
          <button type="button" class="btn-close shadow-none bg-dark" data-bs-dismiss="modal"></button>
        </div>
      </div>
      <div class="modal-body p-4 bg-light">
        <div class="card border-0 rounded-4 shadow-sm mb-3 bg-white">
          <div class="card-body p-4 d-flex align-items-center justify-content-between">
            <div>
              <h3 class="fw-black text-dark mb-0" id="view_tier_name">-</h3>
            </div>
            <div id="view_status">
            </div>
          </div>
        </div>
        <div class="row g-3">
          <div class="col-md-7">
            <div class="row g-3">
              <div class="col-sm-6">
                <div class="card border-0 rounded-4 shadow-sm h-100 bg-white">
                  <div class="card-body p-3 d-flex align-items-center">
                    <div class="p-2 bg-primary-subtle text-primary rounded-3 me-3">
                      <i class="material-symbols-rounded fs-4 d-block">payments</i>
                    </div>
                    <div>
                      <small class="text-muted d-block text-xs">Min. Transaksi</small>
                      <span class="fw-bold text-dark fs-6" id="view_min_transaction">Rp 0</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="card border-0 rounded-4 shadow-sm h-100 bg-white">
                  <div class="card-body p-3 d-flex align-items-center">
                    <div class="p-2 bg-success-subtle text-success rounded-3 me-3">
                      <i class="material-symbols-rounded fs-4 d-block">percent</i>
                    </div>
                    <div>
                      <small class="text-muted d-block text-xs">Diskon Member</small>
                      <span class="fw-bold text-dark fs-6" id="view_discount_percent">0%</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="card border-0 rounded-4 shadow-sm h-100 bg-white">
                  <div class="card-body p-3 d-flex align-items-center">
                    <div class="p-2 bg-warning-subtle text-warning-emphasis rounded-3 me-3">
                      <i class="material-symbols-rounded fs-4 d-block">grade</i>
                    </div>
                    <div>
                      <small class="text-muted d-block text-xs">Priority Level</small>
                      <span class="fw-bold text-dark fs-6" id="view_priority_level">Level -</span>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-sm-6">
                <div class="card border-0 rounded-4 shadow-sm h-100 bg-white">
                  <div class="card-body p-3 d-flex align-items-center">
                    <div class="p-2 bg-info-subtle text-info-emphasis rounded-3 me-3">
                      <i class="material-symbols-rounded fs-4 d-block">schedule</i>
                    </div>
                    <div>
                      <small class="text-muted d-block text-xs">Bonus Jam Booking</small>
                      <span class="fw-bold text-dark fs-6" id="view_bonus_hour">- Menit</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-5">
            <div class="card border-0 rounded-4 shadow-sm h-100 bg-white">
              <div class="card-body p-3">
                <small class="text-muted d-block text-xs mb-2 fw-bold text-uppercase tracking-wider">Benefit & Deskripsi</small>
                <p class="text-secondary mb-0 fs-6 lh-base" id="view_description" style="white-space: pre-line;">-</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const base_url = '<?= base_url() ?>';

  $(document).ready(function() {
    $(document).on('click', '.btn-preview', function() {
      let id_tier = $(this).data('id');
      $.ajax({
        url: base_url + 'membership/get_detail',
        type: 'POST',
        data: {
          id_tier: id_tier
        },
        dataType: 'json',
        success: function(res) {
          $('#view_tier_name').text(res.tier_name);
          $('#view_discount_percent').text(res.discount_percent + '%');
          $('#view_priority_level').text('Level ' + res.priority_level);
          $('#view_bonus_hour').text(res.bonus_hour + ' Menit');
          $('#view_description').text(res.description ? res.description : 'Tidak ada deskripsi.');

          let formattedCrypto = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
          }).format(res.min_transaction);

          $('#view_min_transaction').text(formattedCrypto);

          let statusBadge = '';
          if (res.status === 'active') {
            statusBadge = '<span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill fw-bold text-xs"><i class="material-symbols-rounded align-middle fs-6 me-1">check_circle</i> Aktif</span>';
          } else {
            statusBadge = '<span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-bold text-xs"><i class="material-symbols-rounded align-middle fs-6 me-1">cancel</i> Non-Aktif</span>';
          }
          $('#view_status').html(statusBadge);

          $('#modalTier').modal('show');
        }
      });
    });
  });
</script>