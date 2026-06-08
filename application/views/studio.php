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
          <h5 class="mb-0">Studio Management</h5>
          <small class="text-muted">Kelola data studio podcast dan live streaming</small>
        </div>
        <button class="btn bg-gradient-dark mb-0" id="btn_add" data-bs-toggle="modal" data-bs-target="#modalStudio">
          <i class="material-symbols-rounded text-sm">add</i>&nbsp;Add Studio
        </button>
      </div>
      <hr>
      <div class="d-flex align-items-center mb-3 text-secondary">
        <i class="material-symbols-rounded me-2 fs-5">tune</i>
        <span class="fw-bold text-xs text-uppercase">Filter Pencarian</span>
      </div>
      <div class="row g-3 align-items-end">
        <div class="col-md-4">
          <label class="form-label text-xs fw-bold text-muted mb-1">Nama Studio</label>
          <div class="input-group border rounded-3 px-2 bg-light">
            <input type="text" id="filter_studio_name" class="form-control border rounded-3 px-3 py-2 text-sm bg-transparent border-0" placeholder="Cari studio...">
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label text-xs fw-bold text-muted mb-1">Kapasitas Studio</label>
          <div class="input-group border rounded-3 px-2 bg-light">
            <input type="number" id="filter_capacity" class="form-control border rounded-3 px-3 py-2 text-sm bg-transparent border-0" placeholder="Kapasitas minimal">
          </div>
        </div>
        <div class="col-md-3">
          <label class="form-label text-xs fw-bold text-muted mb-1">Tipe Studio</label>
          <div class="input-group border rounded-3 px-2 bg-light">
            <select id="filter_category" class="form-select bg-transparent border-0">
              <option value="">Semua Tipe</option>
              <option value="Podcast">Podcast</option>
              <option value="Live Streaming">Live Streaming</option>
              <option value="Hybrid Studio">Hybrid Studio</option>
              <option value="Photography">Photography</option>
            </select>
          </div>
        </div>
        <div class="col-md-2">
          <label class="form-label text-xs fw-bold text-muted mb-1">Status</label>
          <div class="input-group border rounded-3 px-2 bg-light">
            <select id="filter_status" class="form-select bg-transparent border-0">
              <option value="">Semua Status</option>
              <option value="active">Aktif</option>
              <option value="inactive">Non Aktif</option>
            </select>
          </div>
        </div>
      </div>
      <hr>
      <?php if (!empty($studios)): ?>
        <div class="row" id="studio_container">
          <?php foreach ($studios as $studio): ?>
            <div class="col-lg-3 col-md-6 mb-4 studio-item" data-name="<?= strtolower($studio['studio_name']) ?>" data-capacity="<?= $studio['capacity'] ?>" data-type="<?= strtolower($studio['category']) ?>" data-status="<?= strtolower($studio['status']) ?>">
              <div class="card h-100 border-0 shadow-sm studio-card-custom">
                <div class="position-relative overflow-hidden" style="border-top-left-radius:.375rem; border-top-right-radius:.375rem;">
                  <?php
                  $images = !empty($studio['all_images']) ? explode(',', $studio['all_images']) : [];
                  ?>
                  <div id="carouselStudio<?= $studio['id_studio'] ?>" class="carousel slide carousel-fade" data-bs-ride="false">
                    <?php if (count($images) > 1): ?>
                      <div class="carousel-indicators" style="margin-bottom: 0.5rem;">
                        <?php foreach ($images as $index => $img): ?>
                          <button type="button"
                            data-bs-target="#carouselStudio<?= $studio['id_studio'] ?>"
                            data-bs-slide-to="<?= $index ?>"
                            class="<?= $index === 0 ? 'active' : '' ?>"
                            aria-current="<?= $index === 0 ? 'true' : 'false' ?>">
                          </button>
                        <?php endforeach; ?>
                      </div>
                    <?php endif; ?>
                    <div class="carousel-inner">
                      <?php if (!empty($images)): ?>
                        <?php foreach ($images as $index => $img): ?>
                          <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                            <img src="<?= base_url('uploads/studio/' . trim($img)) ?>"
                              class="card-img-top studio-img"
                              style="height:180px; object-fit:cover; transition:transform .3s ease;">
                          </div>
                        <?php endforeach; ?>
                      <?php else: ?>
                        <div class="carousel-item active">
                          <img src="<?= base_url('uploads/studio/default.jpg') ?>"
                            class="card-img-top studio-img"
                            style="height:180px; object-fit:cover;">
                        </div>
                      <?php endif; ?>
                    </div>
                    <?php if (count($images) > 1): ?>
                      <button class="carousel-control-prev" type="button" data-bs-target="#carouselStudio<?= $studio['id_studio'] ?>" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true" style="width: 1.5rem; height: 1.5rem;"></span>
                        <span class="visually-hidden">Previous</span>
                      </button>
                      <button class="carousel-control-next" type="button" data-bs-target="#carouselStudio<?= $studio['id_studio'] ?>" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true" style="width: 1.5rem; height: 1.5rem;"></span>
                        <span class="visually-hidden">Next</span>
                      </button>
                    <?php endif; ?>
                  </div>
                  <?php if ($studio['status'] == 'active'): ?>
                    <span class="position-absolute top-0 end-0 m-3 badge rounded-pill bg-success-subtle text-success border border-success-subtle d-flex align-items-center gap-1" style="z-index: 3;">
                      <span class="spinner-grow spinner-grow-sm text-success" style="width:6px;height:6px;"></span> Active
                    </span>
                  <?php else: ?>
                    <span class="position-absolute top-0 end-0 m-3 badge rounded-pill bg-secondary-subtle text-secondary border border-secondary-subtle d-flex align-items-center gap-1" style="z-index: 3;">
                      <span class="spinner-grow spinner-grow-sm text-secondary" style="width:6px;height:6px;"></span> Inactive
                    </span>
                  <?php endif; ?>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                  <div>
                    <div class="mb-1">
                      <small class="text-uppercase fw-bold text-muted"
                        style="font-size:.75rem;letter-spacing:.5px;">
                        <?= $studio['category'] ?>
                      </small>
                    </div>
                    <h5 class="card-title fw-bold text-dark mb-3">
                      <?= $studio['studio_name'] ?>
                    </h5>
                    <div class="row g-2 py-2 my-2 border-top border-bottom bg-light rounded-3 text-center">
                      <div class="col-6 border-end">
                        <small class="text-muted d-block text-xs mb-1">Kapasitas</small>
                        <span class="fw-semibold text-dark">
                          <i class="material-symbols-rounded text-sm align-middle me-1">groups</i>
                          <?= $studio['capacity'] ?> Orang
                        </span>
                      </div>
                      <div class="col-6">
                        <small class="text-muted d-block text-xs mb-1">Harga / Jam</small>
                        <span class="fw-bold text-primary">
                          Rp <?= number_format($studio['price_per_hour'], 0, ',', '.') ?>
                        </span>
                      </div>
                    </div>
                    <?php if (!empty($studio['description'])): ?>
                      <p class="text-sm text-muted mb-0" style="min-height:42px;">
                        <?= character_limiter(strip_tags($studio['description']), 80) ?>
                      </p>
                    <?php endif; ?>
                  </div>

                  <div class="d-flex gap-2 mt-4">
                    <button type="button" class="btn btn-dark btn-sm flex-fill fw-semibold d-flex align-items-center justify-content-center gap-1 btn-edit" data-id="<?= $studio['id_studio'] ?>">
                      <i class="material-symbols-rounded text-sm">edit</i> Edit
                    </button>
                    <button type="button" class="btn btn-outline-warning btn-sm px-3 btn-status" data-id="<?= $studio['id_studio'] ?>" title="Ubah Status">
                      <i class="material-symbols-rounded text-sm">sync </i>
                    </button>
                    <button type="button" class="btn btn-outline-danger btn-sm px-3 btn-delete" data-id="<?= $studio['id_studio'] ?>" title="Hapus Studio">
                      <i class="material-symbols-rounded text-sm">delete</i>
                    </button>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
        <div id="empty_result" class="text-center py-5 d-none">
          <i class="material-symbols-rounded text-secondary" style="font-size:64px;">search_off</i>
          <h5 class="mt-3 mb-1">Studio Tidak Ditemukan</h5>
          <p class="text-muted">Coba ubah kata kunci atau filter pencarian.</p>
        </div>
      <?php else: ?>
        <div class="card border-0 shadow-sm">
          <div class="card-body text-center py-6">
            <div class="mb-4">
              <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center"
                style="width:100px;height:100px;">
                <i class="material-symbols-rounded text-secondary"
                  style="font-size:48px;">
                  podcasts
                </i>
              </div>
            </div>
            <h4 class="fw-bold text-dark mb-2">
              Belum Ada Studio
            </h4>
            <p class="text-muted mb-4">
              Belum terdapat data studio yang tersimpan.<br>
              Tambahkan studio pertama untuk mulai menerima booking.
            </p>
            <button class="btn bg-gradient-dark" data-bs-toggle="modal" data-bs-target="#modalStudio">
              <i class="material-symbols-rounded me-1">add</i>Tambah Studio Pertama
            </button>
          </div>
        </div>

      <?php endif; ?>
    </div>
  </div>
</div>

<div class="modal fade" id="modalStudio" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 shadow-xl rounded-4 overflow-hidden">
      <form id="form_studio" enctype="multipart/form-data">
        <div class="modal-header border-0 pb-0 px-4 pt-4 bg-white">
          <div class="d-flex align-items-center">
            <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm"
              style="width:46px; height:46px;">
              <i class="material-symbols-rounded" style="font-size: 24px;">podcasts</i>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-dark mb-0" id="modalStudioLabel">Form Informasi Studio</h5>
              <small class="text-muted">Kelola detail properti, harga, dan operasional studio</small>
            </div>
          </div>
          <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <input type="hidden" name="id_studio" id="id_studio">
          <div class="row g-4">
            <div class="col-lg-4">
              <div class="card bg-light border-0 rounded-4 p-3 h-100 d-flex flex-column justify-content-between">
                <div>
                  <label class="form-label text-xs fw-bold text-uppercase tracking-wider text-secondary mb-2">Galeri Foto Studio</label>
                  <div class="position-relative rounded-4 overflow-hidden shadow-sm bg-dark mb-2" style="height:180px;">
                    <img id="preview_studio_main"
                      src="https://placehold.co/600x400?text=Pilih+Foto-Foto+Studio"
                      class="w-100 h-100 opacity-90"
                      style="object-fit:cover;">
                    <span class="position-absolute bottom-0 start-0 m-2 badge bg-dark bg-opacity-75 text-xs" id="image_count_badge">0 Foto Terpilih</span>
                  </div>
                  <div class="row g-2 mb-3" id="thumbnail_container" style="max-height: 120px; overflow-y: auto;">
                    <div class="col-3 thumbnail-placeholder">
                      <div class="border border-dashed rounded-3 d-flex align-items-center justify-content-center bg-white" style="height: 50px;">
                        <i class="material-symbols-rounded text-muted text-sm">image</i>
                      </div>
                    </div>
                    <div class="col-3 thumbnail-placeholder">
                      <div class="border border-dashed rounded-3 d-flex align-items-center justify-content-center bg-white" style="height: 50px;">
                        <i class="material-symbols-rounded text-muted text-sm">image</i>
                      </div>
                    </div>
                    <div class="col-3 thumbnail-placeholder">
                      <div class="border border-dashed rounded-3 d-flex align-items-center justify-content-center bg-white" style="height: 50px;">
                        <i class="material-symbols-rounded text-muted text-sm">image</i>
                      </div>
                    </div>
                    <div class="col-3 thumbnail-placeholder">
                      <div class="border border-dashed rounded-3 d-flex align-items-center justify-content-center bg-white" style="height: 50px;">
                        <i class="material-symbols-rounded text-muted text-sm">image</i>
                      </div>
                    </div>
                  </div>
                </div>
                <div>
                  <div class="input-group input-group-sm">
                    <input type="file" id="studio_images" name="studio_images[]" class="form-control border rounded-3 px-3 py-2 text-sm rounded-3" accept="image/*" multiple onchange="previewMultipleStudio(this)">
                  </div>
                  <div class="d-flex align-items-center gap-1 mt-2 text-muted">
                    <i class="material-symbols-rounded text-sm">info</i>
                    <small style="font-size: 11px;">Bisa pilih banyak foto sekaligus (Maks @2MB)</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-8">
              <div class="row g-3">
                <div class="col-md-8">
                  <label class="form-label text-xs fw-bold text-secondary">Nama Studio</label>
                  <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted"><i class="material-symbols-rounded text-md">badge</i></span>
                    <input type="text" name="studio_name" class="form-control border rounded-3 px-3 py-2 text-sm" placeholder="Contoh: Studio Podcast A">
                  </div>
                </div>
                <div class="col-md-4">
                  <label class="form-label text-xs fw-bold text-secondary">Harga Sewa &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;/jam</label>
                  <div class="input-group">
                    <span class="input-group-text bg-light text-xs fw-semibold">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;RP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
                    <input type="number" name="price_per_hour" class="form-control border rounded-3 px-3 py-2 text-sm text-end pe-5" placeholder="150000">
                  </div>
                </div>
                <div class="col-md-4">
                  <label class="form-label text-xs fw-bold text-secondary">Status Operasional</label>
                  <select name="status" class="form-select fw-semibold text-dark  px-3">
                    <option value="active" class="text-success">🟢 Aktif</option>
                    <option value="inactive" class="text-danger">🔴 Non-Aktif</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="form-label text-xs fw-bold text-secondary">Tipe Ruangan</label>
                  <select name="category" class="form-select  px-3">
                    <option value="">Pilih Tipe</option>
                    <option value="Podcast">Podcast</option>
                    <option value="Live Streaming">Live Streaming</option>
                    <option value="Hybrid Studio">Hybrid Studio</option>
                    <option value="Photography">Photography</option>
                  </select>
                </div>
                <div class="col-md-4">
                  <label class="form-label text-xs fw-bold text-secondary">Maks. Kapasitas (Orang)</label>
                  <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="material-symbols-rounded text-md">groups</i>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </span>
                    <input type="number" name="capacity" class="form-control border rounded-3 px-3 py-2 text-sm pe-5" placeholder="4" min="1">
                  </div>
                </div>
                <div class="col-12">
                  <label class="form-label text-xs fw-bold text-secondary">Fasilitas & Deskripsi</label>
                  <textarea name="description" rows="8" class="form-control border rounded-3 px-3 py-2 text-sm" placeholder="Jelaskan detail fasilitas (misal: 4 Mic Shure MV7, Soundproof, Lighting Godox, dll...)"></textarea>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer border-0 px-4 pb-4 pt-0 bg-white d-flex justify-content-end gap-2">
          <button type="button" class="btn btn-light px-4 rounded-3 text-secondary fw-semibold border" data-bs-dismiss="modal">
            Batal
          </button>
          <button type="submit" class="btn btn-dark px-4 rounded-3 fw-semibold shadow-sm d-flex align-items-center gap-2">
            <i class="material-symbols-rounded text-md">save</i>
            Simpan
          </button>
        </div>

      </form>

    </div>
  </div>
</div>

<script>
  const base_url = '<?= base_url() ?>';

  $(function() {
    $('#filter_studio_name, #filter_capacity').on('keyup', filterStudio);
    $('#filter_category, #filter_status').on('change', filterStudio);
    $('#btn_reset_filter').click(function() {
      $('#filter_studio_name').val('');
      $('#filter_category').val('');
      $('#filter_status').val('');
      $('#filter_capacity').val('');
      filterStudio();
    });

    $('#btn_add').click(function() {
      $('#form_studio')[0].reset();
      $('#id_studio').val('');
      $('#modalStudioLabel').text('Tambah Studio');
      $('#preview_studio').attr('src', 'https://placehold.co/600x400?text=Studio');
    });

    $(document).on('click', '.btn-edit', function() {
      let id_studio = $(this).data('id');
      $.ajax({
        url: base_url + 'studio/get_detail',
        type: 'POST',
        data: {
          id_studio: id_studio
        },
        dataType: 'json',
        success: function(res) {
          let studio = res.studio;
          $('#modalStudioLabel').text('Edit Studio');
          $('#id_studio').val(studio.id_studio);
          $('input[name=studio_name]').val(studio.studio_name);
          $('input[name=capacity]').val(studio.capacity);
          $('input[name=price_per_hour]').val(studio.price_per_hour);
          $('textarea[name=description]').val(studio.description);
          $('select[name=category]').val(studio.category);
          $('select[name=status]').val(studio.status);
          if (res.images.length > 0) {
            $('#preview_studio').attr('src', base_url + 'uploads/studio/' + res.images[0].image_path);
          }
          $('#modalStudio').modal('show');
        }
      });
    });

    $('#form_studio').submit(function(e) {
      e.preventDefault();
      $('.is-invalid').removeClass('is-invalid');
      let error = false;
      if ($.trim($('input[name=studio_name]').val()) == '') {
        $('input[name=studio_name]').addClass('is-invalid');
        error = true;
      }

      if ($('select[name=category]').val() == '') {
        $('select[name=category]').addClass('is-invalid');
        error = true;
      }

      if ($.trim($('input[name=capacity]').val()) == '') {
        $('input[name=capacity]').addClass('is-invalid');
        error = true;
      }

      if ($.trim($('input[name=price_per_hour]').val()) == '') {
        $('input[name=price_per_hour]').addClass('is-invalid');
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

      let formData = new FormData(this);
      $.ajax({
        url: base_url + 'studio/save',
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
          }
        }
      });
    });

    $(document).on('click', '.btn-status', function() {
      let id_studio = $(this).data('id');
      Swal.fire({
        title: 'Ubah Status Studio?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post(
            base_url + 'studio/change_status', {
              id_studio: id_studio
            },
            function() {
              Swal.fire(
                'Berhasil',
                'Status studio berhasil diperbarui',
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
      let id_studio = $(this).data('id');
      Swal.fire({
        title: 'Hapus Studio?',
        text: 'Data studio akan dihapus.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Hapus'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post(
            base_url + 'studio/delete', {
              id_studio: id_studio
            },
            function() {
              Swal.fire(
                'Berhasil',
                'Studio berhasil dihapus',
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

    $('#form_studio input,#form_studio select,#form_studio textarea').on('keyup change', function() {
      $(this).removeClass('is-invalid');
    });

  });

  function filterStudio() {
    let keyword = $('#filter_studio_name').val().toLowerCase();
    let capacity = $('#filter_capacity').val();
    let type = $('#filter_category').val().toLowerCase();
    let status = $('#filter_status').val().toLowerCase();
    let visible = 0;
    $('.studio-item').each(function() {
      let nameData = $(this).data('name');
      let capacities = $(this).data('capacity');
      let typeData = $(this).data('type');
      let statusData = $(this).data('status');

      let show = true;
      if (keyword && !nameData.includes(keyword)) show = false;
      if (capacity && parseInt(capacities) < parseInt(capacity)) show = false;
      if (type && typeData != type) show = false;
      if (status && statusData != status) show = false;

      $(this).toggle(show);
      if (show) visible++;
    });

    $('#empty_result').toggleClass('d-none', visible > 0);
  }

  function previewMultipleStudio(input) {
    const container = document.getElementById('thumbnail_container');
    const mainPreview = document.getElementById('preview_studio_main');
    const badge = document.getElementById('image_count_badge');
    container.innerHTML = '';
    if (input.files && input.files.length > 0) {
      const fileCount = input.files.length;
      badge.innerText = `${fileCount} Foto Terpilih`;
      badge.className = "position-absolute bottom-0 start-0 m-2 badge bg-primary text-xs";
      Array.from(input.files).forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
          if (index === 0) {
            mainPreview.src = e.target.result;
          }
          const col = document.createElement('div');
          col.className = 'col-3';
          col.innerHTML = `
                    <div class="position-relative rounded-3 overflow-hidden border border-white shadow-xs" style="height: 50px; cursor: pointer;" onclick="document.getElementById('preview_studio_main').src='${e.target.result}'">
                        <img src="${e.target.result}" class="w-100 h-100" style="object-fit: cover;">
                    </div>
                `;
          container.appendChild(col);
        }
        reader.readAsDataURL(file);
      });
    } else {
      mainPreview.src = 'https://placehold.co/600x400?text=Pilih+Foto-Foto+Studio';
      badge.innerText = '0 Foto Terpilih';
      badge.className = "position-absolute bottom-0 start-0 m-2 badge bg-dark bg-opacity-75 text-xs";
      container.innerHTML = `
            <div class="col-3"><div class="border border-dashed rounded-3 d-flex align-items-center justify-content-center bg-white" style="height: 50px;"><i class="material-symbols-rounded text-muted text-sm">image</i></div></div>
            <div class="col-3"><div class="border border-dashed rounded-3 d-flex align-items-center justify-content-center bg-white" style="height: 50px;"><i class="material-symbols-rounded text-muted text-sm">image</i></div></div>
            <div class="col-3"><div class="border border-dashed rounded-3 d-flex align-items-center justify-content-center bg-white" style="height: 50px;"><i class="material-symbols-rounded text-muted text-sm">image</i></div></div>
            <div class="col-3"><div class="border border-dashed rounded-3 d-flex align-items-center justify-content-center bg-white" style="height: 50px;"><i class="material-symbols-rounded text-muted text-sm">image</i></div></div>
        `;
    }
  }
</script>