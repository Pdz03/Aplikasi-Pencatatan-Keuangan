<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <h1 class="m-0"><?= $title; ?></h1>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Form Input User Baru</h3>
                        </div>
                        
                        <form action="<?= base_url('admin/addUser'); ?>" method="post">
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="nama">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" value="<?= set_value('nama'); ?>">
                                    <?= form_error('nama', '<small class="text-danger">', '</small>'); ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="username">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username untuk login" value="<?= set_value('username'); ?>">
                                    <?= form_error('username', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="form-group">
                                    <label for="no_wa">Nomor WhatsApp</label>
                                    <input type="text" class="form-control" id="no_wa" name="no_wa" placeholder="Contoh: 08123456789" value="<?= set_value('no_wa'); ?>">
                                    <?= form_error('no_wa', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="form-group">
                                    <label for="password">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Minimal 6 karakter">
                                    <?= form_error('password', '<small class="text-danger">', '</small>'); ?>
                                </div>

                                <div class="form-group">
                                    <label for="id_role">Role / Tingkatan</label>
                                    <select class="form-control" id="id_role" name="id_role">
                                        <option value="">-- Pilih Role --</option>
                                        <?php foreach ($roles as $r) : ?>
                                            <option value="<?= $r['id']; ?>" <?= set_select('id_role', $r['id']); ?>>
                                                <?= $r['role']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?= form_error('id_role', '<small class="text-danger">', '</small>'); ?>
                                </div>
                            </div>

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Simpan User</button>
                                <a href="<?= base_url('admin/users'); ?>" class="btn btn-secondary">Batal</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>