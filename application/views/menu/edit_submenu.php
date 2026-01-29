<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>

    <form action="<?= base_url('menu/edit_submenu/' . $submenu['id']); ?>" method="post">
        <input type="hidden" name="id" value="<?= $submenu['id']; ?>">
        
        <div class="form-group">
            <label for="title">Submenu Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $submenu['title']; ?>">
            <?= form_error('title', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <div class="form-group">
            <label for="menu_id">Menu</label>
            <select name="menu_id" id="menu_id" class="form-control">
                <?php foreach($menu as $m): ?>
                    <option value="<?= $m['id']; ?>" <?= $m['id'] == $submenu['menu_id'] ? 'selected' : ''; ?>>
                        <?= $m['menu']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?= form_error('menu_id', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <div class="form-group">
            <label for="url">URL</label>
            <input type="text" class="form-control" id="url" name="url" value="<?= $submenu['url']; ?>">
            <?= form_error('url', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <div class="form-group">
            <label for="icon">Icon</label>
            <input type="text" class="form-control" id="icon" name="icon" value="<?= $submenu['icon']; ?>">
            <?= form_error('icon', '<small class="text-danger pl-3">', '</small>'); ?>
        </div>

        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" <?= $submenu['is_active'] ? 'checked' : ''; ?>>
            <label class="form-check-label" for="is_active">Active?</label>
        </div>

        <br>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="<?= base_url('menu/submenu'); ?>" class="btn btn-secondary">Cancel</a>
    </form>
</div>
