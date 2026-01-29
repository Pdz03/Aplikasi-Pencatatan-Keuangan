<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <?= $this->session->flashdata('message'); ?>

    <!-- ================== HALAMAN ROLE LIST ================== -->
    <?php if (!isset($menu)) : ?>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Data Role</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th width="50">#</th>
                                <th>Role</th>
                                <th width="120">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1; ?>
                            <?php foreach ($role as $r): ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= $r['role']; ?></td>
                                    <td>
                                        <a href="<?= base_url('role/access/'.$r['id']); ?>"
                                           class="btn btn-sm btn-primary">
                                            Access
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    <!-- ================== HALAMAN ROLE ACCESS ================== -->
    <?php else : ?>

        <h5 class="mb-3">
            Role : <strong><?= $role['role']; ?></strong>
        </h5>

        <div class="card shadow mb-4">
            <div class="card-body">

                <table class="table table-bordered">
                    <thead class="thead-light">
                        <tr>
                            <th width="50">#</th>
                            <th>Menu</th>
                            <th width="100">Akses</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; ?>
                        <?php foreach ($menu as $m): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $m['menu']; ?></td>
                                <td class="text-center">
                                    <div class="form-check">
                                        <input class="form-check-input"
                                               type="checkbox"
                                               <?= check_access($role['id'], $m['id']); ?>
                                               data-role="<?= $role['id']; ?>"
                                               data-menu="<?= $m['id']; ?>">
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <a href="<?= base_url('role'); ?>" class="btn btn-secondary mt-3">
                    Kembali
                </a>

            </div>
        </div>

    <?php endif; ?>

</div>

<!-- ================== SCRIPT AJAX ================== -->
<script>
$('.form-check-input').on('click', function () {
    const roleId = $(this).data('role');
    const menuId = $(this).data('menu');

    $.ajax({
        url: "<?= base_url('role/changeAccess'); ?>",
        type: 'post',
        data: {
            role_id: roleId,
            menu_id: menuId
        },
        success: function () {
            document.location.href = "<?= base_url('role/access/'); ?>" + roleId;
        }
    });
});
</script>