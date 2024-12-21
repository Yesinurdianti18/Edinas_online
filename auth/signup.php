<?php
session_start();
require_once('../config.php') ?>

<?php

if (isset($_POST['submit'])) {
    $nip = htmlspecialchars($_POST['nip']);
    $nama = htmlspecialchars($_POST['nama']);
    // $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    // $alamat = htmlspecialchars($_POST['alamat']);
    // $no_handphone = htmlspecialchars($_POST['no_handphone']);
    // $jabatan = htmlspecialchars($_POST['jabatan']);
    $username = htmlspecialchars($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = htmlspecialchars($_POST['role']);
    $status = htmlspecialchars($_POST['status']);
    $lokasi_presensi = htmlspecialchars($_POST['lokasi_presensi']);

    // if (isset($_FILES['foto'])) {
    //     $file = $_FILES['foto'];
    //     $nama_file = $file['name'];
    //     $file_tmp = $file['tmp_name'];
    //     $ukuran_file = $file['size'];
    //     $file_direktori = "../../assets/img/foto_pegawai/" . $nama_file;
    //     $ambil_ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
    //     $ekstensi_diizinkan = ['jpg', 'png', 'jpeg'];
    //     $max_ukuran_file = 10 * 1024 * 1024;
    //     move_uploaded_file($file_tmp, $file_direktori);
    // }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($nip)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> NRP/NIK Wajib Diisi!";
        }
        if (!empty($nip)) {
            $checknip = mysqli_query($connection, "SELECT * FROM pegawai WHERE nip='$nip'");
            if (mysqli_num_rows($checknip) > 0) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Nomor Identitas sudah didaftarkan!";
            }
        }
        if (empty($nama)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Nama Wajib Diisi!";
        }
        // if (empty($jenis_kelamin)) {
        //     $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Jenis Kelamin Wajib Diisi!";
        // }
        // if (empty($alamat)) {
        //     $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Alamat Wajib Diisi!";
        // }
        // if (empty($no_handphone)) {
        //     $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> No. Handphone Wajib Diisi!";
        // }
        // if (empty($jabatan)) {
        //     $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Jabatan Wajib Diisi!";
        // }
        if (empty($status)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Status Akun Wajib Diisi!";
        }
        if (empty($username)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Username Wajib Diisi!";
        }
        if (!empty($username)) {
            $checkuname = mysqli_query($connection, "SELECT * FROM users WHERE username='$username'");
            if (mysqli_num_rows($checkuname) > 0) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Username Sudah dipakai!";
            }
        }
        if (empty($password)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password Wajib Diisi!";
        }
        if (empty($role)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Role Akun Wajib Diisi!";
        }
        if (empty($lokasi_presensi)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Lokasi Presensi Wajib Diisi!";
        }
        if ($_POST['password'] != $_POST['ulangi_password']) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password tidak cocok!!";
        }
        // if (!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)) {
        //     $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Hanya file JPG, JPEG, dan PNG yang diperbolehkan!";
        // }
        // if ($ukuran_file > $max_ukuran_file) {
        //     $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Ukuran file melebihi 10MB!";
        // }
        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $pegawai = mysqli_query($connection, "INSERT INTO pegawai(nip, nama, jenis_kelamin, alamat, no_handphone, jabatan, lokasi_presensi, foto)
            VALUES('$nip', '$nama', '$alamat', '$jenis_kelamin', '$no_handphone', '$jabatan', '$lokasi_presensi', '$nama_file') ");

            $id_pegawai = mysqli_insert_id($connection);

            $user = mysqli_query($connection, "INSERT INTO users(id_pegawai, username, password, status, role)
            VALUES('$id_pegawai', '$username', '$password', '$status', '$role') ");


            $_SESSION['berhasil'] = "Akun Berhasil Dibuat!";
            header('location: login.php');
            exit;
        }
    }
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Register Akun - eDinas</title>
    <link rel="icon" href="../assets/img/logo5.png" type="image/png" sizes="64x64">
    <!-- CSS files -->
    <link href="<?= base_url('assets/css/tabler.min.css?1692870487') ?>" rel="stylesheet" />
    <!-- <link href="<?= base_url('assets/css/tabler-flags.min.css?1692870487') ?>" rel="stylesheet" /> -->
    <!-- <link href="<?= base_url('assets/css/tabler-payments.min.css?1692870487') ?>" rel="stylesheet" /> -->
    <link href="<?= base_url('assets/css/tabler-vendors.min.css?1692870487') ?>" rel="stylesheet" />
    <link href="<?= base_url('assets/css/demo.min.css?1692870487') ?>" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
            background-image: url(../assets/img/423-image.png);
        }
    </style>
</head>

<body class=" d-flex flex-column">
    <script src="<?= base_url('assets/js/demo-theme.min.js?1692870487') ?>"></script>
    <div class="page page-center">
        <div class="container container-tight py-4">
            <div class="text-center mb-4">
                <a href="." class="navbar-brand">
                    <img src="../assets/img/logo2.png" width="110" height="32" alt="Tabler" class="navbar-brand-image">
                </a>
            </div>
            <form class="card card-md" action="" method="POST" autocomplete="off" novalidate>
                <div class="card-body">
                    <input type="hidden" name="status" value="Aktif" id="">
                    <input type="hidden" name="role" value="pegawai" id="">
                    <input type="hidden" name="lokasi_presensi" value="Horizon University" id="">
                    <h2 class="card-title text-center mb-4">Buat Akun baru</h2>
                    <div class="mb-3">
                        <label class="form-label">Nomor Identitas</label>
                        <input type="text" class="form-control" name="nip" placeholder="Masukan NPM atau sejenisnya">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama" placeholder="Masukan Nama">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="email" class="form-control" name="username" placeholder="Username">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Ulangi Password</label>
                        <div class="input-group input-group-flat">
                            <input type="password" class="form-control" name="ulangi_password" placeholder="Ulangi Password" autocomplete="off">
                            <span class="input-group-text">
                                <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                        <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                    </svg>
                                </a>
                            </span>
                        </div>
                    </div>
                    <!-- <div class="mb-3">
                        <label class="form-check">
                            <input type="checkbox" class="form-check-input" />
                            <span class="form-check-label">Agree the <a href="./terms-of-service.html" tabindex="-1">terms and policy</a>.</span>
                        </label>
                    </div> -->
                    <div class="form-footer">
                        <button type="submit" name="submit" class="btn btn-primary w-100">Buat Akun Baru</button>
                        <div class="text-center text-secondary mt-3">
                            Sudah Punya Akun? <a href="login.php" tabindex="-1">Log In</a>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="<?= base_url('assets/js/tabler.min.js?1692870487') ?>" defer></script>
    <script src="<?= base_url('assets/js/demo.min.js?1692870487') ?>" defer></script>

    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Alert validasi gagal -->
    <?php if (isset($_SESSION['validasi'])) : ?>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Toast.fire({
                icon: "error",
                title: "<?= $_SESSION['validasi'] ?>"
            });
        </script>
        <?php unset($_SESSION['validasi']) ?>
    <?php endif; ?>

    <!-- Alert validasi berhasil -->
    <?php if (isset($_SESSION['berhasil'])) : ?>
        <script>
            const Berhasil = Swal.mixin({
                toast: true,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer;
                    toast.onmouseleave = Swal.resumeTimer;
                }
            });
            Berhasil.fire({
                icon: "success",
                title: "<?= $_SESSION['berhasil'] ?>"
            });
        </script>
        <?php unset($_SESSION['berhasil']) ?>
    <?php endif; ?>
</body>

</html>