<?php
ob_start();
session_start();
if (!isset($_SESSION["login"])) {
    header("location: ../../auth/login.php?pesan=belum_login");
}
//  else if ($_SESSION["role"] != "admin") {
//     header("location: ../../auth/login.php?pesan=tolak_akses");
// }
include('../layout/header.php');
require_once('../../config.php');
$id = $_SESSION['id'];
$result = mysqli_query($connection, "SELECT * FROM users JOIN pegawai ON users.id_pegawai = pegawai.id WHERE pegawai.id = $id");
while ($row = mysqli_fetch_array($result)) {
    $foto = $row["foto"];
    $username = $row["username"];
}
?>

<!-- Page header -->
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-2 align-items-center">
            <div class="col">
                <h2 class="page-title">
                    Pengaturan Akun
                </h2>
            </div>
        </div>
    </div>
</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="row g-0">
                <!-- <div class="col-12 col-md-3 border-end">
                    <div class="card-body">
                        <h4 class="subheader">Business settings</h4>
                        <div class="list-group list-group-transparent">
                            <a href="./settings.html" class="list-group-item list-group-item-action d-flex align-items-center active">My Account</a>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">My Notifications</a>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">Connected Apps</a>
                            <a href="./settings-plan.html" class="list-group-item list-group-item-action d-flex align-items-center">Plans</a>
                            <a href="#" class="list-group-item list-group-item-action d-flex align-items-center">Billing & Invoices</a>
                        </div>
                        <h4 class="subheader mt-4">Experience</h4>
                        <div class="list-group list-group-transparent">
                            <a href="#" class="list-group-item list-group-item-action">Give Feedback</a>
                        </div>
                    </div>
                </div> -->
                <div class="col-12 col-md-9 d-flex flex-column">
                    <div class="card-body">
                        <h2 class="mb-4">Akun Saya</h2>
                        <h3 class="card-title">Detail Profil</h3>
                        <div class="row align-items-center">
                            <div class="col-auto"><span class="avatar avatar-xl" style="background-image: url(../../assets/img/foto_pegawai/<?= $foto ?>)"></span>
                            </div>
                            <div class="col-auto"><a type="submit" name="tombol_foto" href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal-foto">
                                    Ubah Foto
                                </a></div>
                            <!-- <div class="col-auto"><a href="#" class="btn btn-ghost-danger">
                                    Hapus Foto
                                </a></div> -->

                        </div>
                        <h3 class="card-title mt-4">Username</h3>
                        <p class="card-subtitle">Username ini digunakan ketika Login masuk ke Website eDinas untuk melakukan Presensi Kehadiran.</p>
                        <div>
                            <form action="" method="post">
                                <div class="row g-2">
                                    <div class="col-auto">
                                        <input type="text" class="form-control w-auto" name="username" value="<?= $username ?>">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" name="update_username" href="#" class="btn">
                                            Ubah
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <h3 class="card-title mt-4">Password</h3>
                        <p class="card-subtitle">Password ini digunakan ketika Login masuk ke Website eDinas untuk melakukan Presensi Kehadiran.</p>
                        <div>
                            <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal-password">
                                Ubah Password Baru
                            </a>
                        </div>
                    </div>
                    <div class="card-footer bg-transparent mt-auto">
                        <div class="btn-list justify-content-end">
                            <!-- <a href="#" class="btn">
                                Batal
                            </a> -->
                            <a href="../home/home.php" class="btn btn-primary">
                                Selesai
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    const inputFoto = document.getElementById('foto');
    const previewFoto = document.getElementById('preview_foto');
    inputFoto.addEventListener('change', () => {
        const file = inputFoto.files[0];
        if (file) {
            const reader = new FileReader();

            reader.onload = (e) => {
                previewFoto.src = e.target.result;
            };

            reader.readAsDataURL(file);
        } else {
            previewFoto.src = "#";
        }
    });
</script>
<?php include('update_username.php') ?>
<?php include('update_foto.php') ?>
<?php include('update_password.php') ?>
<?php include('../layout/footer.php') ?>