<?php
require_once('../../config.php');
if (isset($_POST['update_foto'])) {
    if ($_FILES['foto']['error'] === UPLOAD_ERR_NO_FILE) {
        $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Anda belum memilih file.";
    } else {
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
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        }
        if ($_FILES['foto']['error'] != 4) {
            if (!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Hanya file JPG, JPED, dan PNG yang diperbolehkan!";
            }
            if ($ukuran_file > $max_ukuran_file) {
                $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Ukuran file melebihi 10MB!";
            } else {
                $id = $_SESSION['id'];
                $user = mysqli_query($connection, "UPDATE pegawai SET
            foto = '$nama_file' WHERE id = '$id' ");
                $_SESSION['berhasil'] = "Foto Profil Berhasil Diubah.";
                $_SESSION['foto'] = $nama_file;
                header('location: setting.php');
                exit;
            }
        }
    }
}

?>
<!-- start modal foto -->
<div class="modal modal-blur fade" id="modal-foto" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah foto Profil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6 col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-control">Masukan File Foto Profile</label>
                                <input type="file" class="form-control" name="foto" id="foto">
                            </div>
                        </div>
                        <div class="col col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-control">Preview Foto</label>
                                <img id="preview_foto" src="#" alt="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Batal
                    </a>
                    <button type="submit" href="#" class="btn btn-primary ms-auto" name="update_foto" data-bs-dismiss="modal">
                        Ubah
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- end modal foto -->