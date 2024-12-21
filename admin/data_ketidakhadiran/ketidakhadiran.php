<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "admin") {
    header("location: ../../auth/login.php?pesan=tolak_akses");
}
$title = "Data Ketidakhadiran";
include('../layout/header.php');
require_once('../../config.php');
$sql = "SELECT ketidakhadiran.*, pegawai.nama FROM ketidakhadiran JOIN pegawai ON ketidakhadiran.id_pegawai = pegawai.id";
$result = mysqli_query($connection, $sql);
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
                    <?= $title ?>
                </h2>
            </div>
            <!-- <div class="col-auto ms-auto">
                <div class="btn-list">
                    <span class="d-none d-sm-inline">
                        <a href="#" class="btn">
                            New view
                        </a>
                    </span>
                    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Create new report
                    </a>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Create new report">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </a>
                </div>
            </div> -->
        </div>
    </div>

</div>

<!-- page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="table-responsive">
            <table id="myTable" class="nowrap table table-striped hover">
                <thead>
                    <tr class="text-center">
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Keterangan</th>
                        <th>Deskripsi</th>
                        <th>File</th>
                        <th>Status Pengajuan</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) === 0) { ?>
                        <tr>
                            <td colspan="7">Data Ketidakhadiran Masih Kosong.</td>
                        </tr>
                    <?php } else { ?>
                        <?php $no = 1;
                        while ($data = mysqli_fetch_array($result)) : ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= date('d F Y', strtotime($data['tanggal'])) ?></td>
                                <td><?= $data['nama'] ?></td>
                                <td><?= $data['keterangan'] ?></td>
                                <td><?= $data['deskripsi'] ?></td>
                                <td class="text-center">
                                    <a target="_blank" href="<?= base_url('assets/file_ketidakhadiran/' . $data['file']) ?>" class="badge badge-pill bg-primary">Lihat</a>
                                </td>
                                <td class="text-center">
                                    <?php if ($data['status_pengajuan'] == 'PENDING') : ?>
                                        <a class="badge badge-pill bg-warning" href="<?= base_url('admin/data_ketidakhadiran/detail.php?id=' . $data['id']) ?>">PENDING</a>
                                    <?php elseif ($data['status_pengajuan'] == 'REJECTED') : ?>
                                        <a class="badge badge-pill bg-danger" href="<?= base_url('admin/data_ketidakhadiran/detail.php?id=' . $data['id']) ?>">REJECTED</a>
                                    <?php else : ?>
                                        <a class="badge badge-pill bg-success" href="<?= base_url('admin/data_ketidakhadiran/detail.php?id=' . $data['id']) ?>">APPROVED</a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>



<?php include('../layout/footer.php') ?>