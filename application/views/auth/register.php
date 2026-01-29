<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register</title>

    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
</head>

<body class="hold-transition register-page">
<div class="register-box">
    <div class="register-logo">
        <b>APK Keuangan</b>
    </div>

    <div class="card">
        <div class="card-body register-card-body">
            <p class="login-box-msg">Daftar akun baru</p>

            <form action="<?= base_url('auth/proses_register') ?>" method="post">

                <div class="input-group mb-3">
                    <input type="text" name="nama" class="form-control" placeholder="Nama" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-user-circle"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="text" name="no_wa" class="form-control" placeholder="WhatsApp (628xxx)" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fab fa-whatsapp"></span></div>
                    </div>
                </div>

                <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                    <div class="input-group-append">
                        <div class="input-group-text"><span class="fas fa-lock"></span></div>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary btn-block">Register</button>
            </form>

            <p class="mt-3 text-center">
                <a href="<?= base_url('login') ?>">Sudah punya akun? Login</a>
            </p>
        </div>
    </div>
</div>

<script src="<?= base_url('assets/adminlte/plugins/jquery/jquery.min.js') ?>"></script>
<script src="<?= base_url('assets/adminlte/dist/js/adminlte.min.js') ?>"></script>
</body>
</html>
