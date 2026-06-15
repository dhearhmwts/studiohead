<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 rounded-4 shadow-sm mb-4" style="border-radius: 16px; background-color: #ffffff;">
            <div class="card-body p-4">
                <!-- header -->
                <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom opacity-90">
                    <div>
                        <span class="text-secondary text-uppercase tracking-wider fw-bold d-block mb-1" style="font-size: 11px; letter-spacing: 1px;">Preview Booking</span>
                        <h3 class="fw-bold text-dark mb-0" style="letter-spacing: -0.5px;"><?= $booking['booking_code'] ?></h3>
                    </div>
                    <?php
                    $statusClass = [
                        'pending'          => 'bg-warning text-dark',
                        'waiting_approval' => 'bg-warning text-dark',
                        'approved'         => 'bg-success text-white',
                        'ongoing'          => 'bg-primary text-white',
                        'completed'        => 'bg-dark text-white',
                        'cancelled'        => 'bg-danger text-white'
                    ];
                    ?>
                    <span class="badge px-3 py-2 rounded-pill fw-bold text-uppercase shadow-xs <?= $statusClass[$booking['booking_status']] ?? 'bg-secondary text-white' ?>" style="font-size: 11px; letter-spacing: 0.5px;">
                        <?= str_replace('_', ' ', $booking['booking_status']) ?>
                    </span>
                </div>
                <!-- detail -->
                <div class="row g-4 mb-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-3 p-2">
                            <div class="rounded-3 d-flex align-items-center justify-content-center shadow-xs" style="width: 44px; height: 44px; background-color: #f0e6ff; color: #6200ee;">
                                <i class="material-symbols-outlined" style="font-size: 24px;">corporate_fare</i>
                            </div>
                            <div>
                                <small class="text-secondary d-block mb-0" style="font-size: 12px;">Studio</small>
                                <span class="fw-bold text-dark fs-6"><?= $booking['studio_name'] ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-3 p-2">
                            <div class="rounded-3 d-flex align-items-center justify-content-center shadow-xs" style="width: 44px; height: 44px; background-color: #e8f5e9; color: #1b5e20;">
                                <i class="material-symbols-outlined" style="font-size: 24px;">calendar_month</i>
                            </div>
                            <div>
                                <small class="text-secondary d-block mb-0" style="font-size: 12px;">Tanggal Booking</small>
                                <span class="fw-bold text-dark fs-6"><?= date('d M Y', strtotime($booking['booking_date'])) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-3 p-2">
                            <div class="rounded-3 d-flex align-items-center justify-content-center shadow-xs" style="width: 44px; height: 44px; background-color: #fffde7; color: #f57f17;">
                                <i class="material-symbols-outlined" style="font-size: 24px;">schedule</i>
                            </div>
                            <div>
                                <small class="text-secondary d-block mb-0" style="font-size: 12px;">Jam Operasional</small>
                                <span class="fw-bold text-dark fs-6"><?= substr($booking['start_time'], 0, 5) ?> - <?= substr($booking['end_time'], 0, 5) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center gap-3 p-2">
                            <div class="rounded-3 d-flex align-items-center justify-content-center shadow-xs" style="width: 44px; height: 44px; background-color: #e3f2fd; color: #0d47a1;">
                                <i class="material-symbols-outlined" style="font-size: 24px;">hourglass_empty</i>
                            </div>
                            <div>
                                <small class="text-secondary d-block mb-0" style="font-size: 12px;">Durasi</small>
                                <span class="fw-bold text-dark fs-6"><?= $booking['duration_hour'] ?> Jam</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- package -->
                <?php if (!empty($booking['package_name'])): ?>
                    <div class="pt-4 border-top">
                        <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 13px; letter-spacing: 0.3px;">
                            <i class="material-symbols-outlined text-secondary" style="font-size: 18px;">package</i>
                            Paket Pilihan
                        </h6>
                        <div class="p-3 border-0 rounded-3 d-flex align-items-center gap-3 shadow-xs" style="background-color: #f8f9fa; border-radius: 12px;">
                            <?php if (!empty($booking['thumbnail'])): ?>
                                <img src="<?= base_url('uploads/packages/' . $booking['thumbnail']) ?>" alt="<?= $booking['package_name'] ?>" class="rounded-3" style="width: 64px; height: 64px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-secondary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center text-muted fw-bold" style="width: 64px; height: 64px; font-size: 11px;">
                                    No Img
                                </div>
                            <?php endif; ?>
                            <div>
                                <div class="fw-bold text-dark" style="font-size: 14px;"><?= $booking['package_name'] ?></div>
                                <?php if (!empty($booking['package_description'])): ?>
                                    <p class="text-muted small mb-0 mt-1" style="font-size: 12px; line-height: 1.4;"><?= $booking['package_description'] ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- addon -->
                <div class="pt-4 mt-4 border-top">
                    <h6 class="fw-bold text-dark mb-3 d-flex align-items-center gap-2" style="font-size: 13px; letter-spacing: 0.3px;">
                        <i class="material-symbols-outlined text-secondary" style="font-size: 18px;">build</i>
                        Fasilitas Tambahan (Add-On)
                    </h6>
                    <?php if (empty($addons)): ?>
                        <p class="text-muted small mb-0" style="font-style: italic;">Tidak ada fasilitas tambahan yang dipilih.</p>
                    <?php else: ?>
                        <div class="d-flex flex-wrap gap-2">
                            <?php foreach ($addons as $addon): ?>
                                <span class="badge d-inline-flex align-items-center bg-light border text-dark fw-medium p-2 rounded-3 shadow-xs" style="font-size: 12px; border-radius: 8px !important;">
                                    <span class="me-2 text-secondary"><?= $addon['addon_name'] ?></span>
                                    <span class="badge bg-secondary text-white rounded-2 px-2 py-0.5" style="font-size: 10px;">
                                        x<?= $addon['qty'] ?>
                                    </span>
                                </span>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <!-- tracking -->
        <div class="card border-0 rounded-4 shadow-sm mb-4" style="border-radius: 16px; background-color: #ffffff;">
            <div class="card-body p-4">
                <h5 class="fw-bold text-dark mb-4 d-flex align-items-center gap-2" style="font-size: 16px; letter-spacing: -0.3px;">
                    <i class="material-symbols-outlined text-secondary" style="font-size: 20px;">history</i>
                    Timeline Booking
                </h5>
                <div class="position-relative ps-1">
                    <?php
                    $total_logs = count($logs);
                    foreach ($logs as $index => $log):
                        $is_last = ($index === $total_logs - 1);
                        $status = $log['status_to'];
                        $dot_color = 'bg-light';
                        if (in_array($status, ['pending', 'waiting_approval'])) $dot_color = 'bg-warning';
                        elseif (in_array($status, ['approved', 'completed'])) $dot_color = 'bg-success';
                        elseif ($status === 'ongoing') $dot_color = 'bg-info';
                        elseif ($status === 'cancelled') $dot_color = 'bg-danger';
                    ?>
                        <div class="d-flex position-relative <?= !$is_last ? 'mb-3 pb-2' : '' ?>">
                            <div class="me-3 d-flex flex-column align-items-center position-relative">
                                <div class="rounded-circle <?= $dot_color ?> shadow-xs" style="width: 12px; height: 12px; margin-top: 5px; z-index: 2;"></div>

                                <?php if (!$is_last): ?>
                                    <div class="bg-light position-absolute" style="width: 2px; top: 17px; bottom: -15px; left: 50%; transform: translateX(-50%); z-index: 1; opacity: 0.7;"></div>
                                <?php endif; ?>
                            </div>
                            <div class="d-flex flex-column justify-content-center">
                                <div class="fw-bold text-dark mb-0" style="font-size: 14px; line-height: 1.3;">
                                    <?= ucwords(str_replace('_', ' ', $log['status_to'])) ?>
                                </div>
                                <div class="text-muted mt-0.5" style="font-size: 11px;">
                                    <?= date('d M Y, H:i', strtotime($log['changed_at'])) ?> WIB
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- summary pembayaran -->
        <div class="card border-0 rounded-4 shadow-lg sticky-top mb-4" style="top:24px; z-index: 10; border-radius: 16px;">
            <div class="card-body p-4">
                <h5 class="fw-bold border-bottom pb-3 mb-3 text-dark d-flex align-items-center" style="letter-spacing: 0.5px;">
                    <span class="me-2">🧾</span> Ringkasan Pembayaran
                </h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary small fw-medium">Subtotal</span>
                    <span class="fw-semibold text-dark">
                        Rp<?= number_format($booking['subtotal'], 0, ',', '.') ?>
                    </span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-secondary small fw-medium">Diskon / Potongan</span>
                    <span class="text-danger fw-semibold">
                        -Rp<?= number_format($booking['discount'], 0, ',', '.') ?>
                    </span>
                </div>
                <div class="p-3 rounded-3 d-flex justify-content-between align-items-center mb-4" style="background-color: #f4f6fa; border-radius: 12px;">
                    <span class="fw-bold text-dark small text-uppercase tracking-wider">Total Tagihan</span>
                    <span class="fw-extrabold fs-4 text-primary" style="font-weight: 800; color: #6200ee !important;">
                        Rp<?= number_format($booking['total_price'], 0, ',', '.') ?>
                    </span>
                </div>
                <hr class="text-muted opacity-25 my-3">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <small class="text-secondary fw-bold text-uppercase tracking-wide" style="font-size: 11px; letter-spacing: 0.5px;">
                        Status Pembayaran
                    </small>
                    <?php
                    $paymentClass = [
                        'unpaid'   => 'bg-warning text-dark',
                        'waiting'  => 'bg-info text-white',
                        'paid'     => 'bg-success text-white',
                        'rejected' => 'bg-danger text-white'
                    ];
                    ?>
                    <span class="badge px-3 py-2 rounded-pill shadow-sm fw-bold text-uppercase <?= $paymentClass[$booking['payment_status']] ?? 'bg-secondary text-white' ?>" style="font-size: 11px; letter-spacing: 1px;">
                        <?= str_replace('_', ' ', $booking['payment_status']) ?>
                    </span>
                </div>
                <?php if ($booking['payment_status'] == 'unpaid'): ?>
                    <div class="rounded-3 p-3 mb-3 border-0 shadow-sm" style="background: linear-gradient(145deg, #ffffff, #f1f3f6); border-radius: 12px;">
                        <small class="text-secondary d-block mb-2 fw-bold text-uppercase" style="font-size: 10px; letter-spacing: 0.5px;">Rekening Tujuan Transfer</small>

                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <div class="fw-bold text-dark mb-1" style="font-size: 14px;">Bank XYZ</div>
                                <div class="text-primary fs-4 fw-bold mb-1 tracking-wide" style="color: #6200ee !important; font-family: 'Courier New', Courier, monospace;">
                                    123-4567-890
                                </div>
                                <small class="text-muted d-block" style="font-size: 12px;">a.n. PT StudioHead Indonesia</small>
                            </div>
                        </div>
                    </div>
                    <div class="alert border-0 rounded-3 small mb-0 p-3 shadow-sm" style="background-color: #fffde7; color: #f57f17; border-radius: 12px;">
                        <div class="d-flex gap-2">
                            <span>💡</span>
                            <div>
                                <strong>Instruksi:</strong> Silakan lakukan transfer sesuai nominal <strong>Total Tagihan</strong> ke rekening di atas, lalu unggah foto struk/bukti transfer Anda pada form yang tersedia.
                            </div>
                        </div>
                    </div>
                <?php elseif ($booking['payment_status'] == 'waiting'): ?>
                    <div class="alert border-0 rounded-3 small mb-0 text-center py-4 shadow-sm" style="background-color: #e3f2fd; color: #0d47a1; border-radius: 12px;">
                        <div class="fs-2 mb-2">⏳</div>
                        <h6 class="fw-bold mb-1" style="color: #0d47a1;">Menunggu Verifikasi</h6>
                        <p class="mb-0 text-secondary small">Bukti transfer sudah kami terima. Mohon tunggu, staff kami sedang mencocokkan data mutasi bank Anda.</p>
                    </div>
                <?php elseif ($booking['payment_status'] == 'paid'): ?>
                    <div class="alert border-0 rounded-3 small mb-0 text-center py-4 shadow-sm" style="background-color: #e8f5e9; color: #1b5e20; border-radius: 12px;">
                        <div class="fs-2 mb-2">✅</div>
                        <h6 class="fw-bold mb-1" style="color: #1b5e20;">Pembayaran Lunas</h6>
                        <p class="mb-0 text-secondary small">Transaksi Anda berhasil diverifikasi. Invoice resmi telah diterbitkan. Sampai jumpa di studio!</p>
                    </div>
                <?php elseif ($booking['payment_status'] == 'rejected'): ?>
                    <div class="alert border-0 rounded-3 small mb-0 py-3 shadow-sm" style="background-color: #ffebee; color: #b71c1c; border-radius: 12px;">
                        <div class="d-flex gap-2 align-items-start">
                            <span class="fs-5">⚠️</span>
                            <div>
                                <h6 class="fw-bold mb-1" style="color: #b71c1c;">Pembayaran Ditolak</h6>
                                <p class="mb-0 text-secondary small">Bukti transfer tidak valid atau dana tidak masuk. Silakan periksa kembali atau hubungi CS kami.</p>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <!-- bukti pembayaran -->
        <?php if ($booking['payment_status'] == 'unpaid'): ?>
            <div class="card border-0 rounded-4 shadow-sm border-start border-warning border-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <h5 class="fw-bold mb-0 text-dark">Upload Bukti Pembayaran Resmi</h5>
                    </div>
                    <p class="text-muted small mb-4">Kirimkan salinan atau foto transfer bank Anda di bawah ini agar staff admin kami dapat segera melakukan verifikasi data pesanan Anda.</p>
                    <form id="form-payment" method="POST" enctype="multipart/form-data" action="<?= site_url('booking/upload_payment/' . $booking['id_booking']) ?>">
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary small">Pilih File Bukti Transfer (Format: JPG, PNG, PDF)</label>
                            <div class="input-group">
                                <input type="file" name="transfer_proof" class="form-control form-control-lg rounded-3" accept=".jpg,.jpeg,.png,.pdf" required>
                            </div>
                            <div class="form-text text-xs text-muted mt-1">*Pastikan resolusi gambar jelas dan nominal transfer terlihat utuh.</div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg w-100 rounded-3 shadow-sm fw-semibold">
                            Kirim ke Admin & Verifikasi Sekarang
                        </button>
                    </form>
                </div>
            </div>
        <?php elseif ($booking['payment_status'] == 'rejected'): ?>
            <div class="card border-0 rounded-4 shadow-sm border-start border-danger border-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start flex-wrap g-3 mb-4">
                        <h5 class="fw-bold mb-1 text-danger">⚠️ Pembayaran Ditolak / Tidak Valid</h5>
                        <p class="text-muted small mb-2">Maaf, bukti pembayaran yang Anda kirimkan sebelumnya ditolak oleh admin.</p>
                        <?php if (!empty($booking['note'])): ?>
                            <div class="bg-light text-dark rounded-3 p-3 small border mb-0">
                                <strong>Alasan Penolakan:</strong> <?= $booking['note'] ?>
                            </div>
                        <?php else: ?>
                            <div class="bg-light text-dark rounded-3 p-3 small border mb-0">
                                <strong>Catatan:</strong> Mohon pastikan nominal transfer sesuai, gambar tidak buram, dan ditransfer ke rekening resmi kami.
                            </div>
                        <?php endif; ?>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-danger rounded-3 fw-semibold px-3" data-bs-toggle="modal" data-bs-target="#modalPreviewPembayaran">
                        👁️ Lihat Bukti Lama
                    </button>
                </div>
            </div>
        <?php else: ?>
            <div class="card border-0 rounded-4 shadow-sm border-start border-info border-4 mb-4">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center flex-wrap g-3 mb-4">
                        <h5 class="fw-bold mb-1 text-dark">Bukti Pembayaran Terunggah</h5>
                        <p class="text-muted small mb-0">Anda telah mengirimkan bukti transfer untuk booking ini.</p>
                    </div>
                    <button type="button" class="btn btn-outline-dark rounded-3 fw-semibold px-4" data-bs-toggle="modal" data-bs-target="#modalPreviewPembayaran">
                        👁️ Lihat Bukti Pembayaran
                    </button>
                </div>
            </div>
        <?php endif; ?>

    </div>

</div>

<div class="modal fade" id="modalPreviewPembayaran" tabindex="-1" aria-labelledby="modalPreviewLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 rounded-4 shadow-lg">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold text-dark" id="modalPreviewLabel">Pratinjau Bukti Transfer</h5>
                <button type="button" class="btn-close btn-dark" data-bs-close="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <?php
                $file_extension = pathinfo($booking['transfer_proof'], PATHINFO_EXTENSION);
                $file_url = base_url('uploads/payments/' . $booking['transfer_proof']);
                ?>
                <?php if (empty($booking['transfer_proof'])): ?>
                    <div class="alert mb-0">File bukti pembayaran tidak ditemukan di server.</div>
                <?php elseif (in_array(strtolower($file_extension), ['jpg', 'jpeg', 'png'])): ?>
                    <img src="<?= $file_url ?>" class="img-fluid rounded-3 shadow-sm max-h-500" alt="Bukti Transfer" style="max-height: 500px; object-fit: contain; width: 100%;">
                <?php elseif (strtolower($file_extension) === 'pdf'): ?>
                    <div class="ratio ratio-4x3 rounded-3 overflow-hidden shadow-sm">
                        <embed src="<?= $file_url ?>" type="application/pdf" width="100%" height="100%">
                    </div>
                    <div class="mt-3">
                        <a href="<?= $file_url ?>" target="_blank" class="btn btn-sm btn-primary">Buka PDF di Tab Baru</a>
                    </div>
                <?php else: ?>
                    <div class="p-4 bg-light rounded-3">
                        <p class="mb-3">Format file tidak mendukung pratinjau langsung.</p>
                        <a href="<?= $file_url ?>" target="_blank" class="btn btn-dark rounded-3">Unduh / Buka Dokumen</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary rounded-3" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#form-payment').submit(function(e) {
            e.preventDefault();
            const $form = $(this);
            const $submitBtn = $form.find('button[type="submit"]');
            let formData = new FormData(this);
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                beforeSend: function() {
                    $submitBtn.prop('disabled', true).text('Memproses...');
                    Swal.fire({
                        title: 'Sedang Upload Data',
                        text: 'Mohon tunggu, bukti pembayaran sedang diproses...',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(res) {
                    if (res.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil Terkirim!',
                            text: res.message || 'Bukti pembayaran telah kami terima. Silahkan tunggu proses verifikasi oleh Staff kami',
                            confirmButtonText: 'Tutup'
                        }).then(() => {
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal Upload Data',
                            text: res.message || 'Terjadi kesalahan pada validasi data.'
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi gangguan pada server. Silakan coba beberapa saat lagi.'
                    });
                },
                complete: function() {
                    $submitBtn.prop('disabled', false).text('Kirim Bukti Pembayaran');
                }
            });
        });
    });
</script>