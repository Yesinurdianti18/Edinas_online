<?php
include_once('../../config.php');
if (isset($_POST['update'])) {
    $idc = $_POST['id_catatan'];
    $id = $_POST['id_pegawai'];
    $tanggal = $_POST['tanggal_catatan'];
    $jam = $_POST['jam_catatan'];
    $judul = $_POST['judul'];
    $catatan = $_POST['catatan'];

    if ($_FILES['file']['error'] === 4) {
        $nama_file = $_POST['file_lama'];
    } else {
        if (isset($_FILES['file'])) {
            $file = $_FILES['file'];
            $nama_file = $file['name'];
            $file_tmp = $file['tmp_name'];
            $ukuran_file = $file['size'];
            $file_direktori = "../../assets/file_catatan/" . $nama_file;
            $ambil_ekstensi = pathinfo($nama_file, PATHINFO_EXTENSION);
            $ekstensi_diizinkan = ['jpg', 'png', 'jpeg', 'pdf'];
            $max_ukuran_file = 10 * 1024 * 1024;
            move_uploaded_file($file_tmp, $file_direktori);
        }
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($judul)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Judul Catatan Wajib Diisi!";
        }
        if (empty($catatan)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Deskripsi Catatan Wajib Diisi!";
        }
        if ($_FILES['file']['error'] != 4) {
            if (!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Hanya file JPG, JPED, dan PNG yang diperbolehkan!";
            }
            if ($ukuran_file > $max_ukuran_file) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Ukuran file melebihi 10MB!";
            }
        }
        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $result = mysqli_query($connection, "UPDATE catatan_dinas SET judul = '$judul',
            catatan = '$catatan', file = '$nama_file' WHERE id = '$idc'");
            $_SESSION['berhasil'] = "Catatan Berhasil diupdate.";
            header('location: catatan.php');
            exit;
        }
    }
}
