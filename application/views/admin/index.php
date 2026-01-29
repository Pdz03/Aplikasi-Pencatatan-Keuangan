<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0"><?= $title; ?></h1>
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>
    
    <section class="content px-4">
<div class="row">
    <div class="col-lg-3 col-6 col-12">
        <div class="small-box bg-info shadow">
            <div class="inner">
                <h3><?= $total_user; ?></h3>
                <p>Total User</p>
            </div>
            <div class="icon"><i class="fas fa-users"></i></div>
            <a href="<?= base_url('admin/users'); ?>" class="small-box-footer">Detail <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>

    <div class="col-lg-3 col-6 col-12">
        <div class="small-box bg-success shadow">
            <div class="inner">
                <h3>Rp <?= number_format($total_nominal, 0, ',', '.'); ?></h3>
                <p>Total Uang di Sistem</p>
            </div>
            <div class="icon"><i class="fas fa-hand-holding-usd"></i></div>
            <div class="small-box-footer">Global Nominal</div>
        </div>
    </div>

    <div class="col-lg-3 col-6 col-12">
        <div class="small-box bg-warning shadow text-white">
            <div class="inner">
                <h3><?= $transaksi_hari_ini; ?></h3>
                <p>Transaksi Hari Ini</p>
            </div>
            <div class="icon"><i class="fas fa-exchange-alt"></i></div>
            <div class="small-box-footer" style="color: rgba(255,255,255,0.8) !important;">Monitoring Aktif</div>
        </div>
    </div>

    <div class="col-lg-3 col-6 col-12">
        <div class="small-box bg-danger shadow">
            <div class="inner">
                <h3><?= $total_role; ?></h3>
                <p>Role Jabatan</p>
            </div>
            <div class="icon"><i class="fas fa-user-tag"></i></div>
            <a href="<?= base_url('admin/role'); ?>" class="small-box-footer">Cek Role <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
<div class="row mt-4">
    <div class="col-lg-7">
        <div class="card card-outline card-primary shadow">
            <div class="card-header border-0">
                <h3 class="card-title font-weight-bold">Pengguna Terbaru</h3>
                <div class="card-tools">
                    <a href="<?= base_url('admin/users'); ?>" class="btn btn-tool btn-sm">
                        <i class="fas fa-bars"></i>
                    </a>
                </div>
            </div>
            <div class="card-body table-responsive p-0">
                <table class="table table-striped table-valign-middle">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>No. WA</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recent_users as $ru) : ?>
                        <tr>
                            <td><?= $ru['nama']; ?></td>
                            <td><?= $ru['no_wa']; ?></td>
                            <td>
                                <span class="badge <?= $ru['is_verified'] == 1 ? 'badge-success' : 'badge-secondary'; ?>">
                                    <?= $ru['is_verified'] == 1 ? 'Aktif' : 'Pending'; ?>
                                </span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-lg-5">
    <div class="card shadow card-outline card-warning">
        <div class="card-header">
            <h3 class="card-title font-weight-bold"><i class="fas fa-tags mr-1"></i> Ringkasan Sistem</h3>
        </div>
        <div class="card-body">
            <p class="text-muted small">Informasi cepat mengenai kondisi database dan server saat ini.</p>
            
           <div class="progress-group">
    User Terverifikasi
    <span class="float-right"><b><?= $user_aktif; ?></b>/<?= $total_user; ?></span>
    <div class="progress progress-sm">
        <div class="progress-bar bg-primary" style="width: <?= $persen_aktif; ?>%"></div>
    </div>
</div>

<div class="progress-group mt-3">
    User Belum Verifikasi
    <?php $pending = $total_user - $user_aktif; ?>
    <span class="float-right"><b><?= $pending; ?></b> User</span>
    <div class="progress progress-sm">
        <div class="progress-bar bg-warning" style="width: <?= ($total_user > 0) ? ($pending / $total_user * 100) : 0; ?>%"></div>
    </div>
</div>

            <div class="progress-group mt-3">
                Kapasitas Database
                <span class="float-right"><b>Low Usage</b></span>
                <div class="progress progress-sm">
                    <div class="progress-bar bg-success" style="width: 20%"></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</section>
</div>
                        </div>
                        