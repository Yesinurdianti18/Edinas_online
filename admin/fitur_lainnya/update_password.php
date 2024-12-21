<?php require_once('../../config.php');
$id = $_SESSION['id'];
// $password = $_SESSION['password'];
if (isset($_POST['update_password'])) {
    $password_baru = password_hash($_POST['password_baru'], PASSWORD_DEFAULT);
    $ulangi_password_baru = password_hash($_POST['ulangi_password_baru'], PASSWORD_DEFAULT);
    $password_lama = password_hash($_POST['password_lama'], PASSWORD_DEFAULT);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST['password_baru'])) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password Wajib Diisi!";
        }
        if (empty($_POST['ulangi_password_baru'])) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Ulangi Password Wajib Diisi!";
        }
        if ($_POST['password_baru'] != $_POST['ulangi_password_baru']) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password tidak cocok!!";
        }
        // if (password_verify($password_lama, $password)) {
        // } else {
        // $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Password sesuai!";
        // }
        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $user = mysqli_query($connection, "UPDATE users SET
password = '$password_baru'
WHERE id_pegawai = '$id' ");
            $_SESSION['berhasil'] = "Password Berhasil Diubah.";
            header('location: setting.php');
            exit;
        }
    }
}

?>
<!-- start modal password -->
<div class="modal modal-blur fade" id="modal-password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Password Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST">
                <!-- <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Password Lama</label>
                                                    <input type="password" class="form-control" name="password_lama" placeholder="">
                                                </div>
                                            </div> -->
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Password Baru</label>
                        <input type="password" class="form-control" name="password_baru" placeholder="">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" class="form-control" name="ulangi_password_baru" placeholder="">
                    </div>
                    <input type="hidden" name="id" value="<?= $id ?>" id="">

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Batal
                    </a>
                    <button href="#" type="submit" name="update_password" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                        Ubah Password
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
<!-- end modal password -->