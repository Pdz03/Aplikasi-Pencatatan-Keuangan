<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Verifikasi OTP</title>

    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
</head>

<body class="hold-transition login-page">
<div class="login-box">
    <div class="login-logo">
        <b>APK Keuangan</b>
    </div>

    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">
                Masukkan kode OTP yang dikirim ke WhatsApp
            </p>
            <?php if ($this->session->flashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('auth/verifikasi_otp') ?>" method="post">
                <input type="hidden" name="username" value="<?= $username ?>">

                <div class="input-group mb-3">
                    <input type="text" name="otp" class="form-control" placeholder="Kode OTP" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-key"></span>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">
                    Verifikasi
                </button>
            </form>

            <p class="mt-3 text-center">
                <a href="<?= base_url('register') ?>">Kembali ke Register</a>
            </p>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>
</html>
