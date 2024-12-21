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
$title = 'Catatan Dinas';
include_once('../../config.php');

// ambil zona waktu
$lokasi_presensi = $_SESSION['lokasi_presensi'];
$result = mysqli_query($connection, "SELECT * FROM lokasi_presensi WHERE nama_lokasi = '$lokasi_presensi'");

while ($lokasi = mysqli_fetch_array($result)) {
    $zona_waktu = $lokasi['zona_waktu'];
}
if ($zona_waktu == "WIB") {
    date_default_timezone_set('Asia/Jakarta');
} elseif ($zona_waktu == "WITA") {
    date_default_timezone_set('Asia/Makassar');
} elseif ($zona_waktu == "WIT") {
    date_default_timezone_set('Asia/Jayapura');
}

$id = $_SESSION['id'];
$result = mysqli_query($connection, "SELECT * FROM catatan_dinas WHERE id_pegawai = '$id' ORDER BY id DESC");

?>
<!-- Page header -->
<div class="page-header">
    <div class="container-xl">
        <div class="row align-items-center">
            <div class="col">
                <!-- <div class="page-pretitle">
          Overview
        </div> -->
                <h2 class="page-title">
                    <span class="" style="background-image: url(...)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-notebook">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" />
                            <path d="M13 8l2 0" />
                            <path d="M13 12l2 0" />
                        </svg>
                    </span>
                    <?= $title ?>
                </h2>
            </div>
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-tambah">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Buat Catatan Dinas
                    </a>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-tambah" aria-label="Create new report">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- Page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <?php if (mysqli_num_rows($result) === 0) { ?>
                <div class="card"></div>
            <?php } else { ?>
                <?php while ($data = mysqli_fetch_array($result)) : ?>
                    <div class="col-md-6 col-lg-3 mb-3">
                        <div class="card">
                            <!-- Photo -->
                            <div class="img-responsive img-responsive-21x9 card-img-top" style="background-image: url(../../assets/file_catatan/<?= $data['file'] ?>)">
                                <h3 class="card-title badge" style="opacity: 70%;"><?= $data['judul'] ?></h3>

                            </div>
                            <div class="card-body">
                                <p class="text-secondary"><?= $data['catatan'] ?></p>
                            </div>
                            <div class="card-footer">
                                <div class="d-flex justify-content-center">
                                    <p class="badge"><?= $data['jam_catatan'] ?></p>
                                    <p class="badge"><?= date('d F Y', strtotime($data['tanggal_catatan'])) ?></p>
                                </div>
                                <div class="btn-list d-flex justify-content-center">
                                    <a href="#" class="btn" name="edit" data-bs-toggle="modal" data-bs-target="#modal-edit<?= $data['id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg>
                                        Edit
                                    </a>
                                    <a href="#" class="btn d-md-inline-flex btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modal-hapus<?= $data['id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-trash">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                        Hapus
                                    </a>
                                </div>
                            </div>
                            <!-- start modal edit -->
                            <div class="modal modal-blur fade" id="modal-edit<?= $data['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Edit Catatan Dinas</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form method="POST" action="edit.php" enctype="multipart/form-data">
                                            <div class="modal-body">
                                                <input type="hidden" value="<?= $_SESSION['id'] ?>" name="id_pegawai">
                                                <input type="hidden" value="<?= $data['id'] ?>" name="id_catatan">
                                                <input type="hidden" name="tanggal_catatan" value="<?= $data['tanggal_catatan'] ?>">
                                                <input type="hidden" name="jam_catatan" value="<?= $data['jam_catatan'] ?>">
                                                <div class="mb-3">
                                                    <a data-fslightbox="gallery" href="../../assets/file_catatan/<?= $data['file'] ?>">
                                                        <div class="img-responsive rounded border" style="background-image: url(../../assets/file_catatan/<?= $data['file'] ?>)"></div>
                                                        <!-- <img src="" height="200" alt=""> -->
                                                    </a>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Judul Catatan</label>
                                                    <input type="text" class="form-control" name="judul" value="<?= $data['judul'] ?>" placeholder="Judul">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi Catatan</label>
                                                    <textarea name="catatan" id="tinymce-mytextarea" class="form-control" data-bs-toggle="autosize" placeholder="Tulis sesuatu…"><?= $data['catatan'] ?></textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="">Unggah File/Foto</label>
                                                    <input type="file" class="form-control" name="file">
                                                    <input type="hidden" class="form-control" name="file_lama" value="<?= $data['file'] ?>">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
                                                    Batal
                                                </a>
                                                <button type="submit" href="#" name="update" class="btn btn-primary ms-auto" data-bs-dismiss="modal">
                                                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                        <path d="M12 5l0 14" />
                                                        <path d="M5 12l14 0" />
                                                    </svg>
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal edit -->
                            <!-- start modal hapus -->
                            <div class="modal modal-blur fade" id="modal-hapus<?= $data['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
                                    <div class="modal-content">
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        <div class="modal-status bg-danger"></div>
                                        <div class="modal-body text-center py-4">
                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                                <path d="M12 9v4" />
                                                <path d="M12 17h.01" />
                                            </svg>
                                            <h3>Apakah kamu yakin??</h3>
                                            <div class="text-secondary">Yakin untuk menghapus catatan <strong><?= $data['judul'] ?></strong> ? Data yang sudah terhapus tidak bisa dikembalikan.</div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="w-100">
                                                <div class="row">
                                                    <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                                            Batal
                                                        </a></div>
                                                    <div class="col"><a href="hapus.php?id=<?= $data['id'] ?>" class="btn btn-danger w-100" data-bs-dismiss="modal">
                                                            Hapus Catatan
                                                        </a></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end modal hapus -->
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Libs JS -->
<script src="../../assets/libs/tinymce/tinymce.min.js?1692870487" defer></script>
<script>
    // @formatter:off
    document.addEventListener("DOMContentLoaded", function() {
        let options = {
            selector: '#tinymce-mytextarea',
            height: 200,
            menubar: false,
            statusbar: false,
            plugins: [
                'advlist autolink lists link image charmap print preview anchor',
                'searchreplace visualblocks code fullscreen',
                'insertdatetime media table paste code help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat',
            content_style: 'body { font-family: -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif; font-size: 14px; -webkit-font-smoothing: antialiased; }'
        }
        if (localStorage.getItem("tablerTheme") === 'dark') {
            options.skin = 'oxide-dark';
            options.content_css = 'dark';
        }
        tinyMCE.init(options);
    })
    // @formatter:on
</script>
<!--  -->
<script>
    $(document).ready(function() {
        // Cek apakah ada parameter 'modal' di URL
        var urlParams = new URLSearchParams(window.location.search);
        var modal = urlParams.get('modal');

        if (modal === 'tambah') {
            // Tampilkan modal
            $('#modal-tambah').modal('show');
        }
    });
</script>
<!--  -->
<?php include('tambah.php') ?>
<?php include('../layout/footer.php') ?>