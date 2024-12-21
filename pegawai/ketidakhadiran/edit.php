<?php
ob_start();
session_start();
if (!isset($_SESSION["login"])) {
    header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "pegawai") {
    //   header("location: ../../auth/login.php?pesan=tolak_akses");
    include('../../admin/layout/header.php');
} else {
    include('../layout/header.php');
}
$judul = 'Edit Pengajuan Ketidakhadiran';

include_once('../../config.php');

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $keterangan = $_POST['keterangan'];
    $tanggal = $_POST['tanggal'];
    $deskripsi = $_POST['deskripsi'];


    if ($_FILES['file_baru']['error'] === 4) {
        $file_lama = $_POST['file_lama'];
    } else {
        $file = $_FILES['file_baru'];
        $nama_file = $file['name'];
        $file_tmp = $file['tmp_name'];
        $ukuran_file = $file['size'];
        $file_direktori = "../../assets/file_ketidakhadiran/" . $nama_file;
        $ambil_ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
        $ekstensi_diizinkan = ['jpg', 'png', 'jpeg', 'pdf'];
        $max_ukuran_file = 10 * 1024 * 1024;
        move_uploaded_file($file_tmp, $file_direktori);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($keterangan)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Keterangan Wajib Diisi!";
        }
        if (empty($tanggal)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Tanggal Wajib Diisi!";
        }
        if (empty($deskripsi)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Deskripsi Wajib Diisi!";
        }

        if ($_FILES['file_baru']['error'] !== 4) {
            if (!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Hanya file PDF, JPG, JPED, dan PNG yang diperbolehkan!";
            }
            if ($ukuran_file > $max_ukuran_file) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Ukuran file melebihi 10MB!";
            }
        }


        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $result = mysqli_query($connection, "UPDATE ketidakhadiran SET keterangan = '$keterangan',
            deskripsi = '$deskripsi', tanggal = '$tanggal', file = '$nama_file' WHERE id=$id");

            $_SESSION['berhasil'] = "Data Berhasil Di Update.";
            header('location: ketidakhadiran.php');
            exit;
        }
    }
}

$id = $_GET['id'];
$result = mysqli_query($connection, "SELECT * FROM ketidakhadiran WHERE id = $id");
while ($data = mysqli_fetch_array($result)) {
    $keterangan = $data['keterangan'];
    $deskripsi = $data['deskripsi'];
    $tanggal = $data['tanggal'];
    $file = $data['file'];
}
?>
<div class="page-body">
    <div class="container-xl">
        <div class="card col-md-6">
            <div class="card-body">
                <form method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" value="<?= $_SESSION['id'] ?>" name="id_pegawai">
                    <div class="mb-3">
                        <label for="">Keterangan</label>
                        <select name="keterangan" class="form-control" id="">
                            <option value="">--Pilih Keterangan--</option>
                            <option <?php if ($keterangan == 'Cuti') {
                                        echo 'selected';
                                    } ?> value="Cuti">Cuti</option>
                            <option <?php if ($keterangan == 'Izin') {
                                        echo 'selected';
                                    } ?> value="Izin">Izin</option>
                            <option <?php if ($keterangan == 'Sakit') {
                                        echo 'selected';
                                    } ?> value="Sakit">Sakit</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" id="" cols="30" rows="5"><?= $deskripsi ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="">Tanggal</label>
                        <input type="date" class="form-control" name="tanggal" value="<?= $tanggal ?>">
                    </div>
                    <div class="mb-3">
                        <label for="">Surat Keterangan</label>
                        <input type="file" class="form-control" name="file_baru">
                        <input type="hidden" class="form-control" name="file_lama" value="<?= $file ?>">
                    </div>
                    <input type="hidden" value="<?= $_GET['id']; ?>" name="id">

                    <button type="submit" class="btn btn-primary" name="update">Update</button>
                </form>
            </div>
        </div>


    </div>
</div>

<?php include('../layout/footer.php') ?>