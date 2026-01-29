<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary mt-3">
                <div class="card-header">
                    <h3 class="card-title">Edit Profil Saya</h3>
                </div>
                <?= form_open_multipart('user/edit_profile'); ?>
                <div class="card-body">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" value="<?= $user['nama']; ?>">
                    </div>
                    <div class="form-group">
                        <label for="no_wa">No WhatsApp</label>
                        <input type="text" class="form-control" name="no_wa" value="<?= $user['no_wa']; ?>">
                    </div>
                    <div class="form-group">
                        <label>Foto Profil</label>
                        <div class="row">
                            <div class="col-sm-3">
                                <img src="<?= base_url('assets/adminlte/img/profile/') . $user['foto']; ?>" class="img-thumbnail">
                            </div>
                            <div class="col-sm-9">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="foto" id="foto">
                                    <label class="custom-file-label" for="foto">Pilih gambar baru...</label>
                                </div>
                                <small class="text-muted">Format: JPG, PNG, JPEG. Maks: 2MB</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="<?= base_url('user/profile'); ?>" class="btn btn-secondary">Batal</a>
                </div>
                </form>
            </div>
        </div>
    </section>
</div>