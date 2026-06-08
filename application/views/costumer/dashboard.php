<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Customer - StudioHead</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 rounded-4 p-4 text-center">
                    <h2 class="fw-bold text-success mb-3">🎉 Login Berhasil!</h2>
                    <h4>Selamat Datang di StudioHead, <span class="text-primary"><?= $fullname; ?></span>!</h4>
                    <p class="text-muted mt-2">Ini adalah halaman Dashboard Customer kamu.</p>
                    <div class="mt-4">
                        <a href="<?= site_url('auth/logout'); ?>" class="btn btn-danger px-4 rounded-pill">Log Out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>