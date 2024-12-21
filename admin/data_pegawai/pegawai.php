<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "admin") {
    header("location: ../../auth/login.php?pesan=tolak_akses");
}
$title = "Data Pegawai";
include('../layout/header.php');
require_once('../../config.php');

$result = mysqli_query($connection, "SELECT users.id_pegawai, users.username, users.password, users.status, users.role, pegawai.* FROM users JOIN pegawai ON users.id_pegawai = pegawai.id");
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
            <div class="col-auto ms-auto">
                <div class="btn-list">
                    <a href="<?= base_url('admin/data_pegawai/tambah.php') ?>" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Data Pegawai
                    </a>
                    <a href="<?= base_url('admin/data_pegawai/tambah.php') ?>" class="btn btn-primary d-sm-none btn-icon" aria-label="Tambah Data Pegawai">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </a>
                    <!-- <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-report">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Tambah Data Pegawai
                    </a>
                    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-report" aria-label="Tambah Data Pegawai">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </a> -->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- page body -->
<div class="page-body">
    <div class="container-xl">
        <!-- <a href="<?= base_url('admin/data_pegawai/tambah.php') ?>" class="btn btn-primary"><span class="text"><i class="fa-solid fa-circle-plus"></i> Tambah Data</span></a> -->
        <div class="row row-deck row-cards mt-2">
            <div class="table-responsive">
                <table id="myTable" class="nowrap table table-striped hover">
                    <thead>
                        <tr class="text-center">
                            <th>No.</th>
                            <th>NRP/NIK</th>
                            <th>Nama</th>
                            <th>Pangkat</th>
                            <th>Jabatan</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (mysqli_num_rows($result) === 0) { ?>
                            <tr>
                                <td colspan="7">Data Kosong, silahkan tambahkan data baru.</td>
                            </tr>
                        <?php } else { ?>
                            <?php $no = 1;
                            while ($pegawai = mysqli_fetch_array($result)) : ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= $pegawai['nip'] ?></td>
                                    <td><?= $pegawai['nama'] ?></td>
                                    <td>AIPTU</td>
                                    <td><?= $pegawai['jabatan'] ?></td>
                                    <td><?= $pegawai['username'] ?></td>
                                    <td><?= $pegawai['role'] ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/data_pegawai/detail.php?id=' . $pegawai['id']) ?>" class="badge badge-pill bg-primary">Detail</a>
                                        <a href="<?= base_url('admin/data_pegawai/edit.php?id=' . $pegawai['id']) ?>" class="badge badge-pill bg-primary">Edit</a>
                                        <a href="<?= base_url('admin/data_pegawai/hapus.php?id=' . $pegawai['id']) ?>" class="badge badge-pill bg-danger tombol-hapus">Hapus</a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php include('../layout/footer.php') ?>