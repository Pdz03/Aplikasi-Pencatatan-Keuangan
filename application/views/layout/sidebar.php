<?php 
// 1. Ambil id_role dari session
$id_role = $this->session->userdata('id_role');

// 2. Pastikan variabel didefinisikan meskipun session kosong (mencegah error)
if (!$id_role) {
    $id_role = 0; 
}

// 3. Gunakan variabel $id_role yang sudah didefinisikan ke dalam query
$queryMenu = "SELECT `user_menu`.`id`, `menu`
                FROM `user_menu` JOIN `user_access_menu` 
                  ON `user_menu`.`id` = `user_access_menu`.`id_menu`
               WHERE `user_access_menu`.`id_role` = $id_role
            ORDER BY `user_access_menu`.`id_menu` ASC";

$menu = $this->db->query($queryMenu)->result_array();
?>
<aside class="main-sidebar sidebar-dark-indigo elevation-4">

  <a href="<?= base_url('dashboard'); ?>" class="brand-link">
    <span class="brand-text font-weight-light">Personal Finance</span>
  </a>

  <div class="sidebar">

    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <?php 
            $foto_session = $this->session->userdata('foto');
            $gambar = ($foto_session) ? $foto_session : 'avatar4.png';
        ?>
        <img src="<?= base_url('assets/adminlte/img/profile/') . $gambar; ?>" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="#" class="d-block"><?= $this->session->userdata('nama'); ?></a>
    </div>
</div>
    <?php if ($this->session->userdata('id_role') != 1) : ?>
    

    <li class="nav-item">
        <a href="#" class="nav-link" data-toggle="modal" data-target="#modalSaldo">
            <i class="nav-icon fas fa-plus-circle text-success"></i>
            <p>Input Saldo Awal</p>
        </a>
    </li>
<?php endif; ?>
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">

        <?php foreach ($menu as $m): ?>
          <li class="nav-header"><?= strtoupper($m['menu']); ?></li>

          <?php
            $parents = $this->db->get_where('user_sub_menu', [
                'id_menu' => $m['id'],
                'parent_id' => 0,
                'is_active' => 1
            ])->result_array();
          ?>

          <?php foreach ($parents as $p): ?>

            <?php
              $children = $this->db->get_where('user_sub_menu', [
                  'parent_id' => $p['id'],
                  'is_active' => 1
              ])->result_array();
            ?>

            <?php if (!empty($children)): ?>
  <?php 
    // Logic untuk mengecek apakah salah satu sub-menu sedang dibuka
    // Kita cek apakah segment URL saat ini ada di dalam array URL children
    $urls = array_column($children, 'url');
    $is_open = in_array($this->uri->uri_string(), $urls);
  ?>

  <li class="nav-item <?= $is_open ? 'menu-open' : ''; ?>">

    <a href="#" class="nav-link <?= $is_open ? 'active' : ''; ?>">
      <i class="nav-icon <?= $p['icon']; ?>"></i>
      <p>
        <?= $p['title']; ?>
        <i class="right fas fa-angle-left"></i>
      </p>
    </a>

    <ul class="nav nav-treeview" style="display: <?= $is_open ? 'block' : 'none'; ?>;">
      <?php foreach ($children as $c): ?>
        <li class="nav-item">
          <a href="javascript:void(0)" onclick="loadDetailRekening(<?= $c['id']; ?>)" class="nav-link">
            <i class="far fa-circle nav-icon"></i>
            <p><?= $c['title']; ?></p>
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

  </li>

<?php else: ?>
  <li class="nav-item">
    <a href="<?= base_url($p['url']); ?>" class="nav-link <?= ($this->uri->uri_string() == $p['url']) ? 'active' : ''; ?>">
      <i class="nav-icon <?= $p['icon']; ?>"></i>
      <p><?= $p['title']; ?></p>
    </a>
  </li>
<?php endif; ?>

          <?php endforeach; ?>

        <?php endforeach; ?>

        <li class="nav-item mt-3">
          <a href="<?= base_url('auth/logout'); ?>" class="nav-link text-danger">
            <i class="nav-icon fas fa-sign-out-alt"></i>
            <p>Logout</p>
          </a>
        </li>

      </ul>
    </nav>

  </div>

</aside>
<div class="modal fade" id="modalSaldo" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Input Saldo Awal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="<?= base_url('rekening/simpanSaldo'); ?>" method="post">
        <div class="modal-body">
          
          <div class="form-group">
            <label>Pilih Rekening / E-Wallet</label>
            <select name="id_dompet" class="form-control" required>
              <option value="">-- Pilih --</option>
              <?php 
                // KODE YANG KAMU TANYAKAN ditaruh di sini:
                $dompet_list = $this->db->get_where('user_sub_menu', [
                    'id_menu'   => 6, // Sesuaikan ID Menu Rekening kamu
                    'is_active' => 1,
                    'parent_id !=' => 0 
                ])->result_array(); 

                foreach($dompet_list as $dl) : 
              ?>
                <option value="<?= $dl['id']; ?>"><?= $dl['title']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>

          <div class="form-group">
            <label>Jumlah Saldo Awal</label>
            <input type="number" name="jumlah" class="form-control" placeholder="Contoh: 500000" required>
          </div>

          <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="tanggal" class="form-control" value="<?= date('Y-m-d'); ?>" required>
          </div>

          <input type="hidden" name="keterangan" value="Saldo Awal">
          <input type="hidden" name="tipe" value="Masuk">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-primary">Simpan Saldo</button>
        </div>
      </form>
    </div>
  </div>
</div>
