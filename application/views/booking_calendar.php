<style>
  .stat-card {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(0, 0, 0, 0.03) !important;
  }

  .stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 20px -10px rgba(0, 0, 0, 0.1), 0 4px 20px 0px rgba(0, 0, 0, 0.05);
  }

  .icon-shape {
    width: 48px;
    height: 48px;
    background-position: center;
    border-radius: 0.75rem;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .fc {
    --fc-border-color: #f0f2f5;
    --fc-today-bg-color: rgba(233, 30, 99, 0.04);
    font-family: inherit;
  }

  .calendar-wrapper {
    background: #ffffff;
    border-radius: 1rem;
    overflow: hidden;
  }

  .fc .fc-resource-timeline-sidebar {
    border-top-left-radius: 12px;
  }

  .fc-theme-standard .fc-scrollgrid {
    border-radius: 12px;
    overflow: hidden;
  }

  .fc-timeline-event {
    border: none !important;
    padding: 5px 8px !important;
    border-radius: 6px !important;
    transition: all 0.2s ease-in-out;
    cursor: pointer;
  }

  .fc-timeline-event:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    filter: brightness(1.1);
  }

  .calendar-loading {
    display: none;
    position: absolute;
    right: 25px;
    top: 25px;
    z-index: 10;
  }
</style>
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
  <div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card border-0 rounded-4 shadow-sm">
        <div class="card-body p-3 shadow-sm rounded-4">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="text-xs text-uppercase text-muted fw-bold d-block mb-1">Total Hari Ini</span>
              <h2 class="fw-bolder text-dark mb-0"><?= $summary['total'] ?? 0 ?></h2>
            </div>
            <div class="icon-shape bg-light shadow-sm text-secondary">
              <span class="material-symbols-outlined fs-2">dashboard</span>
            </div>
          </div>
          <div class="mt-2">
            <span class="text-xs text-muted">Seluruh jadwal terdaftar</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card border-0 rounded-4 shadow-sm">
        <div class="card-body p-3 shadow-sm rounded-4">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="text-xs text-uppercase text-primary fw-bold d-block mb-1">Approved</span>
              <h2 class="fw-bolder text-primary mb-0"><?= $summary['approved'] ?? 0 ?></h2>
            </div>
            <div class="icon-shape shadow-sm text-primary" style="background-color: rgba(13, 110, 253, 0.1);">
              <span class="material-symbols-outlined fs-2">event_available</span>
            </div>
          </div>
          <div class="mt-2">
            <span class="text-xs text-muted">Siap untuk dimulai</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card border-0 rounded-4 shadow-sm">
        <div class="card-body p-3 shadow-sm rounded-4">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="text-xs text-uppercase text-success fw-bold d-block mb-1">Ongoing</span>
              <h2 class="fw-bolder text-success mb-0"><?= $summary['ongoing'] ?? 0 ?></h2>
            </div>
            <div class="icon-shape shadow-sm text-success" style="background-color: rgba(25, 135, 84, 0.1);">
              <span class="material-symbols-outlined fs-2">play_circle</span>
            </div>
          </div>
          <div class="mt-2">
            <span class="text-xs text-muted">Sesi sedang berlangsung</span>
          </div>
        </div>
      </div>
    </div>
    <div class="col-sm-6 col-xl-3">
      <div class="card stat-card border-0 rounded-4 shadow-sm">
        <div class="card-body p-3 shadow-sm rounded-4">
          <div class="d-flex align-items-center justify-content-between">
            <div>
              <span class="text-xs text-uppercase text-dark fw-bold d-block mb-1">Completed</span>
              <h2 class="fw-bolder text-dark mb-0"><?= $summary['completed'] ?? 0 ?></h2>
            </div>
            <div class="icon-shape shadow-sm text-dark" style="background-color: rgba(33, 37, 41, 0.1);">
              <span class="material-symbols-outlined fs-2">task_alt</span>
            </div>
          </div>
          <div class="mt-2">
            <span class="text-xs text-muted">Sesi selesai hari ini</span>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="card calendar-wrapper border-0 shadow-sm position-relative">
    <div class="calendar-loading spinner-border text-primary spinner-border-sm" role="status">
      <span class="visually-hidden">Loading...</span>
    </div>
    <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
      <div class="d-flex align-items-center gap-2">
        <div class="p-2 bg-light rounded-3 d-inline-flex align-items-center justify-content-center text-dark">
          <span class="material-symbols-outlined fs-3">calendar_today</span>
        </div>
        <div>
          <h5 class="fw-bold text-dark mb-0">Live Monitor Jadwal</h5>
          <small class="text-muted text-xs">Pantau penggunaan ruangan studio secara real-time</small>
        </div>
      </div>
      <hr class="horizontal dark my-3">
    </div>
    <div class="card-body px-4 pb-4 pt-0">
      <div id="booking-calendar"></div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalDetail" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 rounded-4 shadow-lg">
      <div class="modal-header border-0 pb-0">
        <h5 class="fw-bold mb-0">Rincian Sesi Booking</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <input type="hidden" id="hidden_id_booking">
        <div class="row g-3">
          <div class="col-md-8">
            <div class="card border-0 bg-light rounded-3 mb-3">
              <div class="card-body p-4">
                <div class="row g-3">
                  <div class="col-md-6">
                    <small class="text-muted d-block mb-1">Booking Code</small>
                    <strong class="text-dark fs-5" id="detail_booking_code">-</strong>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted d-block mb-1">Customer</small>
                    <div class="fw-semibold text-dark" id="detail_customer">-</div>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted d-block mb-1">Studio Room</small>
                    <div class="fw-semibold text-dark" id="detail_studio">-</div>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted d-block mb-1">Schedule</small>
                    <div class="fw-semibold text-dark" id="detail_schedule">-</div>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted d-block mb-1">Package Choice</small>
                    <div class="fw-semibold text-dark" id="detail_package">-</div>
                  </div>
                  <div class="col-md-6">
                    <small class="text-muted d-block mb-1">Status / Payment</small>
                    <div class="d-flex gap-2 mt-1" id="detail_status_wrapper">
                      <span id="detail_booking_status"></span>
                      <span id="detail_payment_status"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="card border-0 bg-light rounded-3">
              <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-tools me-2 text-primary"></i>Add-On Equipment</h6>
                <div id="detail_addons" class="d-flex flex-wrap gap-2"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-0 bg-light rounded-3 h-100">
              <div class="card-body p-4">
                <h6 class="fw-bold mb-3"><i class="bi bi-clock-history me-2 text-success"></i>Activity Logs</h6>
                <div id="detail_logs" class="mt-2"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer border-0 pt-0">
        <button type="button" class="btn btn-primary px-4 rounded-3 btn-start" id="btn-start-session" style="display:none;">Mulai Sesi</button>
        <button type="button" class="btn btn-success px-4 rounded-3 btn-complete" id="btn-complete-session" style="display:none;">Selesaikan Sesi</button>
        <button type="button" class="btn btn-secondary px-3 rounded-3" data-bs-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    const $calendarEl = $('#booking-calendar');
    const $loadingSpinner = $('.calendar-loading');

    if ($calendarEl.length) {
      const calendar = new FullCalendar.Calendar($calendarEl[0], {
        schedulerLicenseKey: 'CC-Attribution-NonCommercial-NoDerivatives',
        initialView: 'resourceTimelineDay',
        height: 'auto',
        nowIndicator: true,
        slotMinTime: "06:00:00",
        slotMaxTime: "24:00:00",
        resourceAreaHeaderContent: 'Studio',
        headerToolbar: {
          left: '',
          center: 'title',
          right: ''
        },
        resources: <?= json_encode(array_map(function ($s) {
                      return [
                        'id' => $s['id_studio'],
                        'title' => $s['studio_name']
                      ];
                    }, $studios)); ?>,
        events: function(info, successCallback, failureCallback) {
          $.ajax({
            url: "<?= site_url('booking/getCalendarEvents') ?>",
            type: "POST",
            dataType: "json",
            success: function(res) {
              successCallback(res);
            },
            error: function() {
              failureCallback();
              alert('Gagal memuat event kalender hari ini.');
            }
          });
        },
        eventClick: function(info) {
          let id = info.event.id;
          loadBookingDetail(id, function(res) {
            let booking = res.data;
            let addons = res.addons;
            let logs = res.logs;

            $('#hidden_id_booking').val(booking.id_booking);
            $('#btn-start-session, #btn-complete-session').data('id', booking.id_booking);

            $('#detail_booking_code').text(booking.booking_code);
            $('#detail_customer').text(booking.full_name);
            $('#detail_studio').text(booking.studio_name);
            $('#detail_package').text(booking.package_name ?? '-');

            let startTime = booking.start_time.substring(0, 5);
            let endTime = booking.end_time.substring(0, 5);
            $('#detail_schedule').text(`${booking.booking_date} | ${startTime} - ${endTime}`);

            $('#detail_booking_status').html(bookingBadge(booking.booking_status));
            $('#detail_payment_status').html(paymentBadge(booking.payment_status));

            let addonHtml = '';
            if (addons && addons.length) {
              addons.forEach(function(item) {
                addonHtml += `<span class="badge bg-white text-dark border rounded-pill px-3 py-2 shadow-sm text-xs">${item.addon_name}</span>`;
              });
            } else {
              addonHtml = `<span class="text-muted text-xs fs-italic">Tidak ada add-on tambahan</span>`;
            }
            $('#detail_addons').html(addonHtml);

            let logHtml = '';
            if (logs) {
              let totalLogs = logs.length;
              logs.forEach(function(log, index) {
                let isLast = (index === totalLogs - 1);
                let status = log.status_to;
                let dotColor = 'bg-secondary';

                if (['pending', 'waiting_approval'].includes(status)) dotColor = 'bg-warning';
                else if (['approved', 'completed'].includes(status)) dotColor = 'bg-success';
                else if (status === 'ongoing') dotColor = 'bg-info';
                else if (status === 'cancelled') dotColor = 'bg-danger';

                let statusText = log.status_to.replaceAll('_', ' ').replace(/\b\w/g, l => l.toUpperCase());
                let dateObj = new Date(log.changed_at);
                let formattedDate = dateObj.toLocaleDateString('id-ID', {
                  day: '2-digit',
                  month: 'short',
                  year: 'numeric',
                  hour: '2-digit',
                  minute: '2-digit',
                  hour12: false
                }) + ' WIB';

                logHtml += `
                  <div class="d-flex position-relative ${!isLast ? 'mb-3 pb-2' : ''}">
                    <div class="me-3 d-flex flex-column align-items-center position-relative">
                      <div class="rounded-circle ${dotColor} shadow-sm" style="width: 12px; height: 12px; margin-top: 5px; z-index: 2;"></div>
                      ${!isLast ? `<div class="bg-secondary position-absolute" style="width: 2px; top: 17px; bottom: -15px; left: 50%; transform: translateX(-50%); z-index: 1; opacity: 0.2;"></div>` : ''}
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                      <div class="fw-bold text-dark mb-0 text-sm" style="line-height: 1.3;">${statusText}</div>
                      <div class="text-muted text-xs mt-1">${formattedDate}</div>
                    </div>
                  </div>`;
              });
            }
            $('#detail_logs').html(logHtml);

            $('#btn-start-session, #btn-complete-session').hide();
            if (booking.booking_status === 'approved') {
              $('#btn-start-session').show();
            } else if (booking.booking_status === 'ongoing') {
              $('#btn-complete-session').show();
            }

            $('#modalDetail').modal('show');
          });
        },

        eventDidMount: function(info) {
          let status = info.event.extendedProps.status;
          let $eventEl = $(info.el);
          if (status === 'approved') {
            $eventEl.css({
              'background-color': '#0d6efd',
              'border-left': '5px solid #0a58ca'
            });
          } else if (status === 'ongoing') {
            $eventEl.css({
              'background-color': '#198754',
              'border-left': '5px solid #146c43'
            });
          } else if (status === 'completed') {
            $eventEl.css({
              'background-color': '#6c757d',
              'border-left': '5px solid #495057'
            });
          }
        }
      });

      calendar.render();
    }

    function loadBookingDetail(id_booking, callback) {
      $.ajax({
        url: "<?= site_url('booking/getBookingDetail') ?>",
        type: "POST",
        data: {
          id_booking: id_booking
        },
        dataType: "json",
        beforeSend: function() {
          $loadingSpinner.show();
        },
        success: function(res) {
          if (!res.status) {
            Swal.fire({
              icon: 'error',
              title: 'Gagal',
              text: res.message
            });
            return;
          }
          callback(res);
        },
        error: function() {
          alert('Gagal menghubungi server.');
        },
        complete: function() {
          $loadingSpinner.hide();
        }
      });
    }

    $(document).on('click', '.btn-detail', function() {
      let id_booking = $(this).data('id');
      loadBookingDetail(id_booking, function(res) {});
    });

    $(document).on('click', '.btn-start, #btn-start-session', function() {
      let id = $(this).is('button') ? $(this).data('id') : $('#hidden_id_booking').val();
      Swal.fire({
        title: 'Mulai Session?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#0d6efd'
      }).then((result) => {
        if (!result.isConfirmed) return;
        $.post("<?= site_url('booking/startSession') ?>", {
          id_booking: id
        }, function(res) {
          if (res.status) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message
            }).then(() => {
              location.reload();
            });
          }
        }, 'json');
      });
    });

    $(document).on('click', '.btn-complete, #btn-complete-session', function() {
      let id = $(this).is('button') ? $(this).data('id') : $('#hidden_id_booking').val();
      Swal.fire({
        title: 'Selesaikan Session?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754'
      }).then((result) => {
        if (!result.isConfirmed) return;
        $.post("<?= site_url('booking/completeSession') ?>", {
          id_booking: id
        }, function(res) {
          if (res.status) {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil',
              text: res.message
            }).then(() => {
              location.reload();
            });
          }
        }, 'json');
      });
    });
  });

  function bookingBadge(status) {
    const badge = {
      pending: 'warning text-dark',
      waiting_approval: 'warning text-dark',
      approved: 'info text-white',
      ongoing: 'success text-white',
      completed: 'dark text-white',
      cancelled: 'danger text-white'
    };
    return `<span class="badge bg-${badge[status] || 'secondary'}">${status.replaceAll('_',' ').toUpperCase()}</span>`;
  }

  function paymentBadge(status) {
    const badge = {
      unpaid: 'dark text-white',
      waiting: 'warning text-dark',
      paid: 'success text-white',
      rejected: 'danger text-white'
    };
    return `<span class="badge bg-${badge[status] || 'secondary'}">${status.replaceAll('_',' ').toUpperCase()}</span>`;
  }
</script>