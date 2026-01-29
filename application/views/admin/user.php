<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><?= $title; ?></h1>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            
            <?= $this->session->flashdata('message'); ?>

            <div class="card shadow">
                <div class="card-header">
                    <h3 class="card-title">Tabel Master User</h3>
                    <div class="card-tools">
                        <a href="<?= base_url('admin/addUser'); ?>" class="btn btn-primary btn-sm">
                            <i class="fas fa-plus"></i> Tambah User Baru
                        </a>
                    </div>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>WhatsApp</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th style="width: 150px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($users as $u) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $u['nama']; ?></td>
                                <td><?= $u['username']; ?></td>
                                <td><?= $u['no_wa']; ?></td>
                                <td>
                                    <span class="badge badge-info"><?= $u['role']; ?></span>
                                </td>
                                <td>
                                    <?= ($u['is_verified'] == 1) ? '<span class="badge badge-success">Aktif</span>' : '<span class="badge badge-warning">Pending</span>'; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/editUser/') . $u['id']; ?>" class="btn btn-warning btn-xs">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= base_url('admin/deleteUser/') . $u['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin ingin menghapus user ini?')">
                                        <i class="fas fa-trash"></i> Hapus
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                </div>
        </div>
    </section>
</div>