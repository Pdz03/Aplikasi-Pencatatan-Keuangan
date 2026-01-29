<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0"><?= $title; ?></h1> 
            <?= $this->session->flashdata('message'); ?>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow">
                <div class="card-header">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalTambah">Tambah Menu Utama</button>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama Menu</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($menu as $m) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $m['menu']; ?></td>
                                <td>
                                    <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#modalEdit<?= $m['id']; ?>">Edit</button>
                                    <a href="<?= base_url('menu/hapus/') . $m['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin?')">Hapus</a>
                                </td>
                            </tr>

                            <div class="modal" id="modalEdit<?= $m['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="modalEditLabel<?= $m['id']; ?>" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditLabel<?= $m['id']; ?>">Edit Nama Menu</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?= base_url('menu/edit'); ?>" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $m['id']; ?>">
                                                <div class="form-group">
                                                    <label>Nama Menu</label>
                                                    <input type="text" class="form-control" name="menu" value="<?= $m['menu']; ?>" required>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<div class="modal" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTambahLabel">Tambah Menu Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/tambah'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Menu</label>
                        <input type="text" class="form-control" name="menu" placeholder="Contoh: SETTING" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>