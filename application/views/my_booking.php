<style>
  .tracking-wider {
    letter-spacing: 0.05em;
  }
</style>
<div class="container-fluid py-4" style="background-color: #f8f9fa; min-height: 100vh;">
  <!-- summary -->
  <div class="row g-3 mb-4">
    <div class="col-md-3">
      <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="border-radius: 16px; background: #ffffff;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-secondary fw-bold text-uppercase tracking-wider mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Total Booking</div>
            <h2 class="fw-extrabold text-dark mb-0" style="font-weight: 800;"><?= $summary['total'] ?></h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #f1f3f5;">
            <i class="material-symbols-outlined text-dark" style="font-size: 24px;">format_list_bulleted</i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="border-radius: 16px; background: #ffffff;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-secondary fw-bold text-uppercase tracking-wider mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Upcoming</div>
            <h2 class="fw-extrabold text-primary mb-0" style="font-weight: 800; color: #6200ee !important;"><?= $summary['upcoming'] ?></h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #f0e6ff;">
            <i class="material-symbols-outlined" style="font-size: 24px; color: #6200ee;">calendar_month</i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="border-radius: 16px; background: #ffffff;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-secondary fw-bold text-uppercase tracking-wider mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Belum Bayar</div>
            <h2 class="fw-extrabold text-warning mb-0" style="font-weight: 800; color: #f57f17 !important;"><?= $summary['unpaid'] ?></h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #fffde7;">
            <i class="material-symbols-outlined" style="font-size: 24px; color: #f57f17;">hourglass_top</i>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card border-0 shadow-sm rounded-4 position-relative overflow-hidden" style="border-radius: 16px; background: #ffffff;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-secondary fw-bold text-uppercase tracking-wider mb-1" style="font-size: 11px; letter-spacing: 0.5px;">Selesai</div>
            <h2 class="fw-extrabold text-success mb-0" style="font-weight: 800; color: #1b5e20 !important;"><?= $summary['completed'] ?></h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #e8f5e9;">
            <i class="material-symbols-outlined" style="font-size: 24px; color: #1b5e20;">check_circle</i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- table dan filter -->
  <div class="card border-0 shadow-sm rounded-4" style="border-radius: 16px; background: #ffffff;">
    <div class="card-body p-4">
      <div class="d-flex justify-content-between align-items-center mb-4 pb-2">
        <div>
          <h4 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px;">My Booking</h4>
          <p class="text-secondary small mb-0">
            Pantau jadwal, status pembayaran, dan verifikasi riwayat pemesanan Anda.
          </p>
        </div>
      </div>
      <div class="p-3 mb-4 rounded-3 d-flex flex-wrap align-items-center border-0" style="background-color: #f8f9fa; border-radius: 12px !important;">
        <div class="row g-3 w-100 align-items-end">
          <div class="col-lg-3 col-md-6">
            <label class="form-label fw-bold text-secondary text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.5px;">
              Status Booking
            </label>
            <select id="booking_status" class="form-select border-0 shadow-xs rounded-3 bg-white px-3 py-2" style="font-size: 13px;">
              <option value="">Semua Status</option>
              <option value="pending">Pending</option>
              <option value="waiting_approval">Waiting Approval</option>
              <option value="approved">Approved</option>
              <option value="ongoing">Ongoing</option>
              <option value="completed">Completed</option>
              <option value="cancelled">Cancelled</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-6">
            <label class="form-label fw-bold text-secondary text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.5px;">
              Status Pembayaran
            </label>
            <select id="payment_status" class="form-select border-0 shadow-xs rounded-3 bg-white px-3 py-2" style="font-size: 13px;">
              <option value="">Semua Status</option>
              <option value="unpaid">Unpaid</option>
              <option value="waiting">Waiting Verification</option>
              <option value="paid">Paid</option>
              <option value="rejected">Rejected</option>
            </select>
          </div>
          <div class="col-lg-3 col-md-6">
            <label class="form-label fw-bold text-secondary text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.5px;">
              Dari Tanggal
            </label>
            <input type="date" id="date_from" class="form-control border-0 shadow-xs rounded-3 bg-white px-3 py-2" style="font-size: 13px;">
          </div>
          <div class="col-lg-3 col-md-6">
            <label class="form-label fw-bold text-secondary text-uppercase mb-1" style="font-size: 10px; letter-spacing: 0.5px;">
              Sampai Tanggal
            </label>
            <input type="date" id="date_to" class="form-control border-0 shadow-xs rounded-3 bg-white px-3 py-2" style="font-size: 13px;">
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table id="table" class="table align-middle mb-0 text-dark" style="font-size: 14px;">
          <thead style="background-color: #f8f9fa;">
            <tr>
              <th width="4%" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center px-3" style="font-size: 11px; letter-spacing: 0.5px;">#</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Kode Booking</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Studio</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Tanggal</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Jam Main</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Total Biaya</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Status Booking</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Status Payment</th>
              <th width="8%" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" style="font-size: 11px; letter-spacing: 0.5px;">Aksi</th>
            </tr>
          </thead>
          <tbody class="border-top-0">
          </tbody>
        </table>
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
        url: "<?= site_url('booking/getMyBooking') ?>",
        type: "POST",
        data: function(d) {
          d.booking_status = $('#booking_status').val();
          d.payment_status = $('#payment_status').val();
          d.date_from = $('#date_from').val();
          d.date_to = $('#date_to').val();
        }
      },
      columnDefs: [{
          targets: [0, 3, 4, 6, 7, 8],
          className: 'text-center'
        },
        {
          targets: [5],
          className: 'text-end'
        },
        {
          targets: [8],
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

    $('#booking_status,#payment_status,#date_from,#date_to').on('change', function() {
      table.ajax.reload();
    });

  });
</script>