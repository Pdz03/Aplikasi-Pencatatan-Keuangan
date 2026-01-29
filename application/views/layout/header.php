<!DOCTYPE html>
<html>
<head>
   <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $title ?? 'Dashboard' ?></title>
    
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/plugins/fontawesome-free/css/all.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/dist/css/adminlte.min.css') ?>">
   <style> .sidebar {
    overflow-x: visible !important;
    overflow-y: auto !important;
}</style>
<style>
    .user-panel .image img {
      width: 2.1rem; /* Ukuran standar AdminLTE */
      height: 2.1rem;
      object-fit: cover; /* KUNCINYA DI SINI: Memotong gambar agar pas kotak */
      object-position: center;
  }
  .profile-user-img {
      width: 100px;
      height: 100px;
      object-fit: cover; /* Ini menjaga foto tetap proporsional */
  }
</style>
<style>
    /* Versi lebih kuat agar pasti berubah */
    .card {
        border: none !important;
        border-radius: 15px !important;
        /* Bayangan kita pertebal sedikit agar terlihat jelas bedanya */
        box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important; 
        transition: all 0.3s ease-in-out !important;
        overflow: hidden; /* Supaya lekukan sudut rapi */
    }

    .card:hover {
        transform: translateY(-8px) !important;
        box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
    }

    /* Memperbaiki header kartu agar clean */
    .card-header {
        background-color: transparent !important;
        border-bottom: 1px solid rgba(0,0,0,0.05) !important;
    }
</style>
<style>
    /* Kartu Pemasukan dengan Gradasi Hijau Lembut */
    .card-income {
        background: linear-gradient(45deg, #ffffff 70%, #f0fff4 100%) !important;
        border-left: 5px solid #28a745 !important;
    }

    /* Kartu Pengeluaran dengan Gradasi Merah Lembut */
    .card-expense {
        background: linear-gradient(45deg, #ffffff 70%, #fff5f5 100%) !important;
        border-left: 5px solid #dc3545 !important;
    }

    /* Menghaluskan teks label */
    .text-label-custom {
        letter-spacing: 0.5px;
        font-size: 0.85rem;
        opacity: 0.8;
    }
</style>
<style>
    /* Efek Glow & Hover untuk Pemasukan */
    .card-income:hover {
        box-shadow: 0 8px 25px rgba(40, 167, 69, 0.2) !important;
        transform: translateY(-5px);
    }
    .card-income:hover .text-success {
        text-shadow: 0 0 10px rgba(40, 167, 69, 0.3);
        transition: 0.3s;
    }

    /* Efek Glow & Hover untuk Pengeluaran */
    .card-expense:hover {
        box-shadow: 0 8px 25px rgba(220, 53, 69, 0.2) !important;
        transform: translateY(-5px);
    }
    .card-expense:hover .text-danger {
        text-shadow: 0 0 10px rgba(220, 53, 69, 0.3);
        transition: 0.3s;
    }

    /* Transisi halus untuk semua kartu */
    .card {
        transition: all 0.3s ease-in-out !important;
    }
</style>
<style>
    /* Efek Glow Hitam untuk Total Saldo */
    .card-total-saldo {
        border-right: 5px solid #343a40 !important; /* Garis samping hitam/dark */
        transition: all 0.3s ease-in-out !important;
    }

    .card-total-saldo:hover {
        /* Bayangan kotak yang lebih tegas */
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        transform: translateY(-5px);
    }

    /* Efek cahaya hitam/gelap pada teks */
    .card-total-saldo:hover h2 {
        color: #000000 !important;
        /* Membuat teks terlihat lebih tajam dengan shadow halus */
        text-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
        transition: 0.3s;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>
<body class="hold-transition sidebar-mini layout-fixed">



<div class="wrapper">
