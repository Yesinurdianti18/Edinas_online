<?php
session_start();
ob_start();
if(!isset($_SESSION["login"])) {
  header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "admin") {
  header("location: ../../auth/login.php?pesan=tolak_akses");
}
$title = "Edit data Pegawai";
include('../layout/header.php');
require_once('../../config.php'); 
if(isset($_POST['submit'])) {
    $id = $_POST['id'];
    $nip = htmlspecialchars($_POST['nip']);
    $nama = htmlspecialchars($_POST['nama']);
    $jenis_kelamin = htmlspecialchars($_POST['jenis_kelamin']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $no_handphone = htmlspecialchars($_POST['no_handphone']);
    $jabatan = htmlspecialchars($_POST['jabatan']);
    $username = htmlspecialchars($_POST['username']);
    // 
    $role = htmlspecialchars($_POST['role']);
    $status = htmlspecialchars($_POST['status']);
    $lokasi_presensi = htmlspecialchars($_POST['lokasi_presensi']);

    if(empty($_POST['password'])) {
        $password =$_POST['password_lama'];
    } else {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }
    if($_FILES['foto']['error'] === 4) {
        $nama_file = $_POST['foto_lama'];
    } else {
        if(isset($_FILES['foto'])) {
            $file = $_FILES['foto'];
            $nama_file = $file['name'];
            $file_tmp = $file['tmp_name'];
            $ukuran_file = $file['size'];
            $file_direktori = "../../assets/img/foto_pegawai/$nama_file";
            $ambil_ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
            $ekstensi_diizinkan = ['jpg', 'png', 'jpeg'];
            $max_ukuran_file = 10 * 1024 * 1024;
            move_uploaded_file($file_tmp, $file_direktori);
        }

    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(empty($nip)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> NRP/NIK Wajib Diisi!";
        }
        if(empty($nama)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Nama Wajib Diisi!";
        }
        if(empty($jenis_kelamin)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Jenis Kelamin Wajib Diisi!";
        }
        if(empty($alamat)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Alamat Wajib Diisi!";
        }
        if(empty($no_handphone)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> No. Handphone Wajib Diisi!";
        }
        if(empty($jabatan)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Jabatan Wajib Diisi!";
        }
        if(empty($status)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Status Akun Wajib Diisi!";
        }
        if(empty($username)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Username Wajib Diisi!";
        }
        if(empty($password)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password Wajib Diisi!";
        }
        if(empty($role)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Role Akun Wajib Diisi!";
        }
        if(empty($lokasi_presensi)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Lokasi Presensi Wajib Diisi!";
        }
        if($_POST['password'] != $_POST['ulangi_password'] ) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password tidak cocok!!";
        }
        if($_FILES['foto']['error'] != 4) {
            if(!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Hanya file JPG, JPED, dan PNG yang diperbolehkan!";
            }
            if($ukuran_file > $max_ukuran_file) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Ukuran file melebihi 10MB!";
            }
        }

        if(!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $pegawai = mysqli_query($connection, "UPDATE pegawai SET
            nip = '$nip',
            nama = '$nama',
            jenis_kelamin = '$jenis_kelamin',
            alamat = '$alamat',
            no_handphone = '$no_handphone',
            jabatan = '$jabatan',
            lokasi_presensi = '$lokasi_presensi',
            foto = '$nama_file'
            WHERE id ='$id' ");

            $user = mysqli_query($connection, "UPDATE users SET
            username = '$username',
            password = '$password',
            status = '$status',
            role = '$role'
            WHERE id_pegawai = '$id' ");


            $_SESSION['berhasil'] = "Data Berhasil Diupdate.";
            header('location: pegawai.php');
            exit;
        }
    }
}
$id = isset($_GET['id']) ? $_GET['id'] : $_POST['id'];
$result = mysqli_query($connection, "SELECT users.id_pegawai, users.username, users.password, users.status, users.role, pegawai.* FROM users JOIN pegawai ON users.id_pegawai = pegawai.id WHERE pegawai.id=$id");

while($pegawai = mysqli_fetch_array($result)) {
    $nip = $pegawai['nip'];
    $nama = $pegawai['nama'];
    $jenis_kelamin = $pegawai['jenis_kelamin'];
    $alamat = $pegawai['alamat'];
    $no_handphone = $pegawai['no_handphone'];
    $jabatan = $pegawai['jabatan'];
    $username = $pegawai['username'];
    $password = $pegawai['password'];
    $status = $pegawai['status'];
    $lokasi_presensi = $pegawai['lokasi_presensi'];
    $role = $pegawai['role'];
    $foto = $pegawai['foto'];
}
?>

         <!-- Page body -->
        <div class="page-body">
            <div class="container-xl">
            <form action="<?= base_url('admin/data_pegawai/edit.php') ?>" method="POST" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-6"> <!-- kiri -->
                        <div class="card">
                            <div class="card-body">                                    
                                    <div class="mb-3">
                                        <label for="">NRP/NIK</label>
                                        <input type="text" class="form-control" name="nip" value="<?= $nip ?>" id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Nama</label>
                                        <input type="text" class="form-control" name="nama" value="<?= $nama ?>" id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Jenis Kelamin</label>
                                        <select name="jenis_kelamin" class="form-control" id="">
                                            <option value="">--Pilih Jenis Kelamin--</option>
                                            <option <?php if($jenis_kelamin == 'Laki-laki' ) {
                                                echo 'selected';
                                                }?> value="Laki-laki">Laki-laki</option>
                                            <option <?php if($jenis_kelamin == 'Perempuan' ) {
                                                echo 'selected';
                                                }?> value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Alamat</label>
                                        <input type="text" class="form-control" name="alamat" value="<?= $alamat ?>" id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">No. Handphone</label>
                                        <input type="text" class="form-control" name="no_handphone" value="<?= $no_handphone ?>" id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Jabatan</label>
                                        <select name="jabatan" class="form-control" id="">
                                            <option value="">--Pilih Jabatan--</option>
                                            <?php
                                            $ambil_jabatan = mysqli_query($connection, "SELECT * FROM jabatan ORDER BY jabatan ASC");
                                            while($row = mysqli_fetch_assoc($ambil_jabatan)) {
                                                $nama_jabatan = $row['jabatan'];
                                                if($jabatan == $nama_jabatan) {
                                                    echo '<option value="' . $nama_jabatan . '" selected="selected">' . $nama_jabatan . '</option>';
                                                } else {
                                                    echo '<option value="' . $nama_jabatan . '">' . $nama_jabatan . '</option>'; 
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Status Akun</label>
                                        <select name="status" class="form-control" id="">
                                            <option value="">--Pilih Status Akun--</option>
                                            <option <?php if($status == 'Aktif' ) {
                                                echo 'selected';
                                                }?> value="Aktif">Aktif</option>
                                            <option <?php if($status == 'Tidak Aktif' ) {
                                                echo 'selected';
                                                }?> value="Tidak Aktif">Tidak Aktif</option>
                                        </select>
                                    </div>
                            </div>
                        </div>    
                    </div>
                    <div class="col-md-6"> <!-- kanan -->
                        <div class="card">
                            <div class="card-body">
                                    <form action="<?= base_url('admin/data_lokasi_presensi/tambah.php') ?>" method="POST">
                                    <div class="mb-3">
                                        <label for="">Username</label>
                                        <input type="text" class="form-control" name="username" value="<?= $username ?>" id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Password</label>
                                        <input type="hidden" name="password_lama" value="<?= $password ?>" id="">
                                        <input type="password" class="form-control" name="password" id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Ulangi Password</label>
                                        <input type="password" class="form-control" name="ulangi_password" id="">
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Role Akun</label>
                                        <select name="role" class="form-control" id="">
                                            <option value="">--Pilih Role Akun--</option>
                                            <option <?php if($role == 'admin' ) {
                                                echo 'selected';
                                                }?> value="admin">Admin</option>
                                            <option <?php if($role == 'pegawai' ) {
                                                echo 'selected';
                                                }?> value="pegawai">Pegawai</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Lokasi Presensi</label>
                                        <select name="lokasi_presensi" class="form-control" id="">
                                            <option value="">--Pilih Lokasi Presensi--</option>
                                            <?php
                                            $ambil_lok_presensi = mysqli_query($connection, "SELECT * FROM lokasi_presensi ORDER BY nama_lokasi ASC");
                                            while($lokasi = mysqli_fetch_assoc($ambil_lok_presensi)) {
                                                $nama_lokasi = $lokasi['nama_lokasi'];
                                                if($lokasi_presensi == $nama_lokasi) {
                                                    echo '<option value="' . $nama_lokasi . '" selected="selected">' . $nama_lokasi . '</option>';
                                                } else {
                                                    echo '<option value="' . $nama_lokasi . '">' . $nama_lokasi . '</option>'; 
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="">Foto Profile</label>
                                        <input type="hidden" name="foto_lama" value="<?= $foto ?>" id="">
                                        <input type="file" class="form-control" name="foto" id="">
                                    </div>

                                    <input type="hidden" name="id" value="<?= $id ?>">
                                    <button type="submit" name="submit" class="btn btn-primary mt-2">Update</button>
                                    </form>
                            </div>
                        </div>    
                    </div>
                </div>    
            </form>
            </div> 
        </div>

        <?php include('../layout/footer.php') ?>
