<style>
  .tracking-wider {
    letter-spacing: 0.05em;
  }
</style>
<div class="container-fluid py-3" style="background-color: #f8f9fa; min-height: 100vh;">
  <div class="row g-2 mb-3">
    <div class="col-md-4">
      <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-body p-3 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-secondary fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Waiting Verification</div>
            <h4 class="fw-bold text-warning mb-0 mt-1"><?= $summary['waiting_verification'] ?? 0 ?></h4>
          </div>
          <div class="rounded-2 d-flex align-items-center justify-content-center text-warning" style="width: 40px; height: 40px; background-color: #fffde7;"><i class="material-symbols-outlined" style="font-size: 22px;">pending_actions</i></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-body p-3 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-secondary fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Approved Today</div>
            <h4 class="fw-bold text-success mb-0 mt-1"><?= $summary['approved_today'] ?? 0 ?></h4>
          </div>
          <div class="rounded-2 d-flex align-items-center justify-content-center text-success" style="width: 40px; height: 40px; background-color: #e8f5e9;"><i class="material-symbols-outlined" style="font-size: 22px;">task_alt</i></div>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card border-0 rounded-3 shadow-sm">
        <div class="card-body p-3 d-flex align-items-center justify-content-between">
          <div>
            <div class="text-secondary fw-bold text-uppercase" style="font-size: 11px; letter-spacing: 0.5px;">Rejected Today</div>
            <h4 class="fw-bold text-danger mb-0 mt-1"><?= $summary['rejected_today'] ?? 0 ?></h4>
          </div>
          <div class="rounded-2 d-flex align-items-center justify-content-center text-danger" style="width: 40px; height: 40px; background-color: #ffebee;"><i class="material-symbols-outlined" style="font-size: 22px;">cancel</i></div>
        </div>
      </div>
    </div>
  </div>
  <div class="card border-0 rounded-3 shadow-sm">
    <div class="card-body p-3">
      <div class="row g-2 mb-3 align-items-end">
        <div class="col-md-3">
          <label class="form-label text-secondary fw-bold text-uppercase mb-1" style="font-size: 10px;">Studio</label>
          <select id="studio" class="form-select px-2">
            <option value="">Semua Studio</option>
            <?php foreach ($studios as $studio): ?>
              <option value="<?= $studio['id_studio'] ?>"><?= $studio['studio_name'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-5">
          <label class="form-label text-secondary fw-bold text-uppercase mb-1" style="font-size: 10px;">Booking Code</label>
          <input type="text" id="booking_code" class="border form-control px-2" placeholder="Cari kode...">
        </div>
        <div class="col-md-2">
          <label class="form-label text-secondary fw-bold text-uppercase mb-1" style="font-size: 10px;">Dari</label>
          <input type="date" id="date_from" class="border form-control px-2">
        </div>
        <div class="col-md-2">
          <label class="form-label text-secondary fw-bold text-uppercase mb-1" style="font-size: 10px;">Sampai</label>
          <input type="date" id="date_to" class="border form-control px-2">
        </div>
      </div>

      <div class="table-responsive">
        <table id="table" class="table table-sm table-hover align-middle mb-0 text-sm">
          <thead class="table-light text-secondary text-uppercase text-xs">
            <tr>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center" width="4%" class="ps-2">#</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Booking Code</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Customer</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Studio</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Tanggal Booking</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Total</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Upload</th>
              <th class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Status</th>
              <th width="8%" class="text-uppercase text-secondary text-sm font-weight-bolder opacity-7 text-center">Action</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="modalReview" tabindex="-1">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content border-0 shadow-xl rounded-4 overflow-hidden">
      <form id="form" enctype="multipart/form-data">
        <div class="modal-header border-0 pb-0 px-4 pt-4 bg-white">
          <div class="d-flex align-items-center">
            <div class="bg-dark text-white rounded-3 d-flex align-items-center justify-content-center me-3 shadow-sm"
              style="width:46px; height:46px;">
              <i class="material-symbols-rounded" style="font-size: 24px;">rate_review</i>
            </div>
            <div>
              <h5 class="modal-title fw-bold text-dark mb-0" id="modalReviewLabel">Verifikasi Pembayaran Booking</h5>
              <small class="text-muted">Kelola detail properti, harga, dan operasional studio</small>
            </div>
          </div>
          <button type="button" class="btn-close btn-dark shadow-none" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-4">
          <input type="hidden" id="id_booking">
          <div class="row g-3">
            <div class="col-md-6">
              <div class="border rounded-3 p-3 h-100 bg-white">
                <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2 text-md" style="letter-spacing: 0.3px;">
                  <i class="material-symbols-outlined text-secondary">info</i>
                  Detail Reservasi
                </h6>
                <table class="table table-sm table-borderless mb-0 text-sm">
                  <tr>
                    <td width="40%" class="text-secondary py-1.5">Kode Booking</td>
                    <td id="booking_code_detail" class="fw-bold text-dark py-1.5"></td>
                  </tr>
                  <tr>
                    <td class="text-secondary py-1.5">Nama Pelanggan</td>
                    <td id="customer_detail" class="fw-semibold text-dark py-1.5"></td>
                  </tr>
                  <tr>
                    <td class="text-secondary py-1.5">Studio</td>
                    <td id="studio_detail" class="text-dark py-1.5"></td>
                  </tr>
                  <tr>
                    <td class="text-secondary py-1.5">Jadwal Sewa</td>
                    <td id="schedule_detail" class="text-dark py-1.5"></td>
                  </tr>
                  <tr class="border-top">
                    <td class="text-secondary pt-2.5 fw-bold">Total Tagihan</td>
                    <td id="total_detail" class="text-primary fw-bold pt-2.5 fs-6"></td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="col-md-6">
              <div class="border rounded-3 p-3 h-100 bg-white d-flex flex-column justify-content-between">
                <div>
                  <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2 text-md" style="letter-spacing: 0.3px;">
                    <i class="material-symbols-outlined text-secondary">receipt_long</i>
                    Bukti Transfer Pelanggan
                  </h6>
                  <div class="text-center bg-light rounded-2 p-2 mb-2 d-flex align-items-center justify-content-center" style="min-height: 200px;">
                    <img id="proof_preview" class="img-fluid rounded border shadow-xs" style="max-height: 220px; object-fit: contain;">
                  </div>
                </div>
                <div class="text-center">
                  <a id="btn-view-file" target="_blank" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center gap-1">
                    <i class="material-symbols-outlined">visibility</i> Lihat Bukti Pembayaran
                  </a>
                </div>
              </div>
            </div>
          </div>
          <div class="mt-3">
            <label class="form-label fw-bold text-secondary text-uppercase text-sm" style="letter-spacing: 0.5px;">
              Catatan (Opsional / Alasan Tolak)
            </label>
            <textarea id="note" class="form-control border px-2" rows="2" placeholder="Tulis catatan jika bukti pembayaran tidak sesuai atau bermasalah..."></textarea>
          </div>
        </div>
        <div class="modal-footer py-2">
          <button type="button" class="btn btn-outline-danger px-3 d-flex align-items-center gap-1" id="btn-reject">
            <i class="material-symbols-outlined">block</i> Tolak Pembayaran
          </button>
          <button type="button" class="btn btn-success px-4 d-flex align-items-center gap-1" id="btn-approve">
            <i class="material-symbols-outlined">check_circle</i> Approve Pembayaran
          </button>
        </div>
      </form>
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
        url: "<?= site_url('booking/getPaymentApproval') ?>",
        type: "POST",
        data: function(d) {
          d.studio = $('#studio').val();
          d.booking_code = $('#booking_code').val();
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

    $('#studio, #booking_code, #date_from, #date_to').on('change', function() {
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
              location.reload();
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