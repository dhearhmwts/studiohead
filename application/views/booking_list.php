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
          <input type="date" id="date_from" class="form-control border">
        </div>
        <div class="col-md-2">
          <label class="form-label text-xs fw-bold text-secondary text-uppercase">
            Sampai
          </label>
          <input type="date" id="date_to" class="form-control border">
        </div>
      </div>
      <div class="table-responsive">
        <table id="table" class="table table-sm table-hover align-middle mb-0 text-sm">
          <thead class="table-light text-secondary text-uppercase text-xs text-center">
            <tr>
              <th width="5%">#</th>
              <th>Booking Code</th>
              <th>Customer</th>
              <th>Studio</th>
              <th>Tanggal</th>
              <th>Jam</th>
              <!-- <th>Total</th> -->
              <th>Booking Status</th>
              <th>Payment Status</th>
              <th width="15%">Action</th>
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
      <div class="modal-header border-0 pb-0">
        <div>
          <h5 class="fw-bold mb-1">Booking Detail</h5>
          <small class="text-muted">Informasi lengkap reservasi studio</small>
        </div>
        <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <div class="row g-3">
          <div class="col-md-8">
            <div class="card border-0 bg-light rounded-4">
              <div class="card-body">
                <div class="row g-3">
                  <div class="col-md-6">
                    <label class="text-muted text-xs">Booking Code</label>
                    <div class="fw-bold fs-5" id="detail_booking_code"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs">Customer</label>
                    <div class="fw-semibold" id="detail_customer"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs">Studio</label>
                    <div id="detail_studio"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs">Schedule</label>
                    <div id="detail_schedule"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs">Package</label>
                    <div id="detail_package"></div>
                  </div>
                  <div class="col-md-6">
                    <label class="text-muted text-xs">Total Payment</label>
                    <div class="fw-bold text-success fs-5" id="detail_total"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4 mt-3">
              <div class="card-body">
                <h6 class="fw-bold mb-3">Add-On Equipment</h6>
                <div id="detail_addons"></div>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 mb-3">
              <div class="card-body">
                <h6 class="fw-bold mb-3">Status</h6>
                <div class="mb-3">
                  <small class="text-muted d-block">Booking Status</small>
                  <div id="detail_booking_status"></div>
                </div>
                <div>
                  <small class="text-muted d-block">Payment Status</small>
                  <div id="detail_payment_status"></div>
                </div>
              </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4">
              <div class="card-body">
                <h6 class="fw-bold mb-3">Timeline</h6>
                <div id="detail_logs"></div>
              </div>
            </div>
          </div>
        </div>
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
          targets: [6, 7],
          className: 'text-center'
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
          previous: "<i class='material-symbols-rounded text-sm'>chevron_left</i>",
          next: "<i class='material-symbols-rounded text-sm'>chevron_right</i>"
        },
        zeroRecords: `
          <div class="text-center py-5 my-3">
            <div class="avatar avatar-xl bg-light rounded-circle mx-auto mb-3 d-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
              <i class="material-symbols-rounded text-secondary" style="font-size: 45px;">search_off</i>
            </div>
            <h5 class="fw-bold text-dark mb-1">Data Tidak Ditemukan</h5>
            <p class="text-muted text-sm mx-auto mb-0" style="max-width: 350px;">
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

    $(document).on('click', '.btn-review', function() {
      let id_booking = $(this).data('id');
      $.ajax({
        url: "<?= site_url('booking/getPaymentDetail') ?>",
        type: "POST",
        data: {
          id_booking: id_booking
        },
        dataType: "json",
        success: function(res) {
          if (!res.status) return;
          let d = res.data;
          $('#id_booking').val(d.id_booking);
          $('#booking_code_detail').text(d.booking_code);
          $('#customer_detail').text(d.full_name);
          $('#studio_detail').text(d.studio_name);
          $('#schedule_detail').text(
            d.booking_date + ' ' +
            d.start_time + ' - ' +
            d.end_time
          );

          $('#total_detail').text(
            'Rp ' + Number(d.amount).toLocaleString('id-ID')
          );

          let file = "<?= base_url('uploads/payments/') ?>" + d.transfer_proof;
          $('#proof_preview').attr('src', file);
          $('#btn-view-file').attr('href', file);
          $('#modalReview').modal('show');
        }
      });
    });

    $('#btn-approve').click(function() {
      Swal.fire({
        title: 'Approval Pembayaran',
        text: 'Apakah Anda yakin dan sudah melakukan verifikasi pembayaran yang dilakukan dengan sistem?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Ya, Approve',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#198754'
      }).then((result) => {

        if (result.isConfirmed) {
          processPayment('approve');
        }

      });

    });

    $('#btn-reject').click(function() {
      let note = $('#note').val().trim();
      if (note === '') {
        Swal.fire({
          icon: 'warning',
          title: 'Catatan Wajib Diisi',
          text: 'Berikan alasan penolakan pembayaran'
        });
        return;
      }

      Swal.fire({
        title: 'Tolak Pembayaran?',
        text: 'Customer harus melakukan booking kembali',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc3545'
      }).then((result) => {
        if (result.isConfirmed) {
          processPayment('reject');
        }
      });
    });

    function processPayment(action) {
      $.ajax({
        url: "<?= site_url('booking/verifyPayment') ?>",
        type: "POST",
        data: {
          id_booking: $('#id_booking').val(),
          action: action,
          note: $('#note').val()
        },
        dataType: "json",
        beforeSend: function() {
          Swal.fire({
            title: 'Memproses...',
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
              title: 'Berhasil',
              text: res.message
            }).then(() => {
              $('#modalReview').modal('hide');
              $('#table').DataTable().ajax.reload(null, false);
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
          console.log(xhr.responseText);
          Swal.fire({
            icon: 'error',
            title: 'Server Error',
            text: 'Terjadi kesalahan pada sistem'
          });
        }
      });
    }

  });
</script>