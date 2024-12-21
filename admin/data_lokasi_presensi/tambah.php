<?php
session_start();
ob_start();
if(!isset($_SESSION["login"])) {
  header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "admin") {
  header("location: ../../auth/login.php?pesan=tolak_akses");
}
$title = "Tambah Lokasi Presensi";
include('../layout/header.php');
require_once('../../config.php'); 
if(isset($_POST['submit'])) {
    $nama_lokasi = htmlspecialchars($_POST['nama_lokasi']);
    $alamat_lokasi = htmlspecialchars($_POST['alamat_lokasi']);
    $tipe_lokasi = htmlspecialchars($_POST['tipe_lokasi']);
    $latitude = htmlspecialchars($_POST['latitude']);
    $longitude = htmlspecialchars($_POST['longitude']);
    $radius = htmlspecialchars($_POST['radius']);
    $zona_waktu = htmlspecialchars($_POST['zona_waktu']);
    $jam_masuk = htmlspecialchars($_POST['jam_masuk']);
    $jam_pulang = htmlspecialchars($_POST['jam_pulang']);

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if(empty($nama_lokasi)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Nama Lokasi Wajib Diisi!";
        }
        if(empty($alamat_lokasi)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Alamat Lokasi Wajib Diisi!";
        }
        if(empty($tipe_lokasi)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Tipe Lokasi Wajib Diisi!";
        }
        if(empty($latitude)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Latitude Wajib Diisi!";
        }
        if(empty($longitude)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Longitude Wajib Diisi!";
        }
        if(empty($radius)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Radius Wajib Diisi!";
        }
        if(empty($zona_waktu)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Zona Waktu Wajib Diisi!";
        }
        if(empty($jam_masuk)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Jam Masuk Wajib Diisi!";
        }
        if(empty($jam_pulang)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Jam Pulang Wajib Diisi!";
        }
        if(!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $result = mysqli_query($connection, "INSERT INTO lokasi_presensi(nama_lokasi, alamat_lokasi, tipe_lokasi, latitude, longitude, radius, zona_waktu, jam_masuk, jam_pulang)
            VALUES('$nama_lokasi', '$alamat_lokasi', '$tipe_lokasi', '$latitude', '$longitude', '$radius', '$zona_waktu', '$jam_masuk', '$jam_pulang') ");
            $_SESSION['berhasil'] = "Data Berhasil Disimpan.";
            header('location: lokasi_presensi.php');
            exit;
        }
    }
}
 ?>

         <!-- Page body -->
         <div class="page-body">
          <div class="container-xl">
          <div class="card col-md-6">
            <div class="card-body">
                <form action="<?= base_url('admin/data_lokasi_presensi/tambah.php') ?>" method="POST">
                    <div class="mb-3">
                        <label for="">Nama Lokasi</label>
                        <input type="text" class="form-control" name="nama_lokasi" value="<?php if(isset($_POST['nama_lokasi'])) echo $_POST['nama_lokasi'] ?>" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Alamat Lokasi</label>
                        <input type="text" class="form-control" name="alamat_lokasi" value="<?php if(isset($_POST['alamat_lokasi'])) echo $_POST['alamat_lokasi'] ?>" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Tipe Lokasi</label>
                        <select name="tipe_lokasi" class="form-control" id="">
                            <option value="">--Pilih Tipe Lokasi--</option>
                            <option <?php if(isset($_POST['tipe_lokasi']) && $_POST['tipe_lokasi'] == 'Kantor' ) {
                                echo 'selected';
                                }?> value="Kantor">Kantor</option>
                            <option <?php if(isset($_POST['tipe_lokasi']) && $_POST['tipe_lokasi'] == 'Lapangan' ) {
                                echo 'selected';
                                }?> value="lapangan">Lapangan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Latitude</label>
                        <input type="text" class="form-control" name="latitude" value="<?php if(isset($_POST['latitude'])) echo $_POST['latitude'] ?>" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Longitude</label>
                        <input type="text" class="form-control" name="longitude" value="<?php if(isset($_POST['longitude'])) echo $_POST['longitude'] ?>" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Radius</label>
                        <input type="number" class="form-control" name="radius" value="<?php if(isset($_POST['radius'])) echo $_POST['radius'] ?>" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Zona Waktu</label>
                        <select name="zona_waktu" class="form-control" id="">
                            <option value="">--Pilih Zona Waktu--</option>
                            <option <?php if(isset($_POST['zona_waktu']) && $_POST['zona_waktu'] == 'WIB' ) {
                                echo 'selected';
                                }?> value="WIB">WIB</option>
                            <option <?php if(isset($_POST['zona_waktu']) && $_POST['zona_waktu'] == 'WITA' ) {
                                echo 'selected';
                                }?> value="WITA">WITA</option>
                            <option <?php if(isset($_POST['zona_waktu']) && $_POST['zona_waktu'] == 'WIT' ) {
                                echo 'selected';
                                }?> value="WIT">WIT</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Jam Masuk</label>
                        <input type="time" class="form-control" name="jam_masuk" value="<?php if(isset($_POST['jam_masuk'])) echo $_POST['jam_masuk'] ?>" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Jam Pulang</label>
                        <input type="time" class="form-control" name="jam_pulang" value="<?php if(isset($_POST['jam_pulang'])) echo $_POST['jam_pulang'] ?>" id="">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary mt-2">Simpan</button>
                </form>
            </div>
            </div>
          </div>
        </div>

        <?php include('../layout/footer.php') ?>
