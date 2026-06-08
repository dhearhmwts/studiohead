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
          <small class="text-muted">Kelola paket studio dan kombinasi fasilitas yang tersedia</small>
        </div>
        <button class="btn bg-gradient-dark mb-0" id="btn_add" data-bs-toggle="modal" data-bs-target="#modalPackage">
          <i class="material-symbols-rounded text-sm">add</i>&nbsp;Add Package
        </button>
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
                    <button type="button" class="btn btn-dark btn-sm flex-fill btn-edit" data-id="<?= $package['id_package'] ?>">
                      <i class="material-symbols-rounded text-sm">edit</i> Edit
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm px-3 btn-delete" data-id="<?= $package['id_package'] ?>">
                      <i class="material-symbols-rounded text-sm">delete</i>
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
            <p class="text-muted mb-4"> Belum terdapat data package studio yang tersimpan.<br> Tambahkan package pertama untuk memudahkan proses booking.</p>
            <button class="btn bg-gradient-dark" data-bs-toggle="modal" data-bs-target="#modalPackage">
              <i class="material-symbols-rounded me-1">add</i> Tambah Package Pertama
            </button>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<div class="modal fade" id="modalPackage" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 shadow-xl rounded-4 overflow-hidden">
      <form id="form_package" enctype="multipart/form-data">
        <div class="modal-header border-0 pb-0 px-4 pt-4 bg-white">
          <div class="d-flex align-items-center">
            <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width:46px;height:46px;">
              <i class="material-symbols-rounded">inventory_2</i>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-dark mb-0" id="modalPackageLabel">Form Informasi Package</h5>
              <small class="text-muted">Kelola paket studio dan item add-on yang termasuk di dalamnya</small>
            </div>
          </div>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-4">
          <input type="hidden" name="id_package" id="id_package">
          <div class="row g-4">
            <div class="col-lg-4">
              <div class="card bg-light border-0 rounded-4 p-3 h-100">
                <label class="form-label text-xs fw-bold text-uppercase text-secondary mb-2">Thumbnail Package</label>
                <div class="rounded-4 overflow-hidden shadow-sm bg-dark mb-3" style="height:220px;">
                  <img id="preview_package" src="https://placehold.co/600x400?text=Thumbnail+Package" class="w-100 h-100" style="object-fit:cover;">
                </div>
                <input type="file" name="thumbnail" id="thumbnail" class="form-control border border-secondary rounded-3 bg-white px-3 py-2" accept="image/*" onchange="previewPackageImage(this)">
                <small class="text-muted mt-2">JPG, PNG, WEBP maksimal 2MB</small>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="row g-3">
                <div class="col-md-8">
                  <label class="form-label text-xs fw-bold text-secondary mb-1">Nama Package</label>
                  <input type="text" name="package_name" class="form-control border border-secondary rounded-3 px-3 py-2 bg-white text-dark" placeholder="Contoh: Podcast Premium Package">
                </div>
                <div class="col-md-4">
                  <label class="form-label text-xs fw-bold text-secondary mb-1">Durasi</label>
                  <div class="input-group border border-secondary rounded-3 bg-white overflow-hidden">
                    <input type="number" name="duration_hour" class="form-control border-0 px-3 py-2 text-dark" placeholder="2">
                    <span class="input-group-text border-0 bg-transparent text-muted fw-bold text-xs pe-3">Jam</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label text-xs fw-bold text-secondary mb-1">Harga Package</label>
                  <div class="input-group border border-secondary rounded-3 bg-white overflow-hidden">
                    <input type="number" name="price" class="form-control border-0 px-3 py-2 text-dark" placeholder="500000">
                    <span class="input-group-text border-0 bg-transparent text-muted fw-bold text-xs pe-3">Rp</span>
                  </div>
                </div>
                <div class="col-md-6">
                  <label class="form-label text-xs fw-bold text-secondary mb-1">Total Item</label>
                  <input type="text" id="total_item" class="form-control border border-0 rounded-3 px-3 py-2 bg-light text-dark fw-bold" readonly value="0 Item" style="background-color: #e9ecef !important;">
                </div>
                <div class="col-12">
                  <label class="form-label text-xs fw-bold text-secondary mb-1">Deskripsi Package</label>
                  <textarea name="description" rows="3" class="form-control border border-secondary rounded-3 px-3 py-2 text-dark" placeholder="Jelaskan isi package dan benefit yang didapat customer"></textarea>
                </div>
                <div class="col-12">
                  <div class="d-flex justify-content-between align-items-center mb-2">
                    <label class="form-label text-xs fw-bold text-secondary mb-0">Item Package</label>
                    <button type="button" class="btn btn-sm bg-gradient-dark mb-0 d-flex align-items-center gap-1" id="btn_add_item">
                      <i class="material-symbols-rounded text-sm">add</i> Tambah Item
                    </button>
                  </div>
                  <div id="package_items_container" class="border rounded-4 overflow-hidden">
                    <div class="row g-0 bg-light border-bottom fw-bold text-xs text-uppercase text-secondary py-2 px-3">
                      <div class="col-md-7">Add-on</div>
                      <div class="col-md-3 text-center">Qty</div>
                      <div class="col-md-2 text-center">Action</div>
                    </div>
                    <div id="package_items_body" class="p-3">
                      <div class="col-md-7">
                        <label class="form-label text-xs fw-bold text-muted mb-1">Add-on</label>
                        <select name="id_addon[]" class="form-select addon-select">
                          <option value="">Pilih Add-on</option>
                          <?php foreach ($addons as $addon): ?>
                            <option value="<?= $addon['id_addon'] ?>">
                              <?= $addon['addon_name'] ?>
                            </option>
                          <?php endforeach; ?>
                        </select>
                      </div>
                      <div class="col-md-3">
                        <label class="form-label text-xs fw-bold text-muted mb-1">Qty</label>
                        <input type="number" name="qty[]" class="form-control text-center" min="1" value="1">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label text-xs fw-bold text-muted mb-1">Action</label>
                        <button type="button" class="btn btn-outline-danger w-100 btn-remove-item mb-0">
                          <i class="material-symbols-rounded text-sm">delete</i>
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
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
  window.addon_options = `
                        <?php foreach ($addons as $addon): ?>
                        <option value="<?= $addon['id_addon'] ?>">
                          <?= $addon['addon_name'] ?>
                        </option>
                        <?php endforeach; ?>
                        `;
</script>
<script>
  const base_url = '<?= base_url() ?>';

  $(document).ready(function() {

    $('#filter_addon').select2({
      placeholder: 'Pilih Add-on',
      allowClear: true,
      width: '100%'
    });

    $(document).on('change', '.addon-select', function() {
      updateTotalItem();
    });

    $(document).on('keyup', 'input[name="qty[]"]', function() {
      updateTotalItem();
    });

    $('#filter_package_name,#filter_price').on('keyup', filterPackage);
    $('#filter_duration,#filter_addon').on('change', filterPackage);

    $('#btn_reset_filter').click(function() {
      $('#filter_package_name').val('');
      $('#filter_duration').val('');
      $('#filter_price').val('');
      $('#filter_addon').val(null).trigger('change');
      filterPackage();
    });

    $('#btn_add').click(function() {
      $('#form_package')[0].reset();
      $('#id_package').val('');
      $('#modalPackageLabel').text('Tambah Package');
      $('#preview_package').attr('src', 'https://placehold.co/600x400?text=Thumbnail+Package');
      $('#package_items_body').html(getItemRow());
      initAddonSelect();
      updateTotalItem();
    });

    $('#btn_add_item').click(function() {
      $('#package_items_body').append(getItemRow());
      initAddonSelect();
      updateTotalItem();
    });

    $(document).on('click', '.btn-remove-item', function() {
      if ($('.package-item-row').length <= 1) {
        Swal.fire({
          icon: 'warning',
          title: 'Minimal 1 Item',
          text: 'Package harus memiliki minimal 1 add-on.'
        });
        return;
      }

      $(this).closest('.package-item-row').remove();
      updateTotalItem();
    });

    $(document).on('click', '.btn-edit', function() {
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
          $('#modalPackageLabel').text('Edit Package');
          $('#id_package').val(packageData.id_package);
          $('input[name=package_name]').val(packageData.package_name);
          $('input[name=duration_hour]').val(packageData.duration_hour);
          $('input[name=price]').val(packageData.price);
          $('textarea[name=description]').val(packageData.description);
          if (packageData.thumbnail) {
            $('#preview_package').attr('src', base_url + 'uploads/packages/' + packageData.thumbnail);
          }

          let html = '';
          $.each(res.items, function(i, row) {
            html += `
                    <div class="row g-2 package-item-row align-items-center mb-3">
                      <div class="col-md-7">
                        <select name="id_addon[]" class="form-select addon-select">
                          <option value="">Pilih Add-on</option>
                          ${window.addon_options}
                        </select>
                      </div>
                      <div class="col-md-3">
                        <input type="number" name="qty[]" class="form-control text-center" value="${row.qty}" min="1">
                      </div>
                      <div class="col-md-2">
                        <button type="button" class="btn btn-outline-danger w-100 btn-remove-item mb-0">
                          <i class="material-symbols-rounded text-sm">delete</i>
                        </button>
                      </div>

                    </div>
                  `;
          });

          $('#package_items_body').html(html);

          initAddonSelect();
          $.each(res.items, function(i, row) {
            $('.addon-select').eq(i).val(row.id_addon).trigger('change');
          });

          updateTotalItem();
          $('#modalPackage').modal('show');
        }
      });

    });

    $('#form_package').submit(function(e) {
      e.preventDefault();
      $('.is-invalid').removeClass('is-invalid');

      let error = false;

      if ($.trim($('input[name=package_name]').val()) == '') {
        $('input[name=package_name]').addClass('is-invalid');
        error = true;
      }

      if ($.trim($('input[name=duration_hour]').val()) == '') {
        $('input[name=duration_hour]').addClass('is-invalid');
        error = true;
      }

      if ($.trim($('input[name=price]').val()) == '') {
        $('input[name=price]').addClass('is-invalid');
        error = true;
      }

      let addonCount = 0;
      $('.addon-select').each(function() {
        if ($(this).val() != '')
          addonCount++;
      });

      if (addonCount == 0) {
        Swal.fire({
          icon: 'warning',
          title: 'Item Package Kosong',
          text: 'Minimal harus ada 1 add-on dalam package.'
        });
        return false;
      }

      if (error) {
        Swal.fire({
          icon: 'warning',
          title: 'Validasi Gagal',
          text: 'Mohon lengkapi seluruh data wajib.'
        });
        return false;
      }

      let formData = new FormData(this);
      $.ajax({
        url: base_url + 'packages/save',
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

    $(document).on('click', '.btn-delete', function() {
      let id_package = $(this).data('id');
      Swal.fire({
        title: 'Hapus Package?',
        text: 'Data package akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post(
            base_url + 'packages/delete', {
              id_package: id_package
            },
            function(res) {
              Swal.fire(
                'Berhasil',
                'Package berhasil dihapus',
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

  });

  function getItemRow() {
    return `
            <div class="row g-2 package-item-row align-items-center mb-3">
              <div class="col-md-7">
                <select name="id_addon[]" class="form-select addon-select">
                  <option value="">Pilih Add-on</option>
                  ${window.addon_options}
                </select>
              </div>
              <div class="col-md-3">
                <input type="number" name="qty[]" class="form-control text-center" value="1" min="1">
              </div>
              <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger w-100 btn-remove-item mb-0">
                  <i class="material-symbols-rounded text-sm">delete</i>
                </button>
              </div>
            </div>
          `;
  }

  function initAddonSelect() {
    $('.addon-select').select2({
      dropdownParent: $('#modalPackage'),
      width: '100%'
    });
  }

  function updateTotalItem() {
    let total = $('.package-item-row').length;
    $('#total_item').val(total + ' Item');
  }

  function previewPackageImage(input) {
    if (input.files && input.files[0]) {
      let reader = new FileReader();
      reader.onload = function(e) {
        $('#preview_package').attr('src', e.target.result);
      }
      reader.readAsDataURL(input.files[0]);
    }
  }

  function filterPackage() {
    let keyword = $('#filter_package_name').val().toLowerCase();
    let duration = $('#filter_duration').val();
    let price = $('#filter_price').val();
    let addons = $('#filter_addon').val() || [];

    let visible = 0;
    $('.package-item').each(function() {
      let show = true;
      let name = $(this).data('name');
      let dur = $(this).data('duration');
      let packagePrice = $(this).data('price');
      let packageAddons = ($(this).data('addons') + '').split(',');
      if (keyword && !name.includes(keyword)) show = false;
      if (duration && dur != duration) show = false;
      if (price && parseInt(packagePrice) > parseInt(price)) show = false;
      if (addons.length > 0) {
        addons.forEach(function(id) {
          if (!packageAddons.includes(id))
            show = false;
        });
      }

      $(this).toggle(show);
      if (show)
        visible++;
    });

    $('#empty_result').toggleClass('d-none', visible > 0);
  }
</script>