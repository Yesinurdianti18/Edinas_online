<?php
if (isset($_POST['submit'])) {
    $id = $_POST['id_pegawai'];
    $tanggal = $_POST['tanggal_catatan'];
    $jam = $_POST['jam_catatan'];
    $judul = $_POST['judul'];
    $catatan = $_POST['catatan'];

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

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($judul)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Judul Catatan Wajib Diisi!";
        }
        if (empty($catatan)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Deskripsi Catatan Wajib Diisi!";
        }
        if (!in_array(strtolower($ambil_ekstensi), $ekstensi_diizinkan)) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Hanya file PDF, JPG, JPED, dan PNG yang diperbolehkan!";
        }
        if ($ukuran_file > $max_ukuran_file) {
            $pesan_kesalahan[] = "<i class='fa-solid fa-check'></i> Ukuran file melebihi 10MB!";
        }
        if (!empty($pesan_kesalahan)) {
            $_SESSION['validasi'] = implode("<br>", $pesan_kesalahan);
        } else {
            $result = mysqli_query($connection, "INSERT INTO catatan_dinas(id_pegawai, tanggal_catatan, jam_catatan, judul, catatan, file)
            VALUES('$id', '$tanggal', '$jam', '$judul', '$catatan', '$nama_file') ");

            $_SESSION['berhasil'] = "Catatan Berhasil Dibuat.";
            header('location: catatan.php');
            exit;
        }
    }
}

$id = $_SESSION['id'];
$result = mysqli_query($connection, "SELECT * FROM catatan_dinas WHERE id_pegawai = '$id' ORDER BY id DESC");
?>

<div class="modal modal-blur fade" id="modal-tambah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buat Catatan Dinas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" value="<?= $_SESSION['id'] ?>" name="id_pegawai">
                    <input type="hidden" name="tanggal_catatan" value="<?= date('Y-m-d') ?>">
                    <input type="hidden" name="jam_catatan" value="<?= date('H:i:s') ?>">
                    <div class="mb-3">
                        <label class="form-label">Judul Catatan</label>
                        <input type="text" class="form-control" name="judul" placeholder="Judul">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Deskripsi Catatan</label>
                        <textarea name="catatan" id="tinymce-mytextarea" class="form-control" data-bs-toggle="autosize" placeholder="Tulis sesuatu…"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="">Unggah File/Foto</label>
                        <input type="file" class="form-control" name="file">
                    </div>

                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                        Batal
                    </a>
                    <button type="submit" href="#" name="submit" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                        <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                        Kirim
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>