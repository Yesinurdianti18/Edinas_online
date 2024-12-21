<?php require_once('../../config.php');
$id = $_SESSION['id'];

if (isset($_POST['update_username'])) {
    $username_baru = $_POST['username'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['username'])) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Username wajib Diisi!";
        }
        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $user = mysqli_query($connection, "UPDATE users SET
username = '$username_baru'
WHERE id_pegawai = '$id' ");
            $_SESSION['berhasil'] = "Username Berhasil Diubah.";
            header('location: setting.php');
            exit;
        }
    }
}
