<style>
    .btn-hover-effect {
        transition: all 0.2s ease-in-out;
        border: 1px solid transparent !important;
    }

    .btn-hover-effect:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08) !important;
    }

    .style-btn-action:hover {
        background-color: #212529 !important;
        color: #ffffff !important;
        border-color: #212529 !important;
    }

    .style-link {
        color: #6c757d !important;
        transition: color 0.15s ease;
    }

    .style-link:hover {
        color: #212529 !important;
    }

    .pulse-dot {
        width: 8px;
        height: 8px;
        background-color: #198754;
        border-radius: 50%;
        display: inline-block;
        animation: pulseAnimation 1.5s infinite;
    }

    @keyframes pulseAnimation {
        0% {
            transform: scale(0.8);
            opacity: 0.5;
        }

        50% {
            transform: scale(1.2);
            opacity: 1;
        }

        100% {
            transform: scale(0.8);
            opacity: 0.5;
        }
    }

    .style-dot-log {
        width: 6px;
        height: 6px;
        margin-top: 6px;
        background-color: #ced4da !important;
    }

    .table th,
    .table td {
        border-color: #f1f3f5 !important;
    }
</style>
<div class="content-wrapper" style="background-color: #f8f9fa; min-height: 100vh; font-size: 13px;">
    <section class="content-header py-4 px-4">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="flex-grow-1" style="min-width: 250px;">
                <span class="text-uppercase tracking-wider d-block mb-1" style="font-size: 10px; letter-spacing: 1.5px; color: #adb5bd; font-weight: 700;">RUANG KENDALI STAFF & MANAGEMENT</span>
                <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px; font-size: 1.6rem; color: #212529 !important;">Selamat Datang Kembali, <?= $user->full_name ?>!</h3>
                <p class="text-secondary small mb-0" style="font-size: 13px; color: #6c757d !important;">Monitor aktivitas studio dan kelola operasional harian Anda di sini.</p>
            </div>
            <div class="d-flex align-items-center gap-3 flex-shrink-0">
                <div class="shadow-sm d-flex align-items-center justify-content-center" style="width: 60px; height: 60px; border-radius: 50%; background-color: #ffffff; padding: 2px; border: 1px solid #dee2e6;">
                    <a href="<?= site_url('profile') ?>">
                        <img src="<?= base_url('uploads/profile/' . ($user->profile_picture ? $user->profile_picture : 'default.jpg')) ?>"
                            alt="<?= $user->full_name ?>"
                            style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section class="content px-4 pb-5">
        <!-- summary -->
        <div class="row g-3 mb-4">
            <div class="col-xl-3 col-md-6 col-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 btn-hover-effect">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-uppercase fw-bold text-secondary" style="font-size:10px;letter-spacing:.5px;">Payment Approval</span>
                                <i class="material-symbols-rounded text-secondary" style="font-size:20px;">payments</i>
                            </div>
                            <h2 class="fw-bold text-dark mb-1" style="font-size:2rem;"><?= number_format($summary['waiting_verification']) ?></h2>
                            <small class="text-muted" style="font-size:11px;">Waiting for verification</small>
                        </div>
                        <a href="<?= site_url('booking/paymentApproval') ?>" class="btn btn-sm btn-outline-dark rounded-3 fw-semibold mt-3" style="font-size:11px;">Review Now</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 btn-hover-effect">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-uppercase fw-bold text-secondary" style="font-size:10px;letter-spacing:.5px;">Today's Booking</span>
                                <i class="material-symbols-rounded text-secondary" style="font-size:20px;">event_note</i>
                            </div>
                            <h2 class="fw-bold text-dark mb-1" style="font-size:2rem;"><?= number_format($summary['today_booking']) ?></h2>
                            <small class="text-muted" style="font-size:11px;">Scheduled for today</small>
                        </div>
                        <a href="<?= site_url('booking/calendar') ?>" class="btn btn-sm btn-outline-dark rounded-3 fw-semibold mt-3" style="font-size:11px;">Open Calendar</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 btn-hover-effect">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-uppercase fw-bold text-secondary" style="font-size:10px;letter-spacing:.5px;">Ongoing Session</span>
                                <i class="material-symbols-rounded text-secondary" style="font-size:20px;">play_circle</i>
                            </div>
                            <h2 class="fw-bold text-dark mb-1" style="font-size:2rem;"><?= number_format($summary['ongoing_session']) ?></h2>
                            <small class="text-muted" style="font-size:11px;">Currently in progress</small>
                        </div>
                        <a href="<?= site_url('booking/calendar?filter=ongoing') ?>" class="btn btn-sm btn-outline-dark rounded-3 fw-semibold mt-3" style="font-size:11px;">Monitor</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 col-6">
                <div class="card border-0 shadow-sm rounded-4 h-100 btn-hover-effect">
                    <div class="card-body p-3 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="text-uppercase fw-bold text-secondary" style="font-size:10px;letter-spacing:.5px;">Booking List</span>
                                <i class="material-symbols-rounded text-secondary" style="font-size:20px;">assignment</i>
                            </div>
                            <h2 class="fw-bold text-dark mb-1" style="font-size:2rem;"><?= number_format($summary['active_booking']) ?></h2>
                            <small class="text-muted" style="font-size:11px;">Active booking records</small>
                        </div>
                        <a href="<?= site_url('booking/list') ?>" class="btn btn-sm btn-dark rounded-3 fw-semibold mt-3" style="font-size:11px;">Open</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <!-- need attention -->
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <i class="material-symbols-rounded text-dark fs-4">notification_important</i>
                            <h5 class="fw-bold mb-0 text-dark">Need Attention</h5>
                        </div>
                        <div style="max-height: 400px; overflow-y: auto;">
                            <?php if (empty($waiting_verification) && empty($need_start) && empty($need_complete)): ?>
                                <div class="text-center text-muted py-5">
                                    <i class="material-symbols-rounded fs-1 text-light d-block mb-2">check_circle</i>
                                    <span class="small text-secondary">Semua aman. Tidak ada item yang perlu perhatian.</span>
                                </div>
                            <?php endif; ?>
                            <?php foreach ($waiting_verification as $row): ?>
                                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                    <div>
                                        <div class="fw-bold text-dark mb-0" style="font-size: 13px;"><?= $row['booking_code'] ?></div>
                                        <div class="text-muted mb-1" style="font-size: 11px;"><?= $row['studio_name'] ?></div>
                                        <div class="text-muted d-flex align-items-center gap-1" style="font-size: 11px;">
                                            <span style="width: 6px; height: 6px; background-color: #dc3545; border-radius: 50%; display: inline-block;"></span>
                                            Waiting Payment Verification
                                        </div>
                                    </div>
                                    <a href="<?= site_url('booking/paymentApproval') ?>" class="btn btn-sm btn-outline-dark px-3 py-1 fw-semibold" style="font-size: 11px; border-radius: 6px;">Check</a>
                                </div>
                            <?php endforeach; ?>
                            <?php foreach ($need_start as $row): ?>
                                <div class="d-flex justify-content-between align-items-center border-bottom py-3">
                                    <div>
                                        <div class="fw-bold text-dark mb-0" style="font-size: 13px;"><?= $row['booking_code'] ?></div>
                                        <div class="text-muted mb-1" style="font-size: 11px;"><?= $row['studio_name'] ?> (<?= substr($row['start_time'], 0, 5) ?>)</div>
                                        <div class="text-muted d-flex align-items-center gap-1" style="font-size: 11px;">
                                            <span style="width: 6px; height: 6px; background-color: #ffc107; border-radius: 50%; display: inline-block;"></span>
                                            Sesi Harus Dimulai
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-dark px-3 py-1 fw-semibold btn-start" data-id="<?= $row['id_booking'] ?>" style="font-size:11px;border-radius:6px;">
                                        Start
                                    </button>
                                </div>
                            <?php endforeach; ?>
                            <?php foreach ($need_complete as $row): ?>
                                <?php $is_overdue = strtotime(date('H:i:s')) > strtotime($row['end_time']); ?>
                                <div class="d-flex justify-content-between align-items-center border rounded-3 py-3 px-3 mb-2 <?= $is_overdue ? 'border-danger bg-danger-subtle' : 'border-warning bg-warning-subtle' ?>">
                                    <div>
                                        <div class="fw-bold text-dark mb-0" style="font-size:13px;">
                                            <?= $row['booking_code'] ?>
                                        </div>
                                        <div class="text-muted mb-1" style="font-size:11px;">
                                            <?= $row['studio_name'] ?>
                                            (Jadwal Selesai:
                                            <b><?= substr($row['end_time'], 0, 5) ?></b>)
                                        </div>
                                        <?php if ($is_overdue): ?>
                                            <div class="text-danger d-flex align-items-center gap-1 fw-semibold" style="font-size:11px;">
                                                <span style="width:6px;height:6px;background:#dc3545;border-radius:50%;display:inline-block;"></span>
                                                Waktu Sesi Habis (Overdue)
                                            </div>
                                        <?php else: ?>
                                            <div class="text-warning d-flex align-items-center gap-1 fw-semibold" style="font-size:11px;">
                                                <span style="width:6px;height:6px;background:#ffc107;border-radius:50%;display:inline-block;"></span>
                                                Segera Selesaikan Sesi
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <button type="button"
                                        class="btn btn-sm <?= $is_overdue ? 'btn-danger' : 'btn-dark' ?> px-3 py-1 fw-semibold text-white btn-complete"
                                        data-id="<?= $row['id_booking'] ?>"
                                        style="font-size:11px;border-radius:6px;">
                                        Complete
                                    </button>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- today's schedulle -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5 class="fw-bold mb-0 text-dark">Today's Schedule</h5>
                            <a href="<?= site_url('booking/calendar') ?>" class="text-decoration-none small fw-semibold text-secondary style-link">View Calendar →</a>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="font-size: 13px;">
                                <thead>
                                    <tr class="text-secondary small" style="font-size: 11px; border-bottom: 1px solid #f2f2f2;">
                                        <th class="ps-0 pb-2 fw-semibold text-uppercase tracking-wider">Waktu Pelaksanaan</th>
                                        <th class="pb-2 fw-semibold text-uppercase tracking-wider">Studio</th>
                                        <th class="pe-0 pb-2 text-end fw-semibold text-uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (empty($today_schedule)): ?>
                                        <tr>
                                            <td colspan="3" class="text-center text-muted py-4">Tidak ada jadwal untuk hari ini.</td>
                                        </tr>
                                    <?php endif; ?>
                                    <?php foreach (array_slice($today_schedule, 0, 5) as $row): ?>
                                        <?php
                                        $status = $row['booking_status'];
                                        $badge_styles = [
                                            'pending'          => 'border border-warning text-warning',
                                            'waiting_approval' => 'border border-warning text-warning',
                                            'approved'         => 'bg-light text-dark border',
                                            'ongoing'          => 'bg-success text-white',
                                            'completed'        => 'bg-dark text-white',
                                            'cancelled'        => 'bg-light text-muted border text-decoration-line-through'
                                        ];
                                        $badge_class = isset($badge_styles[$status]) ? $badge_styles[$status] : 'bg-secondary text-white';
                                        $label = strtoupper(str_replace('_', ' ', $status));
                                        ?>
                                        <tr style="border-bottom: 1px solid #f8f9fa;">
                                            <td class="py-3 ps-0 fw-bold text-dark">
                                                <?= substr($row['start_time'], 0, 5) ?> - <?= substr($row['end_time'], 0, 5) ?>
                                            </td>
                                            <td class="py-3 text-secondary">
                                                <?= $row['studio_name'] ?>
                                            </td>
                                            <td class="py-3 text-end pe-0">
                                                <span class="badge px-2 py-1.5 rounded-2 <?= $badge_class ?>" style="font-size: 9px; font-weight: 700; letter-spacing: 0.5px;"><?= $label ?></span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <!-- status studio -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center gap-2 mb-3">
                            <i class="material-symbols-rounded text-secondary fs-5">layers</i>
                            <h6 class="fw-bold mb-0 text-dark" style="font-size: 0.95rem;">Studio Status</h6>
                        </div>
                        <div class="row g-2">
                            <?php foreach ($studio_status as $studio): ?>
                                <div class="col-6">
                                    <div class="p-2 rounded-3 h-100 border d-flex justify-content-between align-items-center" style="background-color: #fafafa; min-height: 50px;">
                                        <div class="fw-semibold text-dark" style="font-size: 12px;"><?= $studio['studio_name'] ?></div>

                                        <div>
                                            <?php if ($studio['status'] == 'ongoing'): ?>
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle d-inline-flex align-items-center gap-1 py-1 px-2" style="font-size: 9px; background: #e8f5e9;">
                                                    <span class="spinner-grow spinner-grow-sm text-danger" style="width: 6px; height: 6px;"></span> <?= $studio['label'] ?>
                                                </span>
                                            <?php elseif ($studio['status'] == 'next'): ?>
                                                <span class="badge bg-warning-subtle text-warning border border-warning-subtle d-inline-flex align-items-center gap-1 py-1 px-2" style="font-size: 9px; background: #fffde7; color:#f57c00 !important;">
                                                    <i class="material-symbols-rounded" style="font-size: 10px;">update</i> <?= $studio['label'] ?>
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success-subtle text-success border border-success-subtle d-inline-flex align-items-center gap-1 py-1 px-2" style="font-size: 9px;">
                                                    <span style="width:6px; height:6px; background:#94a3b8; border-radius:50%;"></span> Available
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- recent activity -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4 text-dark">Recent Activities</h5>
                        <div style="max-height: 250px; overflow-y: auto;">
                            <?php foreach ($activities as $activity): ?>
                                <div class="d-flex align-items-start gap-3 py-2 border-bottom">
                                    <div class="bg-dark rounded-circle flex-shrink-0 style-dot-log"></div>
                                    <div class="w-90">
                                        <div class="d-flex justify-content-between align-items-baseline">
                                            <span class="fw-bold text-dark" style="font-size: 12px;"><?= $activity['booking_code'] ?></span>
                                            <small class="text-muted" style="font-size: 10px;"><?= date('d M H:i', strtotime($activity['changed_at'])) ?></small>
                                        </div>
                                        <div class="text-muted mt-0.5" style="font-size: 11px;">
                                            Status updated to <span class="text-dark fw-medium"><?= ucfirst(str_replace('_', ' ', $activity['status_to'])) ?></span>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</div>

<script>
    $(document).on('click', '.btn-start, #btn-start-session', function() {
        let id = $(this).data('id') || $('#hidden_id_booking').val();
        Swal.fire({
            title: 'Mulai Sesi Studio?',
            text: 'Pastikan customer telah hadir dan ruangan siap digunakan untuk memulai sesi.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Ya, Mulai',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#212529'
        }).then((result) => {
            if (!result.isConfirmed) return;
            $.ajax({
                url: "<?= site_url('booking/startSession') ?>",
                type: "POST",
                data: {
                    id_booking: id
                },
                dataType: "json",
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
    });

    $(document).on('click', '.btn-complete, #btn-complete-session', function() {
        let id = $(this).data('id') || $('#hidden_id_booking').val();
        Swal.fire({
            title: 'Selesaikan Sesi?',
            text: 'Konfirmasi jika penggunaan ruangan telah berakhir. Harap periksa dan pastikan kembali kelengkapan inventaris studio sebelum menyelesaikan sesi ini.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Selesaikan',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#212529'
        }).then((result) => {
            if (!result.isConfirmed) return;
            $.ajax({
                url: "<?= site_url('booking/completeSession') ?>",
                type: "POST",
                data: {
                    id_booking: id
                },
                dataType: "json",
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
    });
</script>