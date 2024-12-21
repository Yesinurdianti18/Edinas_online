<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "admin") {
    header("location: ../../auth/login.php?pesan=tolak_akses");
}
$title = "Data Catatan Dinas";
include('../layout/header.php');
require_once('../../config.php');
$sql = "SELECT catatan_dinas.*, pegawai.* FROM catatan_dinas JOIN pegawai ON catatan_dinas.id_pegawai = pegawai.id ORDER BY catatan_dinas.id DESC";
$result = mysqli_query($connection, $sql);
?>

<div class="page-body">
    <div class="container-xl">
        <div class="row row-cards">
            <?php if (mysqli_num_rows($result) === 0) { ?>
                <div></div>
            <?php } else { ?>
                <?php
                while ($data = mysqli_fetch_array($result)) : ?>
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card">
                            <div class="card-header">
                                <div>
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <span class="avatar" style="background-image: url(../../assets/img/foto_pegawai/<?= $data['foto'] ?>)"></span>
                                        </div>
                                        <div class="col">
                                            <div class="card-title"><?= $data['nama'] ?></div>
                                            <div class="card-subtitle"><?= $data['jabatan'] ?></div>
                                        </div>
                                    </div>
                                </div>

                            </div>
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
                                    <a href="https://wa.me/62<?= $data['no_handphone'] ?>?text=I%20Love%20You%20%3C3" class="btn" name="hubungi">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                        </svg>
                                        Hubungi
                                    </a>
                                    <a href="#" class="btn d-md-inline-flex btn-outline" data-bs-toggle="modal" data-bs-target="#modal-detail<?= $data['id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg>
                                        Lihat
                                    </a>
                                </div>
                            </div>
                            <!-- start modal edit -->
                            <div class="modal modal-blur fade" id="modal-detail<?= $data['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Detail Catatan Dinas</h5>
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
                                                        <div class="img-responsive img-responsive-21x9 rounded border" style="background-image: url(../../assets/file_catatan/<?= $data['file'] ?>)"></div>
                                                        <!-- <img src="" height="200" alt=""> -->
                                                    </a>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Judul Catatan</label>
                                                    <input type="text" class="form-control" name="judul" value="<?= $data['judul'] ?>" placeholder="Judul" readonly>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">Deskripsi Catatan</label>
                                                    <div name="catatan" id="tinymce-mytextarea" class="form-control" data-bs-toggle="autosize" placeholder="Tulis sesuatu…" readonly><?= $data['catatan'] ?></div>
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
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php } ?>
        </div>
    </div>
</div>


<?php include('../layout/footer.php') ?>