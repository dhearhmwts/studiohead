<style>
  .tracking-wider {
    letter-spacing: 0.05em;
  }
</style>
<div class="container-fluid py-3" style="background-color: #f8f9fa; min-height: 100vh;">
  <!-- summary -->
  <div class="row g-2 mb-3">
    <div class="col-md-3">
      <div class="card border-0 rounded-3 shadow-sm bg-light">
        <div class="card-body p-3 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Pending</div>
            <h4 class="fw-bold text-dark mb-0 mt-1"><?= $summary['pending'] ?? 0 ?></h4>
          </div>
          <div class="rounded-2 d-flex align-items-center justify-content-center bg-white border text-secondary" style="width: 40px; height: 40px;">
            <i class="material-symbols-outlined" style="font-size: 22px;">pending_actions</i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 rounded-3 shadow-sm bg-light">
        <div class="card-body p-3 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Approved</div>
            <h4 class="fw-bold text-dark mb-0 mt-1"><?= $summary['approved'] ?? 0 ?></h4>
          </div>
          <div class="rounded-2 d-flex align-items-center justify-content-center bg-white border text-secondary" style="width: 40px; height: 40px;">
            <i class="material-symbols-outlined" style="font-size: 22px;">check_circle</i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 rounded-3 shadow-sm bg-light">
        <div class="card-body p-3 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Ongoing</div>
            <h4 class="fw-bold text-dark mb-0 mt-1"><?= $summary['ongoing'] ?? 0 ?></h4>
          </div>
          <div class="rounded-2 d-flex align-items-center justify-content-center bg-white border text-secondary" style="width: 40px; height: 40px;">
            <i class="material-symbols-outlined" style="font-size: 22px;">sync</i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 rounded-3 shadow-sm bg-light">
        <div class="card-body p-3 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-muted fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Completed</div>
            <h4 class="fw-bold text-dark mb-0 mt-1"><?= $summary['completed'] ?? 0 ?></h4>
          </div>
          <div class="rounded-2 d-flex align-items-center justify-content-center bg-white border text-secondary" style="width: 40px; height: 40px;">
            <i class="material-symbols-outlined" style="font-size: 22px;">task</i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- table dan filter -->
  <div class="card border-0 rounded-3 shadow-sm">
    <div class="card-body p-3">
      <div class="row g-2 mb-3 align-items-end">
        <div class="col-md-3">
          <label class="form-label text-xs fw-bold text-secondary text-uppercase">
            Booking Status
          </label>
          <select id="booking_status" class="form-select px-2 border">
            <option value="">Semua Status</option>
            <option value="pending">Pending</option>
            <option value="waiting">Waiting Approval</option>
            <option value="approved">Approved</option>
            <option value="ongoing">Ongoing</option>
            <option value="completed">Completed</option>
            <option value="cancelled">Cancelled</option>
          </select>
        </div>
        <div class="col-md-3">
          <label class="form-label text-xs fw-bold text-secondary text-uppercase">
            Payment Status
          </label>
          <select id="payment_status" class="form-select px-2 border">
            <option value="">Semua Status</option>
            <option value="unpaid">Unpaid</option>
            <option value="waiting_verification">Waiting Verification</option>
            <option value="paid">Paid</option>
            <option value="rejected">Rejected</option>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label text-xs fw-bold text-secondary text-uppercase">
            Studio
          </label>
          <select id="studio" class="form-select px-2 border">
            <option value="">Semua Studio</option>
            <?php foreach ($studios as $studio): ?>
              <option value="<?= $studio['id_studio'] ?>">
                <?= $studio['studio_name'] ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-2">
          <label class="form-label text-xs fw-bold text-secondary text-uppercase">
            Dari
          </label>
          <input type="date" id="date_from" class="form-control border px-2">
        </div>
        <div class="col-md-2">
          <label class="form-label text-xs fw-bold text-secondary text-uppercase">
            Sampai
          </label>
          <input type="date" id="date_to" class="form-control border px-2">
        </div>
      </div>
      <div class="table-responsive">
        <table id="table" class="table table-sm table-hover align-middle mb-0 text-sm">
          <thead class="table-light text-secondary text-uppercase text-xs text-center">
            <tr>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" width="5%">#</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Booking Code</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Customer</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Studio</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Tanggal</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Jam</th>
              <!-- <th>Total</th> -->
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Booking Status</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Payment Status</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" width="10%">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-lg">
      <div class="modal-header border-0 pb-0 pt-4 px-4">
        <div>
          <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2 text-xs fw-bold mb-2">RESERVASI STUDIO</span>
          <h4 class="fw-bold m-0 text-dark">Detail Booking</h4>
          <p class="text-muted text-xs mt-1 mb-0">Informasi lengkap terkait jadwal, pembayaran, dan riwayat reservasi</p>
        </div>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <div class="row g-4">
          <div class="col-md-8">
            <div class="card border-0 bg-light rounded-4 shadow-sm mb-4">
              <div class="card-body p-4">
                <div class="row g-4">
                  <div class="col-md-6">
                    <label class="text-muted text-xs d-block mb-1">Booking Code</label>
                    <div class="fw-bold text-primary text-md" id="detail_booking_code"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs d-block mb-1">Customer</label>
                    <div class="fw-bold text-dark text-md" id="detail_customer"></div>
                  </div>
                  <div class="col-12 my-2">
                    <hr class="text-muted opacity-25 m-0">
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs d-block mb-2">Booking Status</label>
                    <div id="detail_booking_status" class="d-inline-block"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs d-block mb-2">Payment Status</label>
                    <div id="detail_payment_status" class="d-inline-block"></div>
                  </div>
                  <div class="col-12 my-2">
                    <hr class="text-muted opacity-25 m-0">
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs d-block mb-1">Studio</label>
                    <div class="fw-semibold text-dark text-sm" id="detail_studio"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs d-block mb-1">Schedule</label>
                    <div class="fw-semibold text-dark text-sm" id="detail_schedule"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs d-block mb-1">Package</label>
                    <div class="fw-semibold text-dark text-sm" id="detail_package"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs d-block mb-1">Total Payment</label>
                    <div class="fw-bold text-success text-md" id="detail_total"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4">
              <div class="card-body p-4">
                <div class="d-flex align-items-center mb-3">
                  <h6 class="fw-bold text-dark m-0 text-sm">Add-On Equipment</h6>
                </div>
                <div id="detail_addons" class="d-flex flex-wrap gap-2"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4">
              <div class="card-body p-4">
                <h6 class="fw-bold text-dark mb-4 text-sm">Timeline Aktivitas</h6>
                <div class="position-relative ps-2" id="detail_logs" style="border-left: 2px dashed #e9ecef; margin-left: 10px;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalCancel" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-lg">
      <div class="modal-header border-0 pb-0 pt-4 px-4 d-flex align-items-start">
        <div class="d-flex align-items-center gap-2">
          <span class="material-symbols-outlined text-danger" style="font-size: 28px;">cancel_presentation</span>
          <div>
            <h5 class="fw-bold text-danger mb-0">Cancel Booking</h5>
            <p class="text-muted text-xs mb-0 mt-0.5">Konfirmasi pembatalan reservasi studio</p>
          </div>
        </div>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body px-4 py-3">
        <input type="hidden" id="cancel_id_booking">
        <div class="bg-danger-subtle text-danger-emphasis rounded-4 p-3 mb-4 border border-danger-subtle">
          <div class="d-flex align-items-center gap-2 mb-2">
            <span class="material-symbols-outlined text-danger text-sm">confirmation_number</span>
            <div class="fw-bold text-md" id="cancel_booking_code"></div>
          </div>
          <div class="row g-2 text-xs pt-2 border-top border-danger-subtle text-muted">
            <div class="col-6 d-flex align-items-center gap-1">
              <span class="material-symbols-outlined text-secondary" style="font-size: 16px;">person</span>
              <span id="cancel_customer" class="fw-semibold text-dark"></span>
            </div>
            <div class="col-6 d-flex align-items-center gap-1">
              <span class="material-symbols-outlined text-secondary" style="font-size: 16px;">storefront</span>
              <span id="cancel_studio" class="fw-semibold text-dark"></span>
            </div>
            <div class="col-12 d-flex align-items-center gap-1 mt-1">
              <span class="material-symbols-outlined text-secondary" style="font-size: 16px;">calendar_month</span>
              <span id="cancel_schedule" class="fw-semibold text-dark"></span>
            </div>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label fw-bold text-dark text-xs mb-2 d-flex align-items-center gap-1">
            <span class="material-symbols-outlined text-secondary" style="font-size: 16px;">rate_review</span> Alasan Pembatalan
          </label>
          <textarea id="cancel_reason" class="form-control border p-3 text-sm shadow-none" rows="4" placeholder="Tuliskan alasan pembatalan secara jelas disini..."></textarea>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex gap-2">
        <button type="button" class="btn btn-light rounded-3 text-sm px-3 py-2 flex-grow-1 border" data-bs-dismiss="modal">
          Tutup
        </button>
        <button type="button" class="btn btn-danger rounded-3 text-sm px-3 py-2 flex-grow-1 d-flex align-items-center justify-content-center gap-1 shadow-sm" id="btn-save-cancel">
          <span class="material-symbols-outlined" style="font-size: 18px;">delete_forever</span> Batalkan Booking
        </button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalReschedule" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-lg">
      <div class="modal-header border-0 pb-0 pt-4 px-4">
        <div class="d-flex align-items-center gap-2">
          <span class="material-symbols-outlined text-warning" style="font-size: 28px;">update</span>
          <div>
            <h5 class="fw-bold text-dark mb-0">Reschedule Booking</h5>
            <p class="text-muted text-xs mb-0 mt-0.5">Perubahan tanggal dan waktu reservasi studio</p>
          </div>
        </div>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <input type="hidden" id="reschedule_id_booking">
        <div class="row g-4">
          <div class="col-md-5">
            <div class="h-100 bg-warning-subtle text-warning-emphasis p-4 rounded-4 d-flex flex-column justify-content-between border border-warning-subtle">
              <div>
                <span class="badge bg-warning text-dark text-xs rounded-pill px-3 py-1.5 fw-bold mb-3">JADWAL SAAT INI</span>
                <div class="d-flex align-items-center gap-2 mb-2">
                  <span class="material-symbols-outlined text-warning text-sm">confirmation_number</span>
                  <div class="fw-bold text-md text-dark" id="reschedule_booking_code"></div>
                </div>
                <p class="text-muted text-xs mb-4">Pastikan Anda telah mengonfirmasi perubahan ini dengan pelanggan sebelum menyimpan jadwal baru.</p>
              </div>
              <div class="pt-3 border-top border-warning-subtle">
                <div class="d-flex align-items-start gap-2">
                  <span class="material-symbols-outlined text-secondary mt-0.5" style="font-size: 18px;">calendar_today</span>
                  <div>
                    <small class="text-muted d-block text-xs">Waktu Reservasi</small>
                    <div class="fw-bold text-dark text-sm mt-0.5" id="reschedule_current_schedule"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-7">
            <div class="row g-3">
              <div class="col-sm-6">
                <label class="form-label fw-bold text-dark text-xs mb-2 d-flex align-items-center gap-1">
                  <span class="material-symbols-outlined text-secondary" style="font-size: 16px;">edit_calendar</span>
                  Tanggal Baru
                </label>
                <input type="date" id="new_booking_date" class="form-control border rounded-3 px-3 py-2 text-sm shadow-none">
              </div>
              <div class="col-sm-6">
                <label class="form-label fw-bold text-dark text-xs mb-2 d-flex align-items-center gap-1">
                  <span class="material-symbols-outlined text-secondary" style="font-size: 16px;">schedule</span> Jam Mulai Baru
                </label>
                <select id="new_start_time" class="form-select border border-secondary rounded-3 px-3 py-2 bg-white">
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
              <div class="col-12">
                <label class="form-label fw-bold text-dark text-xs mb-2 d-flex align-items-center gap-1">
                  <span class="material-symbols-outlined text-secondary" style="font-size: 16px;">note_alt</span> Catatan Reschedule
                </label>
                <textarea id="reschedule_note" class="form-control border rounded-3 px-3 py-2 text-sm shadow-none" rows="3" placeholder="Tuliskan alasan perubahan jadwal atau info tambahan..."></textarea>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0 pb-4 px-4 d-flex justify-content-end gap-2">
        <button type="button" class="btn btn-light rounded-3 text-sm px-4 py-2 border" data-bs-dismiss="modal">
          Tutup
        </button>
        <button type="button" class="btn btn-warning rounded-3 text-sm text-dark px-4 py-2 d-flex align-items-center gap-1 fw-semibold shadow-sm" id="btn-save-reschedule">
          <span class="material-symbols-outlined" style="font-size: 18px;">save</span> Simpan Perubahan
        </button>
      </div>
    </div>
  </div>
</div>

<script>
  $(function() {
    const table = $('#table').DataTable({
      processing: true,
      serverSide: true,
      searching: false,
      lengthChange: false,
      autoWidth: false,
      ajax: {
        url: "<?= site_url('booking/getBookingList') ?>",
        type: "POST",
        data: function(d) {
          d.booking_status = $('#booking_status').val();
          d.payment_status = $('#payment_status').val();
          d.studio = $('#studio').val();
          d.date_from = $('#date_from').val();
          d.date_to = $('#date_to').val();
        }
      },
      columnDefs: [{
          targets: [0, 4, 5, 6, 7, 8],
          className: 'text-center align-middle'
        },
        {
          targets: [1, 2, 3],
          className: 'align-middle'
        },
        {
          targets: [0, 6, 7, 8],
          orderable: false
        }
      ],
      language: {
        lengthMenu: "Tampilkan _MENU_ data per halaman",
        info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
        infoEmpty: "Menampilkan 0 sampai 0 dari 0 entri",
        infoFiltered: "(disaring dari _MAX_ total entri)",
        paginate: {
          previous: "<i class='material-symbols-outlined text-sm align-middle'>chevron_left</i>",
          next: "<i class='material-symbols-outlined text-sm align-middle'>chevron_right</i>"
        },
        zeroRecords: `
          <div class="text-center py-5 my-3">
            <div class="avatar avatar-xl bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
              <i class="material-symbols-outlined text-secondary" style="font-size: 45px;">search_off</i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Data Tidak Ditemukan</h5>
            <p class="text-muted text-xs mx-auto mb-0" style="max-width: 350px;">
              Maaf, kami tidak menemukan data booking<br>yang cocok dengan filter pencarian kamu.
            </p>
          </div>
        `
      }
    });

    $('#btn-filter').on('click', function() {
      table.ajax.reload();
    });

    $('#booking_status,#payment_status,#studio,#date_from,#date_to').on('change', function() {
      table.ajax.reload();
    });

    function loadBookingDetail(id_booking, callback) {
      $.ajax({
        url: "<?= site_url('booking/getBookingDetail') ?>",
        type: "POST",
        data: {
          id_booking: id_booking
        },
        dataType: "json",
        success: function(res) {
          if (!res.status) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal mengambil data.',
              text: res.message
            });
            return;
          }
          callback(res);
        }
      });
    }

    $(document).on('click', '.btn-detail', function() {
      let id_booking = $(this).data('id');
      loadBookingDetail(id_booking, function(res) {
        let booking = res.data;
        let addons = res.addons;
        let logs = res.logs;

        $('#detail_booking_code').text(booking.booking_code);
        $('#detail_customer').text(booking.full_name);
        $('#detail_studio').text(booking.studio_name);

        $('#detail_schedule').text(
          booking.booking_date + ' | ' +
          booking.start_time.substring(0, 5) + ' - ' +
          booking.end_time.substring(0, 5)
        );

        $('#detail_package').text(booking.package_name ?? '-');
        $('#detail_total').text('Rp ' + Number(booking.total_price).toLocaleString('id-ID'));
        $('#detail_booking_status').html(bookingBadge(booking.booking_status));
        $('#detail_payment_status').html(paymentBadge(booking.payment_status));

        let addonHtml = '';
        if (addons.length) {
          addons.forEach(function(item) {
            addonHtml += `<span class="badge bg-white text-dark border rounded-pill px-3 py-2 text-xs shadow-sm">${item.addon_name}</span>`;
          });
        } else {
          addonHtml = `<span class="text-muted text-xs italic">Tidak ada add-on tambahan</span>`;
        }
        $('#detail_addons').html(addonHtml);

        let logHtml = '';
        let totalLogs = logs.length;
        logs.forEach(function(log, index) {
          let isLast = (index === totalLogs - 1);
          let status = log.status_to;
          let dotColor = 'bg-light';

          if (['pending', 'waiting_approval'].includes(status)) {
            dotColor = 'bg-warning';
          } else if (['approved', 'completed'].includes(status)) {
            dotColor = 'bg-success';
          } else if (status === 'ongoing') {
            dotColor = 'bg-info';
          } else if (status === 'cancelled') {
            dotColor = 'bg-danger';
          }

          let statusText = log.status_to.replaceAll('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
          let dateObj = new Date(log.changed_at);
          let options = {
            day: '2-digit',
            month: 'short',
            year: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
            hour12: false
          };
          let formattedDate = dateObj.toLocaleDateString('id-ID', options).replace(/\./g, ':') + ' WIB';

          logHtml += `
                    <div class="d-flex position-relative ${!isLast ? 'mb-3 pb-2' : ''}">
                      <div class="me-3 d-flex flex-column align-items-center position-relative">
                        <div class="rounded-circle ${dotColor} shadow-sm" style="width: 12px; height: 12px; margin-top: 5px; z-index: 2;"></div>
                        
                        ${!isLast ? `
                          <div class="bg-light position-absolute" style="width: 2px; top: 17px; bottom: -15px; left: 50%; transform: translateX(-50%); z-index: 1; opacity: 0.7;"></div>
                        ` : ''}
                      </div>
                      
                      <div class="d-flex flex-column justify-content-center">
                        <div class="fw-bold text-dark mb-0 text-sm" style="line-height: 1.3;">
                          ${statusText}
                        </div>
                        <div class="text-muted text-xs mt-1">
                          ${formattedDate}
                        </div>
                      </div>
                    </div>
                  `;
        });

        $('#detail_logs').html(logHtml);
        $('#modalDetail').modal('show');
      });
    });

    $(document).on('click', '.btn-cancel', function() {
      let id_booking = $(this).data('id');

      loadBookingDetail(id_booking, function(res) {
        let booking = res.data;

        $('#cancel_id_booking').val(booking.id_booking);
        $('#cancel_booking_code').text(booking.booking_code);
        $('#cancel_customer').text(booking.full_name);
        $('#cancel_studio').text(booking.studio_name);

        let dateObj = new Date(booking.booking_date);
        let options = {
          day: '2-digit',
          month: 'short',
          year: 'numeric'
        };
        let formattedDate = dateObj.toLocaleDateString('id-ID', options);
        let startTime = booking.start_time.substring(0, 5);
        $('#cancel_schedule').text(formattedDate + ' | ' + startTime + ' WIB');
        $('#cancel_reason').val('');
        $('#modalCancel').modal('show');
      });
    });

    $('#btn-save-cancel').click(function() {
      let reason = $('#cancel_reason').val().trim();
      if (reason === '') {
        Swal.fire({
          icon: 'warning',
          title: 'Peringatan',
          text: 'Alasan pembatalan wajib diisi'
        });
        return;
      }

      Swal.fire({
        title: 'Batalkan Booking?',
        text: 'Booking akan dibatalkan permanen',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Batalkan',
        cancelButtonText: 'Kembali'
      }).then((result) => {
        if (!result.isConfirmed) return;
        $.ajax({
          url: "<?= site_url('booking/cancelBooking') ?>",
          type: "POST",
          data: {
            id_booking: $('#cancel_id_booking').val(),
            reason: reason
          },
          dataType: "json",
          success: function(res) {
            if (res.status) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: res.message
              });
              $('#modalCancel').modal('hide');
              location.reload();
            } else {
              Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: res.message
              });
            }
          }
        });
      });
    });

    $(document).on('click', '.btn-reschedule', function() {
      let id_booking = $(this).data('id');
      loadBookingDetail(id_booking, function(res) {
        let booking = res.data;

        $('#reschedule_id_booking').val(booking.id_booking);
        $('#reschedule_booking_code').text(booking.booking_code);

        let dateObj = new Date(booking.booking_date);
        let options = {
          day: '2-digit',
          month: 'short',
          year: 'numeric'
        };
        let formattedDate = dateObj.toLocaleDateString('id-ID', options);
        let startTime = booking.start_time.substring(0, 5);
        let endTime = booking.end_time.substring(0, 5);
        $('#reschedule_current_schedule').html(`${formattedDate}<br><span class="text-muted fw-normal">${startTime} - ${endTime} WIB</span>`);
        $('#new_booking_date').val(booking.booking_date);
        $('#new_start_time').val(booking.start_time.substring(0, 5));
        $('#reschedule_note').val('');
        $('#modalReschedule').modal('show');
      });
    });

    $('#btn-save-reschedule').click(function() {
      let booking_date = $('#new_booking_date').val();
      let start_time = $('#new_start_time').val();
      if (booking_date === '' || start_time === '') {
        Swal.fire({
          icon: 'warning',
          title: 'Peringatan',
          text: 'Tanggal dan jam wajib diisi'
        });
        return;
      }

      Swal.fire({
        title: 'Simpan Perubahan Jadwal?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Simpan',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (!result.isConfirmed) return;
        $.ajax({
          url: "<?= site_url('booking/rescheduleBooking') ?>",
          type: "POST",
          data: {
            id_booking: $('#reschedule_id_booking').val(),
            booking_date: booking_date,
            start_time: start_time,
            note: $('#reschedule_note').val()
          },
          dataType: "json",
          success: function(res) {
            if (res.status) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: res.message
              });
              $('#modalReschedule').modal('hide');
              location.reload();
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
    });

  });

  function bookingBadge(status) {
    const badge = {
      pending: 'warning',
      waiting_approval: 'warning',
      approved: 'info text-white',
      ongoing: 'success text-white',
      completed: 'dark text-white',
      cancelled: 'danger text-white'
    };

    return `<span class="badge bg-${badge[status]}">${status.replaceAll('_',' ')}</span>`;
  }

  function paymentBadge(status) {
    const badge = {
      unpaid: 'dark text-white',
      waiting: 'warning',
      paid: 'success text-white',
      rejected: 'danger text-white'
    };

    return `<span class="badge bg-${badge[status]}">${status.replaceAll('_',' ')}</span>`;
  }
</script>