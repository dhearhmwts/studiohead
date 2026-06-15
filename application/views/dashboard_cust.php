<div class="content-wrapper" style="background-color: #f8f9fa; min-height: 100vh;">
    <section class="content-header py-4 px-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="flex-grow-1" style="min-width: 250px;">
                <span class="text-secondary fw-bold text-uppercase tracking-wider d-block mb-1" style="font-size: 11px; letter-spacing: 1px; color: #6c757d !important;">Ruang Kendali Pelanggan</span>
                <h3 class="fw-bold text-dark mb-1" style="letter-spacing: -0.5px; margin: 0; color: #212529 !important;">Selamat Datang Kembali, <?= $membership->full_name ?>! 👋</h3>
                <p class="text-secondary small mb-0" style="color: #6c757d !important;">Pantau jadwal aktif, kupon keanggotaan, dan kelola aktivitas transaksi Anda di sini.</p>
            </div>
            <div class="flex-shrink-0">
                <div class="shadow-sm d-flex align-items-center justify-content-center" style="width: 84px; height: 84px; border-radius: 50%; background-color: #ffffff; padding: 3px;">
                    <img src="<?= base_url('uploads/profile/' . ($membership->profile_picture ? $membership->profile_picture : 'default.jpg')) ?>"
                        alt="<?= $membership->full_name ?>"
                        style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%; display: block;">
                </div>
            </div>

        </div>
    </section>
    <section class="content px-3">
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #ffffff;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-secondary fw-bold text-uppercase tracking-wider mb-1" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">Booking Aktif</div>
                            <h2 class="fw-extrabold text-dark mb-0" style="font-weight: 800; color: #212529 !important;"><?= $summary->active_booking ?? 0 ?></h2>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #f1f3f5;">
                            <i class="material-symbols-outlined" style="font-size: 24px; color: #343a40;">calendar_today</i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #ffffff;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-secondary fw-bold text-uppercase tracking-wider mb-1" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">Booking Selesai</div>
                            <h2 class="fw-extrabold mb-0" style="font-weight: 800; color: #2b4c3f !important;"><?= $summary->completed_booking ?? 0 ?></h2>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #eef5f2;">
                            <i class="material-symbols-outlined" style="font-size: 24px; color: #2b4c3f;">check_circle</i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #ffffff;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-secondary fw-bold text-uppercase tracking-wider mb-1" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">Total Pengeluaran</div>
                            <h3 class="fw-bold text-dark mb-0" style="font-size: 19px; font-weight: 700; color: #212529 !important;">Rp<?= number_format($summary->total_spending ?? 0, 0, ',', '.') ?></h3>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #f8f9fa; border: 1px solid #e9ecef;">
                            <i class="material-symbols-outlined" style="font-size: 24px; color: #212529;">payments</i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #ffffff;">
                    <div class="card-body p-4 d-flex align-items-center justify-content-between">
                        <div>
                            <div class="text-secondary fw-bold text-uppercase tracking-wider mb-1" style="font-size: 11px; letter-spacing: 0.5px; color: #6c757d !important;">Tingkat Member</div>
                            <h2 class="fw-extrabold mb-0" style="font-weight: 800; color: #8a6d3b !important; font-size: 22px;"><?= $membership->tier_name ?? '-' ?></h2>
                        </div>
                        <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; background-color: #fcf8e3; border: 1px solid #faebcc;">
                            <i class="material-symbols-outlined" style="font-size: 24px; color: #8a6d3b;">workspace_premium</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4 mb-4">
            <!-- booking active -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; background: #ffffff;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <i class="material-symbols-outlined text-primary" style="color: #6200ee;">schedule</i>
                            <h5 class="fw-bold text-dark mb-0" style="font-size: 16px;">Jadwal Booking Aktif</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="font-size: 14px;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="text-secondary border-0 py-3 px-3" style="font-size: 11px; font-weight: 700; text-uppercase: tracking-wider;">Kode</th>
                                        <th class="text-secondary border-0 py-3" style="font-size: 11px; font-weight: 700; text-uppercase: tracking-wider;">Studio</th>
                                        <th class="text-secondary border-0 py-3" style="font-size: 11px; font-weight: 700; text-uppercase: tracking-wider;">Waktu Pelaksanaan</th>
                                        <th class="text-secondary border-0 py-3" style="font-size: 11px; font-weight: 700; text-uppercase: tracking-wider;">Status</th>
                                        <th class="text-secondary border-0 py-3 text-center" style="font-size: 11px; font-weight: 700; text-uppercase: tracking-wider;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($active_bookings)): ?>
                                        <?php foreach ($active_bookings as $row): ?>
                                            <tr>
                                                <td class="px-3 border-bottom py-3 fw-bold text-dark"><?= $row->booking_code ?></td>
                                                <td class="border-bottom text-dark fw-medium"><?= $row->studio_name ?></td>
                                                <td class="border-bottom text-secondary small">
                                                    <strong><?= date('d M Y', strtotime($row->booking_date)) ?></strong><br>
                                                    <?= substr($row->start_time, 0, 5) ?> - <?= substr($row->end_time, 0, 5) ?> WIB
                                                </td>
                                                <td class="border-bottom">
                                                    <?php
                                                    $statusClass = 'bg-warning text-dark';
                                                    if (strtolower($row->booking_status) === 'approved') $statusClass = 'bg-success text-white';
                                                    elseif (strtolower($row->booking_status) === 'ongoing') $statusClass = 'bg-primary text-white';
                                                    ?>
                                                    <span class="badge px-2.5 py-1 rounded fw-bold text-uppercase <?= $statusClass ?>" style="font-size: 10px;">
                                                        <?= $row->booking_status ?>
                                                    </span>
                                                </td>
                                                <td class="border-bottom text-center">
                                                    <a href="<?= base_url('booking/detail/' . $row->id_booking) ?>" class="btn btn-outline-dark btn-sm rounded-3 px-3" style="font-size: 12px; border-radius: 8px !important;">
                                                        Detail
                                                    </a>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted small">
                                                <i class="material-symbols-outlined d-block fs-2 mb-1 text-secondary opacity-50">event_busy</i>
                                                Tidak ada jadwal booking aktif saat ini.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (!empty($active_bookings)): ?>
                            <div class="mt-3 pt-2 text-end">
                                <a href="<?= base_url('booking/mybooking') ?>" class="small fw-semibold text-decoration-none text-primary" style="color: #6200ee !important;">
                                    Lihat semua riwayat booking →
                                </a>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
            <!-- info membership -->
            <?php
            $tier = strtolower(trim($membership->tier_name ?? 'regular'));
            $bg_color = 'linear-gradient(135deg,#2c3e50,#000000)';
            $accent_color = '#ffffff';
            $tier_icon = 'workspace_premium';
            if ($tier == 'bronze') {
                $bg_color = 'linear-gradient(135deg,#8C6239,#5D4037)';
                $accent_color = '#D7A86E';
                $tier_icon = 'military_tech';
            } else if ($tier == 'silver') {
                $bg_color = 'linear-gradient(135deg,#6D6D6D,#2F2F2F)';
                $accent_color = '#E5E5E5';
                $tier_icon = 'workspace_premium';
            } else if ($tier == 'gold') {
                $bg_color = 'linear-gradient(135deg,#D4A017,#7A5600)';
                $accent_color = '#FFD54F';
                $tier_icon = 'emoji_events';
            } else if ($tier == 'platinum') {
                $bg_color = 'linear-gradient(135deg,#4A5A6A,#151A20)';
                $accent_color = '#B8D4E3';
                $tier_icon = 'diamond';
            } else if ($tier == 'vip') {
                $bg_color = 'linear-gradient(135deg,#4a148c,#0d001f)';
                $accent_color = '#ff7cf5';
                $tier_icon = 'auto_awesome';
            }
            ?>
            <div class="col-lg-5">
                <div class="card border-0 shadow-sm h-100" style="border-radius:16px;background:<?= $bg_color ?>;color:#fff;">
                    <div class="card-body p-4 position-relative overflow-hidden d-flex flex-column justify-content-between">
                        <div class="position-absolute opacity-10" style="bottom:-20px;right:-20px;font-size:140px;font-family:sans-serif;font-weight:900;line-height:1;pointer-events:none;">★</div>
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-4">
                                <div>
                                    <span class="text-uppercase fw-bold text-white-50" style="font-size:10px;letter-spacing:1px;">
                                        Loyalty Membership
                                    </span>
                                    <h4 class="fw-bold mb-0 mt-1" style="color:<?= $accent_color ?>;letter-spacing:-0.5px;">
                                        <?= !empty($membership->tier_name) ? $membership->tier_name : 'Reguler Member' ?>
                                    </h4>
                                </div>
                                <div class="rounded-circle d-flex align-items-center justify-content-center bg-white bg-opacity-10" style="width:44px;height:44px;color:<?= $accent_color ?>;">
                                    <i class="material-symbols-outlined" style="font-size:24px;"><?= $tier_icon ?></i>
                                </div>
                            </div>
                            <div class="mb-4">
                                <small class="text-white-50 d-block mb-2 fw-bold text-uppercase" style="font-size:10px;letter-spacing:.5px;">
                                    Keuntungan Eksklusif Anda
                                </small>
                                <ul class="list-unstyled mb-0 d-flex flex-column gap-2" style="font-size:13px;opacity:.95;">
                                    <li class="d-flex align-items-center gap-2">
                                        <span style="color:<?= $accent_color ?>;">⚡</span>
                                        Diskon Langsung <strong><?= $membership->discount_percent ?? 0 ?>%</strong> per Sesi
                                    </li>
                                    <li class="d-flex align-items-center gap-2">
                                        <span style="color:<?= $accent_color ?>;">⚡</span>
                                        Bonus Akumulasi <strong><?= $membership->bonus_hour ?? 0 ?> Jam</strong> Sewa Studio
                                    </li>
                                    <li class="d-flex align-items-center gap-2">
                                        <span style="color:<?= $accent_color ?>;">⚡</span>
                                        Prioritas Antrean Tingkat <strong><?= $membership->priority_level ?? 0 ?></strong>
                                    </li>
                                </ul>
                            </div>
                            <?php if (!empty($membership->description)) : ?>
                                <p class="text-white-50 small mb-0 lh-base border-top border-white border-opacity-10 pt-3" style="font-size:12px;">
                                    <?= $membership->description ?>
                                </p>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-2 border-top border-white border-opacity-10">
                            <div>
                                <small class="text-white-50 d-block" style="font-size:10px;">
                                    ID Member Pelanggan
                                </small>
                                <span class="small text-white" style="font-family:monospace;font-size:12px;letter-spacing:.5px;">
                                    #MBR-<?= str_pad($this->session->userdata('id_user') ?? 1, 4, '0', STR_PAD_LEFT) ?>
                                </span>
                            </div>
                            <i class="material-symbols-outlined opacity-50" style="font-size:28px;">qr_code_2</i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row g-4">
            <!-- history booking -->
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm h-100" style="border-radius: 16px; background: #ffffff;">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-2 mb-4">
                            <i class="material-symbols-outlined text-dark">history</i>
                            <h5 class="fw-bold text-dark mb-0" style="font-size: 16px;">Riwayat Transaksi Terakhir</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="font-size: 14px;">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th class="text-secondary text-center border-0 py-3 px-3" style="font-size: 11px; font-weight: 700; text-uppercase: tracking-wider;">ID Pembayaran</th>
                                        <th class="text-secondary text-center border-0 py-3" style="font-size: 11px; font-weight: 700; text-uppercase: tracking-wider;">Tanggal</th>
                                        <th class="text-secondary text-center border-0 py-3" style="font-size: 11px; font-weight: 700; text-uppercase: tracking-wider;">Studio</th>
                                        <th class="text-secondary text-center border-0 py-3" style="font-size: 11px; font-weight: 700; text-uppercase: tracking-wider;">Jumlah</th>
                                        <th class="text-secondary text-center border-0 py-3" style="font-size: 11px; font-weight: 700; text-uppercase: tracking-wider;">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (!empty($transactions)): ?>
                                        <?php foreach ($transactions as $row): ?>
                                            <tr>
                                                <td class="px-3 border-bottom py-3 text-secondary" style="font-family: monospace;">#TX-<?= $row->id_payment ?></td>
                                                <td class="border-bottom text-secondary text-center">
                                                    <?= $row->payment_date
                                                        ? date('d M Y', strtotime($row->payment_date))
                                                        : ($row->payment_status === 'rejected' ? 'CANCELLED' : '-')
                                                    ?>
                                                </td>
                                                <td class="border-bottom text-dark fw-medium"><?= $row->studio_name ?></td>
                                                <td class="border-bottom fw-bold text-dark text-end">Rp<?= number_format($row->amount, 0, ',', '.') ?></td>
                                                <td class="border-bottom">
                                                    <?php
                                                    $pBadge = 'bg-secondary text-white';
                                                    $status_lower = strtolower($row->payment_status);
                                                    if ($status_lower === 'unpaid') $pBadge = 'bg-warning text-dark';
                                                    elseif ($status_lower === 'waiting' || $status_lower === 'waiting_verification') $pBadge = 'bg-info text-dark';
                                                    elseif ($status_lower === 'paid') $pBadge = 'bg-success text-white';
                                                    elseif ($status_lower === 'rejected') $pBadge = 'bg-danger text-white';
                                                    ?>
                                                    <span class="badge px-2.5 py-1 rounded fw-bold text-uppercase <?= $pBadge ?>" style="font-size: 10px;">
                                                        <?= $row->payment_status ?>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center py-4 text-muted small">Belum ada catatan riwayat transaksi.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="row g-3">
                    <!-- studio favorit -->
                    <div class="col-lg-12">
                        <div class="card shadow-sm border-0 h-100" style="border-radius: 16px; background: #ffffff;">
                            <div class="card-header bg-white border-0 pb-0 pt-4 px-4">
                                <h5 class="mb-0 fw-bold text-dark" style="font-size: 16px; color: #212529 !important;">Studio Favorit Anda</h5>
                                <small class="text-secondary" style="color: #6c757d !important;">Studio yang paling sering Anda gunakan</small>
                            </div>
                            <div class="card-body p-4">
                                <?php if (!empty($favorite_studio)) : ?>
                                    <div class="row align-items-center g-3">
                                        <div class="col-md-5">
                                            <?php if (!empty($favorite_studio->thumbnail)) : ?>
                                                <img src="<?= base_url('uploads/studio/' . $favorite_studio->thumbnail) ?>"
                                                    class="img-fluid rounded-3 shadow-xs w-100"
                                                    style="height:160px; object-fit:cover; border-radius: 12px !important;">
                                            <?php else : ?>
                                                <div class="d-flex align-items-center justify-content-center rounded-3 bg-light"
                                                    style="height:160px; background-color: #f1f3f5 !important; border-radius: 12px !important;">
                                                    <i class="material-symbols-outlined" style="font-size:48px; color: #6c757d;">videocam</i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-md-7 d-flex flex-column justify-content-between" style="min-height: 160px;">
                                            <div>
                                                <h4 class="fw-bold text-dark mb-3" style="font-size: 18px; color: #212529 !important;">
                                                    <?= $favorite_studio->studio_name ?>
                                                </h4>
                                                <div class="mb-3 d-flex flex-column gap-2" style="font-size: 13px; color: #495057;">
                                                    <div class="d-flex align-items-center">
                                                        <i class="material-symbols-outlined me-2" style="color: #495057; font-size: 18px;">event_available</i>
                                                        <span>Digunakan <strong><?= number_format($favorite_studio->total_booking) ?></strong> kali</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="material-symbols-outlined me-2" style="color: #495057; font-size: 18px;">schedule</i>
                                                        <span>Total <strong><?= number_format($favorite_studio->total_hour) ?></strong> jam penggunaan</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-grid">
                                                <a href="<?= base_url('booking/create_booking/' . $favorite_studio->id_studio) ?>"
                                                    class="btn btn-dark btn-sm fw-semibold py-2"
                                                    style="background-color: #1a1d20; border: none; border-radius: 12px !important; font-size: 13px;">
                                                    <i class="material-symbols-outlined align-middle me-1" style="font-size: 16px;">add_circle</i>
                                                    Booking Studio Ini Lagi
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                <?php else : ?>
                                    <div class="text-center py-4">
                                        <i class="material-symbols-outlined mb-2" style="font-size:56px; color: #adb5bd;">videocam_off</i>
                                        <h6 class="fw-bold text-dark" style="color: #343a40 !important;">Belum Ada Studio Favorit</h6>
                                        <p class="text-muted small mb-3 px-3">
                                            Anda belum memiliki riwayat booking studio yang cukup untuk menentukan studio favorit.
                                        </p>
                                        <a href="<?= base_url('booking/create') ?>" class="btn btn-outline-dark btn-sm rounded-3 px-3" style="border-radius: 8px !important; font-size: 12px;">
                                            Mulai Booking
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <!-- paket favorit -->
                    <div class="col-lg-12">
                        <div class="card border-0 shadow-sm" style="border-radius: 16px; background: #ffffff;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-2 mb-3">
                                    <i class="material-symbols-outlined" style="color: #495057; font-size: 20px;">star</i>
                                    <h5 class="fw-bold text-dark mb-0" style="font-size: 15px; color: #212529 !important;">Paket Favorit Anda</h5>
                                </div>
                                <?php if ($favorite_package): ?>
                                    <div class="p-3 rounded-3 d-flex align-items-center flex-wrap flex-md-nowrap gap-3 border" style="background-color: #f8f9fa; border-radius: 12px !important; border-color: #e9ecef !important;">
                                        <div class="flex-shrink-0 rounded-3 d-flex align-items-center justify-content-center" style="width: 54px; height: 54px; background-color: #e9ecef;">
                                            <i class="material-symbols-outlined" style="font-size: 24px; color: #495057;">photo_library</i>
                                        </div>
                                        <div class="d-flex flex-column flex-sm-row align-items-sm-center gap-2 gap-sm-4">
                                            <div>
                                                <h6 class="fw-bold text-dark mb-0" style="font-size: 14px; color: #212529 !important;"><?= $favorite_package->package_name ?></h6>
                                                <div class="fw-bold text-dark small mt-0.5" style="color: #212529 !important;">
                                                    Rp<?= number_format($favorite_package->price, 0, ',', '.') ?>
                                                    <span class="text-secondary fw-normal" style="color: #6c757d !important; font-size: 12px;">/ <?= $favorite_package->duration_hour ?> Jam</span>
                                                </div>
                                            </div>
                                            <div>
                                                <span class="badge bg-white border text-dark rounded-2 px-2 py-1.5" style="font-size: 11px; font-weight: 500; color: #495057 !important; border-color: #dee2e6 !important;">
                                                    Dipesan <?= $favorite_package->total_booking ?> kali
                                                </span>
                                            </div>
                                        </div>
                                        <div class="ms-md-auto w-100 w-md-auto mt-2 mt-md-0">
                                            <a href="<?= base_url('booking/create') ?>" class="btn btn-dark btn-sm fw-semibold px-4 py-2" style="background-color: #1a1d20; border: none; border-radius: 10px !important; font-size: 12px; white-space: nowrap;">
                                                Booking Lagi
                                            </a>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="alert border-0 rounded-3 small mb-0 p-3 d-flex align-items-center gap-2" style="background-color: #f1f3f5; color: #495057; border-radius: 12px !important;">
                                        <i class="material-symbols-outlined fs-5" style="color: #6c757d;">info</i>
                                        <span style="color: #6c757d;">Belum memiliki paket studio favorit terdaftar.</span>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>