<style>
  .ts-control .item {
    display: none !important;
  }

  .ts-control input {
    display: inline-block !important;
    opacity: 1 !important;
    position: relative !important;
  }
</style>
<div class="container-fluid py-4">
  <div class="card border-0 shadow-sm">
    <div class="card-body">
      <div class="row g-3 p-4">
        <div class="col-lg-12 text-center text-md-start d-flex align-items-center gap-3">
          <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center shadow-sm" style="width:50px;height:50px;">
            <i class="material-symbols-rounded">movie_creation</i>
          </div>
          <div>
            <h3 class="fw-bold text-dark mb-0">BOOK STUDIO</h3>
            <p class="text-muted mb-0">Isi detail dan sesuaikan kebutuhan produksi Anda</p>
          </div>
        </div>
        <hr class="border">
        <div class="col-lg-8">
          <form id="form" method="POST" action="<?= site_url('booking/booknow') ?>">
            <!-- studio -->
            <div class="card border-0 rounded-4 shadow-sm mb-4 overflow-hidden bg-white">
              <div class="row g-0">
                <div class="col-md-4 bg-secondary position-relative" style="min-height: 160px;">
                  <img src="<?= base_url('uploads/studio/' . trim($studio['thumbnail'])) ?>" class="w-100 h-100 object-fit-cover position-absolute top-0 start-0" alt="Studio Thumbnail">
                </div>
                <div class="col-md-8">
                  <div class="card-body p-4">
                    <span class="badge bg-success-subtle text-success px-2 py-1 rounded-2 text-xs fw-bold mb-2">Studio Terpilih</span>
                    <h4 class="fw-bold mb-1"><?= $studio['studio_name'] ?></h4>
                    <p class="text-muted text-sm mb-3"><?= $studio['description'] ?></p>
                    <div class="row g-2">
                      <div class="col-md-4">
                        <div class="border rounded-3 p-3 text-center">
                          <div class="text-secondary text-xs mb-1">Kategori</div>
                          <div class="fw-semibold"><?= $studio['category'] ?></div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="border rounded-3 p-3 text-center">
                          <div class="text-secondary text-xs mb-1">Kapasitas</div>
                          <div class="fw-semibold"><?= $studio['capacity'] ?> Orang</div>
                        </div>
                      </div>
                      <div class="col-md-4">
                        <div class="border rounded-3 p-3 text-center">
                          <div class="text-secondary text-xs mb-1">Harga</div>
                          <div class="fw-semibold text-success">
                            Rp<?= number_format($studio['price_per_hour'], 0, ',', '.') ?>/Jam
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- waktu -->
            <div class="card border-0 rounded-4 shadow-sm mb-4 bg-white">
              <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2">
                  <i class="material-symbols-rounded text-primary">calendar_month</i> Waktu Penggunaan
                </h5>
                <div class="row g-3 align-items-end">
                  <div class="col-md-4">
                    <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-2">Tanggal Booking</label>
                    <input type="date" name="booking_date" class="form-control border border-secondary rounded-3 px-3 py-2 bg-white" min="<?= $min_date ?>" max="<?= $max_date ?>">
                  </div>
                  <div class="col-md-4">
                    <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-2">Jam Mulai</label>
                    <select name="start_time" class="form-select border border-secondary rounded-3 px-3 py-2 bg-white">
                      <?php
                      for ($h = 8; $h < 20; $h++):
                        for ($m = 0; $m < 60; $m += 30):
                      ?>
                          <option value="<?= sprintf('%02d:%02d', $h, $m) ?>">
                            <?= sprintf('%02d:%02d', $h, $m) ?>
                          </option>
                      <?php
                        endfor;
                      endfor;
                      ?>
                    </select>
                  </div>
                  <div class="col-md-4">
                    <label class="form-label text-xs fw-bold text-secondary text-uppercase mb-2">Durasi</label>
                    <div class="input-group input-group-outline is-filled">
                      <input type="number" name="duration" class="form-control px-3 py-2 border border-secondary" placeholder="2" min="1">
                      <span class="input-group-text bg-transparent text-muted px-3">
                        Jam
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- package -->
            <div class="card border-0 rounded-4 shadow-sm mb-4 bg-white">
              <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                  <i class="material-symbols-rounded text-success">inventory_2</i>
                  Package Studio
                </h5>
                <p class="text-muted text-xs mb-3">
                  Pilih paket bundel hemat (Opsional)
                </p>
                <div class="row g-3">
                  <div class="col-6">
                    <label class="card border border-secondary rounded-3 p-3 cursor-pointer shadow-sm package-card">
                      <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-start gap-3">
                          <input type="radio" name="id_package" value="" data-price="0" checked>
                          <div>
                            <span class="fw-bold text-dark text-sm d-block">Tanpa Package</span>
                            <span class="text-muted d-block mb-2">Gunakan tarif studio reguler</span>
                          </div>
                        </div>
                        <div class="text-end">
                          <div class="fw-bold text-success">Rp 0</div>
                        </div>
                      </div>
                    </label>
                  </div>
                  <?php foreach ($packages as $package): ?>
                    <div class="col-6">
                      <label class="card border border-secondary rounded-3 p-3 cursor-pointer shadow-sm package-card">
                        <div class="d-flex justify-content-between align-items-start">
                          <div class="d-flex align-items-start gap-3">
                            <input type="radio" name="id_package" value="<?= $package['id_package'] ?>" data-price="<?= $package['price'] ?>">
                            <div>
                              <span class="fw-bold text-dark text-sm d-block"><?= $package['package_name'] ?></span>
                              <small class="text-muted d-block mb-2"><?= $package['description'] ?></small>
                              <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-light text-dark border"><?= $package['duration_hour'] ?> Jam</span>
                                <span class="badge bg-light text-dark border"><?= $package['total_item'] ?> Add-On</span>
                              </div>
                              <?php if (!empty($package['addon_names'])) : ?>
                                <div class="mt-2">
                                  <small class="text-muted"><?= $package['addon_names'] ?></small>
                                </div>
                              <?php endif; ?>
                            </div>
                          </div>
                          <div class="text-end">
                            <div class="fw-bold text-success">
                              Rp <?= number_format($package['price'], 0, ',', '.') ?>
                            </div>
                          </div>
                        </div>
                      </label>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>
            <!-- addon -->
            <div class="card border-0 rounded-4 shadow-sm mb-4 bg-white">
              <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-1 d-flex align-items-center gap-2">
                  <i class="material-symbols-rounded text-warning">extension</i>
                  Add-On Equipment
                </h5>
                <p class="text-muted text-xs mb-3">Pilih dan tambahkan alat pelengkap untuk sesi produksi Anda</p>
                <div class="mb-4">
                  <select id="addon-select" class="form-control" multiple placeholder="Ketik nama atau pilih alat di sini..." autocomplete="off">
                    <option value="">Ketik nama atau pilih alat...</option>
                    <?php foreach ($addons as $addon): ?>
                      <option value="<?= $addon['id_addon'] ?>"
                        data-name="<?= $addon['addon_name'] ?>"
                        data-stock="<?= $addon['available_stock'] ?>"
                        data-price="<?= $addon['price'] ?>">
                        <?= $addon['addon_name'] ?> — Rp<?= number_format($addon['price'], 0, ',', '.') ?> (Stok: <?= $addon['available_stock'] ?>)
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="row g-2" id="selected-addons-container">
                  <div id="empty-state" class="col-12 text-center py-3 text-muted border border-dashed rounded-3">
                    <i class="material-symbols-rounded align-middle me-1 fs-5">info</i> Belum ada alat pelengkap yang dipilih
                  </div>
                </div>
              </div>
            </div>
            <div id="hidden-inputs-container"></div>
        </div>
        <!-- summary booking -->
        <div class="col-lg-4">
          <div class="card border-0 rounded-4 shadow-lg bg-white sticky-md-top" style="top: 24px; z-index: 10;">
            <div class="card-body p-4">
              <h5 class="fw-black text-dark mb-3 pb-2 border-bottom d-flex align-items-center gap-2">
                <i class="material-symbols-rounded text-dark">receipt_long</i> Ringkasan Booking
              </h5>
              <div class="bg-light rounded-3 p-3 mb-4">
                <div class="row g-2 text-sm">
                  <div class="col-4 text-muted">Studio</div>
                  <div class="col-8 fw-bold text-dark text-end">
                    <span id="booking_studio">-</span>
                    <input type="hidden" name="id_studio" value="<?= $studio['id_studio'] ?>">
                  </div>
                  <div class="col-4 text-muted">Package</div>
                  <div class="col-8 text-dark text-end">
                    <span id="booking_package">-</span>
                  </div>
                  <div class="col-4 text-muted">Tanggal</div>
                  <div class="col-8 text-dark text-end">
                    <span id="booking_tgl">-</span>
                  </div>
                  <div class="col-4 text-muted">Jam</div>
                  <div class="col-8 text-dark text-end">
                    <span id="booking_jam">-</span>
                  </div>
                  <div class="col-4 text-muted">Durasi</div>
                  <div class="col-8 text-dark text-end">
                    <span class="badge bg-dark text-white" id="booking_durasi"></span>
                  </div>
                </div>
              </div>
              <div class="d-flex flex-column gap-2 mb-3 pb-3 border-bottom text-sm">
                <div class="d-flex justify-content-between">
                  <span class="text-secondary">Studio Fee</span>
                  <span class="text-dark fw-semibold" id="studio_fee"></span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="text-secondary">Package</span>
                  <span class="text-dark fw-semibold" id="package_fee"></span>
                </div>
                <div class="d-flex justify-content-between">
                  <span class="text-secondary">Add-On Equipment</span>
                  <span class="text-dark fw-semibold" id="addon_fee"></span>
                </div>
                <div class="d-flex justify-content-between text-success">
                  <span class="d-flex align-items-center gap-1">
                    <i class="material-symbols-rounded fs-6">loyalty</i> Diskon Member
                  </span>
                  <span class="fw-bold" id="member_diskon"></span>
                  <input type="hidden" name="discount_amount" id="discount_amount">
                </div>
              </div>
              <div class="d-flex justify-content-between align-items-center mb-4">
                <span class="fw-bold text-dark text-uppercase tracking-wider text-xs">Total Pembayaran</span>
                <span class="fw-black text-dark fs-4" id="total_pembayaran"></span>
                <input type="hidden" name="subtotal" id="subtotal">
                <input type="hidden" name="total_price" id="total_price">
              </div>
              <button type="submit" class="btn btn-dark w-100 rounded-3 py-3 fw-bold d-flex align-items-center justify-content-center gap-2 shadow transition-all">
                <i class="material-symbols-rounded">verified_user</i> BOOK SEKARANG
              </button>
            </div>
          </div>
        </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener("DOMContentLoaded", function() {
    const control = new TomSelect("#addon-select", {
      maxItems: null,
      hideSelected: true,
      closeAfterSelect: false
    });

    const STUDIO_NAME = <?= json_encode($studio['studio_name']) ?>;
    const STUDIO_PRICE = <?= floatval($studio['price_per_hour']) ?>;
    const MEMBER_DISCOUNT = <?= floatval($member_disc) ?>;

    function rupiah(number) {
      return 'Rp ' + Number(number).toLocaleString('id-ID');
    }

    function formatTgl(dateString) {
      if (!dateString) return '-';
      const bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
      const date = new Date(dateString);
      const tanggal = date.getDate();
      const namaBulan = bulan[date.getMonth()];
      const tahun = date.getFullYear();
      return `${tanggal} ${namaBulan} ${tahun}`;
    }

    function updateTotalPrice() {
      let bookingDate = $('[name="booking_date"]').val();
      let startTime = $('[name="start_time"]').val();
      let duration = parseInt($('[name="duration"]').val()) || 0;
      let studioFee = STUDIO_PRICE * duration;
      let packageFee = parseFloat($('input[name="id_package"]:checked').data('price')) || 0;
      let addonFee = 0;

      $('.addon-checkbox').each(function() {
        addonFee += parseFloat($(this).data('price')) || 0;
      });

      let subtotal = studioFee + packageFee + addonFee;
      let discount = (subtotal * MEMBER_DISCOUNT) / 100;
      let total = subtotal - discount;

      let packageName = $('input[name="id_package"]:checked').closest('label').find('.fw-bold').first().text();

      $('#booking_package').text(packageName || '-');
      $('#booking_studio').text(STUDIO_NAME);
      $('#booking_tgl').text(formatTgl(bookingDate));
      $('#booking_jam').text(startTime || '-');
      $('#booking_durasi').text(duration > 0 ? duration + ' Jam' : '-');
      $('#studio_fee').text(rupiah(studioFee));
      $('#package_fee').text(rupiah(packageFee));
      $('#addon_fee').text(rupiah(addonFee));
      $('#member_diskon').text(rupiah(discount));
      $('#total_pembayaran').text(rupiah(total));
      $('#discount_amount').val(discount);
      $('#subtotal').val(subtotal);
      $('#total_price').val(total);
    }

    updateTotalPrice();

    $(document).on('change', '[name="booking_date"], [name="start_time"], [name="duration"]', updateTotalPrice);
    $(document).on('change', 'input[name="id_package"]', updateTotalPrice);

    const container = document.getElementById('selected-addons-container');
    const hiddenContainer = document.getElementById('hidden-inputs-container');
    const emptyState = document.getElementById('empty-state');
    control.on('change', function(values) {
      container.innerHTML = '';
      hiddenContainer.innerHTML = '';

      if (values.length === 0) {
        if (emptyState) container.appendChild(emptyState);
        updateTotalPrice();
        return;
      }

      values.forEach(id => {
        const option = document.querySelector(`#addon-select option[value="${id}"]`);
        if (!option) return;

        const name = option.getAttribute('data-name');
        const stock = option.getAttribute('data-stock');
        const rawPrice = option.getAttribute('data-price');
        const priceFormatted = parseInt(rawPrice).toLocaleString('id-ID');
        const cardHtml = `
          <div class="col-md-4" id="card-addon-${id}">
            <div class="d-flex align-items-center justify-content-between border border-warning rounded-3 p-3 bg-light-subtle w-100 shadow-sm position-relative">
              <div class="pe-3">
                <span class="text-sm fw-bold text-dark d-block">${name}</span>
                <small class="text-muted d-block text-xs">Stok: ${stock}</small>
                <span class="badge bg-warning text-dark fw-bold text-xs mt-1">Rp ${priceFormatted}</span>
              </div>
              <button type="button" class="btn-close text-danger text-sm btn-remove-addon" data-id="${id}" aria-label="Close"></button>
            </div>
          </div>
        `;
        container.insertAdjacentHTML('beforeend', cardHtml);

        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.className = 'addon-checkbox';
        hiddenInput.name = 'addons[]';
        hiddenInput.value = id;
        hiddenInput.setAttribute('data-price', rawPrice);
        hiddenContainer.appendChild(hiddenInput);
      });

      updateTotalPrice();
    });

    container.addEventListener('click', function(e) {
      if (e.target.classList.contains('btn-remove-addon')) {
        const idToRemove = e.target.getAttribute('data-id');
        control.removeItem(idToRemove);
      }
    });

    $('#form').submit(function(e) {
      e.preventDefault();
      Swal.fire({
        title: 'Konfirmasi Booking',
        text: 'Pastikan data booking sudah benar',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Booking',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (!result.isConfirmed) return;

        $.ajax({
          url: $(this).attr('action'),
          type: 'POST',
          data: $(this).serialize(),
          dataType: 'json',
          beforeSend: function() {
            Swal.fire({
              title: 'Memproses Booking...',
              text: 'Mohon tunggu sebentar',
              allowOutsideClick: false,
              allowEscapeKey: false,
              didOpen: () => {
                Swal.showLoading();
              }
            });
          },
          success: function(res) {
            if (res.status) {
              Swal.fire({
                icon: 'success',
                title: 'Detail Booking Berhasil Disimpan',
                text: 'Data booking Anda telah berhasil disimpan. Silakan lanjutkan ke proses pembayaran untuk menyelesaikan reservasi.'
              }).then(() => {
                window.location.href = res.redirect;
              });
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: res.message
              });
            }
          },
          error: function(xhr) {
            console.error("Server Error Response:", xhr.responseText);
            Swal.fire({
              icon: 'error',
              title: 'Oops...',
              text: 'Terjadi kesalahan pada server. Cek konsol browser atau log server untuk detailnya.'
            });
          }
        });
      });
    });

  });
</script>