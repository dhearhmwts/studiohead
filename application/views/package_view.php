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

  .select2-container--default .select2-selection--multiple {
    border: 1px solid #dee2e6 !important;
    border-radius: .5rem !important;
    min-height: 42px !important;
    padding: 2px 6px !important;
  }

  .select2-container--default .select2-selection--multiple .select2-selection__choice {
    background: #344767 !important;
    border: none !important;
    color: #fff !important;
    padding: 3px 8px !important;
    border-radius: 6px !important;
  }

  .select2-container {
    width: 100% !important;
  }
</style>
<div class="container-fluid py-4">
  <div class="card mb-4 border-0 shadow-sm">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h5 class="mb-0">Package Management</h5>
          <small class="text-muted">Cek paket studio dan kombinasi fasilitas yang cocok</small>
        </div>
      </div>
      <hr>
      <div class="d-flex align-items-center mb-3 text-secondary">
        <i class="material-symbols-rounded me-2 fs-5">tune</i>
        <span class="fw-bold text-xs text-uppercase">Filter Pencarian</span>
      </div>
      <div class="row g-3 align-items-end mb-4">
        <div class="col-md-6">
          <label class="form-label text-xs fw-bold text-uppercase tracking-wider text-muted mb-1">Nama Package</label>
          <div class="input-group input-group-outline bg-white rounded-2 shadow-sm transition-all">
            <input type="text" id="filter_package_name" class="form-control border-start-0 ps-1 py-2" placeholder="Cari nama package...">
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label text-xs fw-bold text-uppercase tracking-wider text-muted mb-1">Durasi</label>
          <div class="input-group input-group-outline bg-white rounded-2 shadow-sm">
            <select id="filter_duration" class="form-select border-start-0 ps-1 py-2">
              <option value="">Semua</option>
              <option value="1">1 Jam</option>
              <option value="2">2 Jam</option>
              <option value="3">3 Jam</option>
              <option value="4">4 Jam</option>
              <option value="5">5 Jam+</option>
            </select>
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label text-xs fw-bold text-uppercase tracking-wider text-muted mb-1">Harga Maksimal</label>
          <div class="input-group input-group-outline bg-white rounded-2 shadow-sm">
            <input type="number" id="filter_price" class="form-control border-start-0 ps-1 py-2" placeholder="Contoh: 500000">
          </div>
        </div>
        <div class="col-md-12">
          <label class="form-label text-xs fw-bold text-uppercase tracking-wider text-muted mb-1">Item Add-on/Fasilitas</label>
          <div class="input-group input-group-outline bg-white rounded-2 shadow-sm">
            <select id="filter_addon" class="form-select border-start-0 ps-1 py-2" multiple data-placeholder="Pilih add-on / fasilitas ..."> <?php foreach ($addons as $addon): ?> <option value="<?= $addon['id_addon'] ?>"> <?= $addon['addon_name'] ?> </option> <?php endforeach; ?>
            </select>
          </div>
        </div>
      </div>
      <hr>
      <?php if (!empty($packages)): ?>
        <div class="row" id="package_container">
          <?php foreach ($packages as $package): ?>
            <div class="col-lg-3 col-md-6 mb-4 package-item" data-name="<?= strtolower($package['package_name']) ?>" data-duration="<?= $package['duration_hour'] ?>" data-price="<?= $package['price'] ?>" data-addons="<?= strtolower($package['addon_names']) ?>">
              <div class="card h-100 border-0 shadow-sm studio-card-custom">
                <div class="position-relative overflow-hidden" style="border-top-left-radius:.375rem;border-top-right-radius:.375rem;">
                  <img src="<?= !empty($package['thumbnail']) ? base_url('uploads/packages/' . $package['thumbnail']) : base_url('uploads/packages/default.jpg') ?>" class="card-img-top studio-img" style="height:180px;object-fit:cover;">
                  <span class="position-absolute top-0 end-0 m-3 badge bg-gradient-dark"> <?= $package['duration_hour'] ?> Jam </span>
                </div>
                <div class="card-body p-4 d-flex flex-column">
                  <div>
                    <small class="text-uppercase fw-bold text-muted d-block mb-1" style="font-size:.75rem;letter-spacing:.5px;"> Studio Package </small>
                    <h5 class="fw-bold text-dark mb-3"> <?= $package['package_name'] ?> </h5>
                    <div class="bg-light rounded-3 p-3 mb-3">
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted text-sm">Durasi</span>
                        <span class="fw-semibold"><?= $package['duration_hour'] ?> Jam</span>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted text-sm">Total Item</span>
                        <span class="fw-semibold"><?= $package['total_item'] ?> Add-on</span>
                      </div>
                      <div class="d-flex justify-content-between">
                        <span class="text-muted text-sm">Harga Paket</span>
                        <span class="fw-bold text-primary"> Rp <?= number_format($package['price'], 0, ',', '.') ?> </span>
                      </div>
                    </div>
                    <?php if (!empty($package['items'])): ?>
                      <div class="mb-3">
                        <small class="text-muted text-xs fw-bold text-uppercase"> Include </small>
                        <div class="mt-2 d-flex flex-wrap gap-1">
                          <?php
                          $items = explode(',', $package['items']);
                          $show_items = array_slice($items, 0, 4);
                          ?>
                          <?php foreach ($show_items as $item): ?>
                            <span class="badge bg-light text-dark border"> <?= trim($item) ?> </span>
                          <?php endforeach; ?>
                          <?php if (count($items) > 4): ?>
                            <span class="badge bg-gradient-secondary"> +<?= count($items) - 4 ?> lainnya </span>
                          <?php endif; ?>
                        </div>
                      </div>
                    <?php endif; ?>
                    <?php if (!empty($package['description'])): ?> <p class="text-sm text-muted mb-0" style="min-height:48px;"> <?= character_limiter(strip_tags($package['description']), 90) ?> </p> <?php endif; ?>
                  </div>
                  <div class="d-flex gap-2 mt-auto pt-4">
                    <button type="button" class="btn btn-dark btn-sm flex-fill btn-preview" data-id="<?= $package['id_package'] ?>">
                      <i class="material-symbols-rounded text-sm">edit</i> Lihat Detail
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div id="empty_result" class="text-center py-5 d-none">
          <i class="material-symbols-rounded text-secondary" style="font-size:64px;">inventory_2</i>
          <h5 class="mt-3 mb-1">Package Tidak Ditemukan</h5>
          <p class="text-muted">Coba ubah kata kunci atau filter pencarian.</p>
        </div>
      <?php else: ?>
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center py-6">
            <div class="mb-4">
              <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width:100px;height:100px;">
                <i class="material-symbols-rounded text-secondary" style="font-size:48px;"> inventory_2 </i>
              </div>
            </div>
            <h4 class="fw-bold text-dark mb-2"> Belum Ada Package</h4>
            <p class="text-muted mb-4"> Belum terdapat data package studio yang tersimpan.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="modal fade" id="modalPackage" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden" style="background: #fdfdfd;">

      <div class="position-relative bg-dark" style="height: 280px;">
        <img id="preview_package" src="https://placehold.co/800x400/212529/ffffff?text=Thumbnail+Package" class="w-100 h-100" style="object-fit: cover; object-position: center; opacity: 0.85;">

        <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0.4) 0%, rgba(0,0,0,0) 40%, rgba(0,0,0,0.7) 100%);"></div>

        <button type="button" class="btn-close btn-close-white shadow-none position-absolute top-0 end-0 m-3 p-2.5 bg-dark bg-opacity-25 rounded-circle backdrop-blur" data-bs-dismiss="modal" aria-label="Close"></button>

        <div class="position-absolute bottom-0 start-0 w-100 p-4 text-white">
          <span class="badge bg-primary mb-2 py-1.5 px-3 rounded-pill text-uppercase tracking-wider fw-bold" style="font-size: 10px; letter-spacing: 0.5px;">Studio Package</span>
          <h4 class="fw-bold mb-0 text-shadow bg-white rounded px-2" id="view_package_name"></h4>
        </div>
      </div>

      <div class="modal-body p-4">
        <div class="row g-4">
          <div class="col-md-6 border-end-md">
            <label class="form-label text-xs fw-bold text-uppercase text-secondary tracking-wider mb-3" style="font-size: 11px;">Spesifikasi Paket</label>
            <div class="row g-2 mb-3">
              <div class="col-6">
                <div class="p-3 rounded-3 bg-light border border-light d-flex align-items-center gap-2">
                  <div class="bg-white p-2 rounded-2 text-primary shadow-xs d-flex align-items-center justify-content-center">
                    <i class="material-symbols-rounded" style="font-size: 18px;">schedule</i>
                  </div>
                  <div>
                    <small class="text-muted d-block" style="font-size: 11px;">Durasi</small>
                    <span id="view_duration" class="fw-bold text-dark text-sm"></span>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="p-3 rounded-3 bg-light border border-light d-flex align-items-center gap-2">
                  <div class="bg-white p-2 rounded-2 text-success shadow-xs d-flex align-items-center justify-content-center">
                    <i class="material-symbols-rounded" style="font-size: 18px;">widgets</i>
                  </div>
                  <div>
                    <small class="text-muted d-block" style="font-size: 11px;">Total Bundle</small>
                    <span id="text_total_item" class="fw-bold text-dark text-sm">0 Item</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-4">
              <label class="form-label text-xs fw-semibold text-secondary mb-1" style="font-size: 12px;">Harga</label>
              <div class="p-3 bg-opacity-10 text-primary rounded-3 border border-opacity-10 fw-bolder fs-4" id="view_package_price">
              </div>
            </div>
            <div>
              <label class="form-label text-xs fw-semibold text-secondary mb-1" style="font-size: 12px;">Deskripsi & Benefit</label>
              <div class="text-secondary text-sm" id="view_package_description" style="white-space: pre-line; line-height: 1.6; font-size: 13.5px;">
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="d-flex align-items-center justify-content-between mb-3">
              <label class="form-label text-xs fw-bold text-uppercase text-secondary tracking-wider mb-0" style="font-size: 11px;">Item Add-on Termasuk</label>
              <span class="badge bg-dark text-white rounded-pill px-2.5" id="item_badge_count" style="font-size: 11px;">0 Jenis</span>
            </div>
            <div id="package_items_preview_body" class="list-group list-group-flush rounded-3 overflow-hidden border border-light shadow-xs" style="max-height: 290px; overflow-y: auto;">
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 bg-light p-3 px-4 d-flex justify-content-end">
        <button type="button" class="btn btn-secondary fw-semibold px-4 py-2 rounded-3 text-sm mb-0 shadow-sm" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  const base_url = '<?= base_url() ?>';

  $(document).ready(function() {
    $('#filter_addon').select2({
      placeholder: 'Pilih Add-on',
      allowClear: true,
      width: '100%'
    });

    $('#filter_package_name, #filter_price').on('keyup input', filterPackage);
    $('#filter_duration').on('change', filterPackage);
    $('#filter_addon').on('change.select2', filterPackage);

    function filterPackage() {
      let keyword = $('#filter_package_name').val().trim().toLowerCase();
      let duration = $('#filter_duration').val();
      let maxPrice = $('#filter_price').val() ? parseInt($('#filter_price').val()) : null;
      let selectedAddons = $('#filter_addon').val() ? $('#filter_addon').val().map(String) : [];
      let visible = 0;
      $('.package-item').each(function() {
        let show = true;
        let name = ($(this).data('name') || '').toString().toLowerCase();
        let dur = ($(this).data('duration') || '').toString();
        let packagePrice = parseInt($(this).data('price')) || 0;
        let packageAddons = $(this).data('addons') ? $(this).data('addons').toString().split(',').map(item => item.trim()) : [];

        if (keyword && !name.includes(keyword)) {
          show = false;
        }

        if (duration) {
          if (duration === "5") {
            if (parseInt(dur) < 5) show = false;
          } else {
            if (dur !== duration) show = false;
          }
        }

        if (maxPrice !== null && packagePrice > maxPrice) {
          show = false;
        }

        if (selectedAddons.length > 0) {
          selectedAddons.forEach(function(id) {
            if (!packageAddons.includes(id)) {
              show = false;
            }
          });
        }

        $(this).toggle(show);

        if (show) {
          visible++;
        }
      });
    }

    $(document).on('click', '.btn-preview', function() {
      let id_package = $(this).data('id');

      $.ajax({
        url: base_url + 'packages/get_detail',
        type: 'POST',
        data: {
          id_package: id_package
        },
        dataType: 'json',
        success: function(res) {
          let packageData = res.package;

          $('#view_package_name').text(packageData.package_name);
          $('#view_duration').text(packageData.duration_hour + ' Jam');
          $('#view_package_description').text(packageData.description || 'Tidak ada deskripsi detail mengenai paket ini.');

          let formattedPrice = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
          }).format(packageData.price);
          $('#view_package_price').text(formattedPrice);

          if (packageData.thumbnail) {
            $('#preview_package').attr('src', base_url + 'uploads/packages/' + packageData.thumbnail);
          } else {
            $('#preview_package').attr('src', 'https://placehold.co/800x400/212529/ffffff?text=Thumbnail+Package');
          }

          let htmlList = '';
          let totalQtyCount = 0;
          let distinctItemsCount = res.items ? res.items.length : 0;
          if (res.items && res.items.length > 0) {
            $.each(res.items, function(i, row) {
              totalQtyCount += parseInt(row.qty || 0);
              htmlList += `
                          <div class="list-group-item bg-white d-flex justify-content-between align-items-center py-3 border-light">
                            <div class="d-flex align-items-center gap-2.5">
                              <div class="bg-light p-2 rounded-circle d-flex align-items-center justify-content-center text-muted" style="width:32px; height:32px;">
                                <i class="material-symbols-rounded" style="font-size: 16px;">check_circle</i>
                              </div>
                              <div>
                                <span class="text-dark fw-semibold d-block text-sm" style="letter-spacing:-0.1px;">${row.addon_name || 'Item Tidak Diketahui'}</span>
                                <small class="text-muted" style="font-size: 11px;">Kategori: Add-on Studio</small>
                              </div>
                            </div>
                            <span class="badge bg-dark bg-gradient rounded-pill px-3 py-2 text-xs fw-bold shadow-sm">${row.qty} Pcs</span>
                          </div>`;
            });
          } else {
            htmlList = `
                      <div class="text-center p-5 text-muted bg-white border border-light h-100 d-flex flex-column align-items-center justify-content-center">
                        <i class="material-symbols-rounded mb-2 text-secondary" style="font-size: 36px;">layers_clear</i>
                        <span class="text-sm fw-medium">Tidak ada item dalam paket ini</span>
                      </div>`;
          }

          $('#package_items_preview_body').html(htmlList);
          $('#text_total_item').text(totalQtyCount + ' Item');
          $('#item_badge_count').text(distinctItemsCount + ' Jenis');
          $('#modalPackage').modal('show');
        },
        error: function() {
          alert('Gagal memuat pratinjau data package.');
        }
      });
    });
  });
</script>