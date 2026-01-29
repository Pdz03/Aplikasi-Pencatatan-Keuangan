<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1><?= $title; ?></h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card card-primary shadow">
                        <div class="card-header">
                            <h3 class="card-title">Form Update Data User</h3>
                        </div>
                        <form action="" method="post">
                            <input type="hidden" name="id" value="<?= $user_to_edit['id']; ?>">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="nama" value="<?= $user_to_edit['nama']; ?>">
                                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="no_wa">Nomor WhatsApp</label>
                                    <input type="text" class="form-control" name="no_wa" value="<?= $user_to_edit['no_wa']; ?>">
                                    <?= form_error('no_wa', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                <div class="form-group">
                                    <label for="id_role">Role User</label>
                                    <select name="id_role" id="id_role" class="form-control">
                                        <?php foreach ($roles as $r) : ?>
                                            <option value="<?= $r['id']; ?>" <?= $r['id'] == $user_to_edit['id_role'] ? 'selected' : ''; ?>>
                                                <?= $r['role']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <a href="<?= base_url('admin/users'); ?>" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>