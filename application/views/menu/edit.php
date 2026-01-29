<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <div class="row">
        <div class="col-lg-6">

            <form action="" method="post">
                <div class="form-group">
                    <label for="menu">Menu Name</label>
                    <input type="text" class="form-control" id="menu" name="menu" value="<?= set_value('menu', $menu['menu']); ?>">
                    <?= form_error('menu', '<small class="text-danger pl-3">', '</small>'); ?>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
                <a href="<?= base_url('menu'); ?>" class="btn btn-secondary">Cancel</a>
            </form>

        </div>
    </div>
</div>
