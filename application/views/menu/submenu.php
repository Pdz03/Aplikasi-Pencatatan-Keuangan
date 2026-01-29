<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid"><h1 class="m-0"><?= $title; ?></h1></div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <?= $this->session->flashdata('message'); ?>
            <div class="card shadow">
                <div class="card-header">
                    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#newSubMenuModal">Tambah Submenu Baru</button>
                </div>
                <div class="card-body table-responsive p-0">
                    <table class="table table-hover text-nowrap">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Menu</th>
                                <th>Url</th>
                                <th>Icon</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; foreach ($submenu as $sm) : ?>
                            <tr>
                                <td><?= $i++; ?></td>
                                <td><?= $sm['title']; ?></td>
                                <td><?= $sm['menu']; ?></td>
                                <td><?= $sm['url']; ?></td>
                                <td><i class="<?= $sm['icon']; ?>"></i> <span class="ml-2"><?= $sm['icon']; ?></span></td>
                                <td>
                                    <a href="<?= base_url('menu/toggle_submenu/') . $sm['id']; ?>" class="badge <?= $sm['is_active'] ? 'badge-success' : 'badge-secondary'; ?>">
                                        <?= $sm['is_active'] ? 'Active' : 'Not Active'; ?>
                                    </a>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-xs" data-toggle="modal" data-target="#editSubModal<?= $sm['id']; ?>">Edit</button>
                                    <a href="<?= base_url('menu/hapus_submenu/') . $sm['id']; ?>" class="btn btn-danger btn-xs" onclick="return confirm('Yakin?')">Hapus</a>
                                </td>
                            </tr>

                            <div class="modal fade" id="editSubModal<?= $sm['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Submenu</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        </div>
                                        <form action="<?= base_url('menu/edit_submenu'); ?>" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id" value="<?= $sm['id']; ?>">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" name="title" value="<?= $sm['title']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Menu Parent</label>
                                                    <select name="id_menu" class="form-control" required>
                                                        <?php foreach ($menu as $m) : ?>
                                                            <option value="<?= $m['id']; ?>" <?= ($m['id'] == $sm['id_menu']) ? 'selected' : ''; ?>><?= $m['menu']; ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>URL</label>
                                                    <input type="text" class="form-control" name="url" value="<?= $sm['url']; ?>" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Icon Class</label>
                                                    <input type="text" class="form-control" name="icon" value="<?= $sm['icon']; ?>" required>
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


<div class="modal fade" id="newSubMenuModal" tabindex="-1" role="dialog" aria-labelledby="newSubMenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newSubMenuModalLabel">Tambah Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="<?= base_url('menu/tambah_submenu'); ?>" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" name="title" placeholder="Submenu title">
                    </div>
                    <div class="form-group">
                        <select name="id_menu" id="id_menu" class="form-control">
                            <option value="">Select Menu</option>
                            <?php foreach ($menu as $m) : ?>
                            <option value="<?= $m['id']; ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="url" placeholder="Submenu url (e.g: menu/submenu)">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="icon" placeholder="Submenu icon (e.g: fas fa-fw fa-folder)">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
</div>