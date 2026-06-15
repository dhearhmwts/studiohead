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
            <p class="text-muted mb-0">Pilih Studio</p>
          </div>
        </div>
        <hr class="border">
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
                      <button type="button" class="btn btn-light btn-sm flex-fill fw-semibold d-flex align-items-center justify-content-center gap-1 btn-preview" data-id="<?= $studio['id_studio'] ?>">
                        Lihat Detail
                      </button>
                      <button type="button" class="btn btn-dark btn-sm flex-fill fw-semibold btn-booking" data-url="<?= base_url('booking/create_booking/' . $studio['id_studio']) ?>">
                        Booking Now
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalStudio" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow-xl rounded-4 overflow-hidden">
      <div class="modal-header border-0 pb-0 px-4 pt-4 bg-white">
        <div class="d-flex align-items-center">
          <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm" style="width:46px; height:46px;">
            <i class="material-symbols-rounded" style="font-size: 24px;">podcasts</i>
          </div>
          <div>
            <h5 class="modal-title fw-bold text-dark mb-0" id="modalStudioLabel">Detail Informasi Studio</h5>
            <small class="text-muted">Pratinjau detail properti, harga, dan operasional studio</small>
          </div>
        </div>
        <button type="button" class="btn-close shadow-none bg-dark" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-4">
          <div class="col-lg-12">
            <div class="card bg-light border-0 rounded-4 p-3 h-100">
              <label class="form-label text-xs fw-bold text-uppercase tracking-wider text-secondary mb-3">Galeri Foto Studio</label>
              <div id="carouselStudio" class="carousel slide rounded-4 overflow-hidden shadow-sm bg-dark" data-bs-ride="carousel" style="height: 300px;">
                <div class="carousel-indicators" id="preview_carousel_indicators"></div>

                <div class="carousel-inner h-100" id="preview_carousel_inner"></div>

                <button class="carousel-control-prev" type="button" data-bs-target="#carouselStudio" data-bs-slide="prev">
                  <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselStudio" data-bs-slide="next">
                  <span class="carousel-control-next-icon" aria-hidden="true"></span>
                  <span class="visually-hidden">Next</span>
                </button>
              </div>
              <div class="d-flex align-items-center gap-1 mt-3 text-muted justify-content-center" id="preview_image_count">
              </div>
              <div class="d-flex align-items-center gap-1 mt-3 text-muted justify-content-center">
                <i class="material-symbols-rounded text-sm">collections</i>
                <small style="font-size: 11px;" id="preview_image_count"></small>
              </div>
            </div>
          </div>
          <div class="col-lg-12">
            <div class="row g-3">
              <div class="col-md-12">
                <label class="form-label text-xs fw-bold text-secondary mb-1">Nama Studio</label>
                <div class="bg-light p-2 px-3 rounded-3 border-0 fw-semibold text-dark text-sm" id="view_studio_name">
                </div>
              </div>
              <div class="col-md-4">
                <label class="form-label text-xs fw-bold text-secondary mb-1">Harga Sewa / Jam</label>
                <div class="bg-light p-2 px-3 rounded-3 border-0 fw-bold text-primary text-sm text-end" id="view_price_per_hour">
                </div>
              </div>
              <div class="col-md-4">
                <label class="form-label text-xs fw-bold text-secondary mb-1">Tipe Ruangan</label>
                <div class="bg-light p-2 px-3 rounded-3 border-0 text-dark text-sm fw-medium" id="view_category">
                </div>
              </div>
              <div class="col-md-4">
                <label class="form-label text-xs fw-bold text-secondary mb-1">Maks. Kapasitas</label>
                <div class="bg-light p-2 px-3 rounded-3 border-0 text-dark text-sm fw-medium" id="view_capacity">
                </div>
              </div>
              <div class="col-12">
                <label class="form-label text-xs fw-bold text-secondary mb-1">Fasilitas & Deskripsi</label>
                <div class="bg-light p-3 rounded-4 border-0 text-dark text-sm" id="view_description" style="min-height: 140px; white-space: pre-line;">
                </div>
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

  $(function() {
    $(document).on('click', '.btn-booking', function() {
      location.href = $(this).data('url');
    });

    $(document).on('click', '.btn-preview', function() {
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
          let images = res.images;

          $('#view_studio_name').text(studio.studio_name);
          $('#view_category').text(studio.category || '-');
          $('#view_capacity').text(studio.capacity + ' Orang');
          $('#view_description').text(studio.description || 'Tidak ada deskripsi.');

          let formattedPrice = new Intl.NumberFormat('id-ID', {
            style: 'currency',
            currency: 'IDR',
            maximumFractionDigits: 0
          }).format(studio.price_per_hour);
          $('#view_price_per_hour').text(formattedPrice + ' / Jam');

          if (studio.status === 'active') {
            $('#view_status').html('🟢 AKTIF').removeClass('bg-danger-subtle text-danger border-danger-subtle').addClass('bg-success-subtle text-success border-success-subtle');
          } else {
            $('#view_status').html('🔴 NON-AKTIF').removeClass('bg-success-subtle text-success border-success-subtle').addClass('bg-danger-subtle text-danger border-danger-subtle');
          }

          let indicatorsHtml = '';
          let carouselHtml = '';

          if (images && images.length > 0) {
            images.forEach(function(img, index) {
              let activeClass = index === 0 ? 'active' : '';
              let ariaCurrent = index === 0 ? 'aria-current="true"' : '';
              let imgUrl = base_url + 'uploads/studio/' + img.image_path;
              indicatorsHtml += `<button type="button" data-bs-target="#carouselStudio" data-bs-slide-to="${index}" class="${activeClass}" ${ariaCurrent}></button>`;
              carouselHtml += `<div class="carousel-item ${activeClass} h-100">
                                <img src="${imgUrl}" class="d-block w-100 h-100" style="object-fit: cover; object-position: center;" alt="Foto ${index + 1}">
                              </div>`;
            });
            $('#preview_image_count').html(`<i class="material-symbols-rounded" style="font-size: 14px;">collections</i><span>${images.length} Foto</span>`);
          } else {
            indicatorsHtml = `<button type="button" data-bs-target="#carouselStudio" data-bs-slide-to="0" class="active" aria-current="true"></button>`;
            carouselHtml = `<div class="carousel-item active h-100">
                              <img src="https://placehold.co/600x400/212529/ffffff?text=Tidak+Ada+Foto" class="d-block w-100 h-100" style="object-fit: cover; object-position: center;">
                            </div>`;
            $('#preview_image_count').html(`<i class="material-symbols-rounded" style="font-size: 14px;">hide_image</i><span>0 Foto</span>`);
          }

          $('#preview_carousel_indicators').html(indicatorsHtml);
          $('#preview_carousel_inner').html(carouselHtml);
          $('#modalStudio').modal('show');
        },
        error: function() {
          alert('Gagal mengambil data studio.');
        }
      });
    });
  });
</script>