<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <h1>My Profile</h1>
        </div>
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="<?= base_url('assets/adminlte/img/profile/') . $user['foto']; ?>"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center"><?= $user['nama']; ?></h3>
                            <p class="text-muted text-center">Pengguna Sistem Keuangan</p>

                            <ul class="list-group list-group-unbordered mb-3">
                                <li class="list-group-item">
                                    <b>Username</b> <a class="float-right text-primary"><?= $user['username']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>No WhatsApp</b> <a class="float-right text-primary"><?= $user['no_wa']; ?></a>
                                </li>
                                <li class="list-group-item">
                                    <b>ID User</b> <a class="float-right text-primary"><?= $user['id']; ?></a>
                                </li>
                            </ul>

                            <a href="<?= base_url('user/edit_profile'); ?>" class="btn btn-primary btn-block"><b>Edit Profile</b></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>