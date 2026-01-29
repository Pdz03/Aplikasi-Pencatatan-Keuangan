<?php
$menu = $menu ?? []; // ⬅️ PENTING
?>
<?php $this->load->view('layout/header', ['title' => 'Dashboard']); ?>
<?php $this->load->view('layout/navbar'); ?>
<?php $this->load->view('layout/sidebar' , ['menu' => $menu]); ?>


<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1 class="m-0">Website Pencatatan Keuangan Pribadi</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-7">
                    <div class="card shadow-sm border-0 p-4 mb-3 position-relative overflow-hidden card-total-saldo">
    
    <div style="position: absolute; right: -10px; bottom: -10px; opacity: 0.08; font-size: 5rem; z-index: 1;">
        <i class="fas fa-wallet text-dark"></i>
    </div>

    <div style="position: relative; z-index: 2;">
        <small class="text-muted font-weight-bold">Total Saldo</small>
        <h2 class="font-weight-bold" style="color: #212529;">
            Rp <?= number_format($total_saldo, 0, ',', '.'); ?>
        </h2>
    </div>
</div>
                    
                    <div class="row">
    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border-0 p-3 card-income position-relative overflow-hidden">
            <div style="position: absolute; right: 10px; top: 10px; opacity: 0.1; font-size: 2rem;">
                <i class="fas fa-arrow-down text-success"></i>
            </div>
            
            <small class="text-muted font-weight-bold text-label-custom">Pemasukan</small>
            <h4 class="text-success font-weight-bold mb-0">
                Rp <?= number_format($total_pemasukan, 0, ',', '.'); ?>
            </h4>
        </div>
    </div>

    <div class="col-md-6 mb-3">
        <div class="card shadow-sm border-0 p-3 card-expense position-relative overflow-hidden">
            <div style="position: absolute; right: 10px; top: 10px; opacity: 0.1; font-size: 2rem;">
                <i class="fas fa-arrow-up text-danger"></i>
            </div>

            <small class="text-muted font-weight-bold text-label-custom">Pengeluaran</small>
            <h4 class="text-danger font-weight-bold mb-0">
                Rp <?= number_format($total_pengeluaran, 0, ',', '.'); ?>
            </h4>
        </div>
    </div>
</div>

                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="font-weight-bold mb-3">Dompet Aktif</h5>
                            <table class="table table-borderless">
                                <thead>
                                    <tr class="text-muted border-bottom">
                                        <th>Nama</th>
                                        <th>Saldo</th>
                                        <!-- <th>Aksi</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($list_dompet as $ld) : ?>
                                    <tr>
                                        <td><?= $ld['nama_dompet']; ?></td>
                                        <td class="text-primary font-weight-bold">Rp <?= number_format($ld['saldo'], 0, ',', '.'); ?></td>
                                        
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5">
                <div class="card shadow-sm border-0 mb-3">
                    <div class="card-body text-center"> 
                        <h5 class="font-weight-bold">Statistik Masuk vs Keluar</h5>
                        <div style="position: relative; height:200px; width:100%">
                            <canvas id="myChart"></canvas>
                            <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                                <h4 class="mb-0 font-weight-bold" id="chartCenterText">0%</h4>
                                <small class="text-muted">Terpakai</small>
                            </div>
                        </div>
                        <div class="mt-3">
                            <span class="badge" style="background-color: #2ecc71;">&nbsp;</span> Pemasukan
                            <span class="badge ml-2" style="background-color: #e74c3c;">&nbsp;</span> Pengeluaran
                        </div>
                    </div>
                </div>
                    <div class="card shadow-sm border-0 p-4">
    <h5 class="font-weight-bold">Laporan Ringkas</h5>
    <div class="d-flex justify-content-between mt-3 mb-2">
        <div>
            <small class="text-muted d-block">Status</small>
            <span class="badge badge-pill badge-success px-3">Sangat Aman</span>
        </div>
        <div class="text-right">
            <small class="text-muted d-block">Total Uang</small>
            <span class="font-weight-bold text-primary">Rp <?= number_format($total_saldo, 0, ',', '.'); ?></span>
        </div>
    </div>
    
    <div class="progress mt-3" style="height: 8px; border-radius: 10px;">
        <?php 
            $persen = ($total_pemasukan > 0) ? ($total_pengeluaran / $total_pemasukan) * 100 : 0;
        ?>
        <div class="progress-bar bg-danger" role="progressbar" style="width: <?= $persen; ?>%" aria-valuenow="<?= $persen; ?>" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <small class="text-muted mt-2 d-block">Pengeluaran mencakup <?= round($persen, 1); ?>% dari pemasukan.</small>
</div>
                </div>
            </div> </div>
    </section>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Gunakan DOMContentLoaded agar lebih aman daripada window.onload
    document.addEventListener("DOMContentLoaded", function() {
        var canvasElement = document.getElementById('myChart');
        
        // Cek apakah elemen ada untuk menghindari error "getContext of null"
        if (canvasElement) {
            var ctx = canvasElement.getContext('2d');
            
            // Validasi data: Jika keduanya 0, tampilkan data dummy agar chart tidak kosong
            var dataMasuk = <?= (int)$total_pemasukan; ?>;
            var dataKeluar = <?= (int)$total_pengeluaran; ?>;
            
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Masuk', 'Keluar'],
                    datasets: [{
                        data: [dataMasuk, dataKeluar],
                        backgroundColor: ['#2ecc71', '#e74c3c'],
                        hoverOffset: 4,
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%', 
                    plugins: {
                        legend: { display: false }
                    }
                },
                plugins: [{
                beforeDraw: function(chart) {
                    var total = dataMasuk + dataKeluar;
                    var persenKeluar = total > 0 ? Math.round((dataKeluar / total) * 100) : 0;
                    document.getElementById('chartCenterText').innerText = persenKeluar + '%';
                }
            }]
            });
        }
    });
</script>

<?php $this->load->view('layout/footer'); ?>
