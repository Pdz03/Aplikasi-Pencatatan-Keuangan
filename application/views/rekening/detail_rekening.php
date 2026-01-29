
<div class="content-header">
    <div class="container-fluid">
        <h1 class="m-0 text-dark">Detail <?= $dompet['title']; ?></h1>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-12 col-md-4">
                <div class="small-box bg-indigo">
                    <div class="inner">
                        <h3>Rp <?= number_format($saldo, 0, ',', '.'); ?></h3>
                        <p>Total Saldo Saat Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-university"></i></div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="small-box bg-success">
                    <div class="inner">
                        <h3>Rp <?= number_format($total_masuk, 0, ',', '.'); ?></h3>
                        <p>Pemasukan Bulan Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-arrow-circle-up"></i></div>
                </div>
            </div>

            <div class="col-lg-4 col-12"> <div class="small-box bg-danger">
                    <div class="inner">
                        <h3>Rp <?= number_format($total_keluar, 0, ',', '.'); ?></h3>
                        <p>Pengeluaran Bulan Ini</p>
                    </div>
                    <div class="icon"><i class="fas fa-arrow-circle-down"></i></div>
                </div>
            </div>
        </div> <div class="row mt-3">
            <div class="col-md-12">
                <div class="card card-outline card-indigo">
                    <div class="card-header">
                        <h3 class="card-title">Riwayat Transaksi Terakhir</h3>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                        <table class="table table-striped table-valign-middle">
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                    <th>Tipe</th>
                                    <th class="text-right">Jumlah</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (empty($transaksi)) : ?>
                                    <tr>
                                        <td colspan="4" class="text-center p-3">Belum ada data transaksi untuk dompet ini.</td>
                                    </tr>
                                <?php endif; ?>
                                
                                <?php foreach ($transaksi as $t) : ?>
                                <tr>
                                    <td><?= date('d/m/Y', strtotime($t['tanggal'])); ?></td>
                                    <td><?= $t['keterangan']; ?></td>
                                    <td>
                                        <span class="badge badge-<?= ($t['tipe'] == 'pemasukan') ? 'success' : 'danger'; ?>">
                                            <?= ucfirst($t['tipe']); ?>
                                        </span>
                                    </td>
                                    <td class="text-right">
                                        <?php if ($t['tipe'] == 'pemasukan') : ?>
                                            <span class="text-success" style="font-weight: bold;">
                                                + Rp <?= number_format($t['jumlah'], 0, ',', '.'); ?>
                                            </span>
                                        <?php else : ?>
                                            <span class="text-danger" style="font-weight: bold;">
                                                - Rp <?= number_format($t['jumlah'], 0, ',', '.'); ?>
                                            </span>
                                        <?php endif; ?>
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

        <div class="row mb-5">
            <div class="col-md-12">
                <button class="btn btn-success" data-toggle="modal" data-target="#modalTransaksi" onclick="setTransaksi('pemasukan')">
                    <i class="fas fa-plus-circle"></i> Tambah Pemasukan
                </button>
                <button class="btn btn-danger" data-toggle="modal" data-target="#modalTransaksi" onclick="setTransaksi('pengeluaran')">
                    <i class="fas fa-minus-circle"></i> Catat Pengeluaran
                </button>
                <button class="btn btn-info" data-toggle="modal" data-target="#modalTransfer">
                    <i class="fas fa-exchange-alt"></i> Transfer Dana
                </button>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="modalTransaksi" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="judulModal">Transaksi</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="<?= base_url('rekening/prosesTransaksi'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_dompet" value="<?= $dompet['id']; ?>">
                    <input type="hidden" name="tipe" id="input_tipe">

                    <div class="form-group">
                        <label>Jumlah (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="Masukkan angka tanpa titik" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <input type="text" name="keterangan" class="form-control" placeholder="Contoh: Gaji, Makan Siang, Top Up" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTransfer" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transfer Saldo</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
            </div>
            <form action="<?= base_url('rekening/prosesTransfer'); ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_asal" value="<?= $dompet['id']; ?>">
                    
                    <div class="alert alert-secondary">
                        Sumber Dana: <strong><?= $dompet['title']; ?></strong>
                    </div>

                    <div class="form-group">
                        <label>Pilih Dompet Tujuan</label>
                        <select name="id_tujuan" class="form-control" required>
                            <option value="">-- Pilih Tujuan --</option>
                            <?php 
                            $dompet_tujuan = $this->db->get('user_sub_menu')->result_array();
                            foreach($dompet_tujuan as $dt) : 
                                if($dt['id'] != $dompet['id']) : ?>
                                    <option value="<?= $dt['id']; ?>"><?= $dt['title']; ?></option>
                            <?php endif; endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jumlah Transfer (Rp)</label>
                        <input type="number" name="jumlah" class="form-control" placeholder="0" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info">Kirim Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function setTransaksi(tipe) {
    $('#input_tipe').val(tipe);
    $('#judulModal').text('Input ' + (tipe == 'pemasukan' ? 'Pemasukan' : 'Pengeluaran'));
}
</script>