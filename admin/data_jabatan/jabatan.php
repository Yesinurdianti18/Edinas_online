<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "admin") {
  header("location: ../../auth/login.php?pesan=tolak_akses");
}
$title = "Data Jabatan";
include('../layout/header.php');
require_once('../../config.php');

$result = mysqli_query($connection, "SELECT * FROM jabatan ORDER BY id DESC");

?>
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
      </div>
    </div>
  </div>

</div>
<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <a href="<?= base_url('admin/data_jabatan/tambah.php') ?>" class="btn btn-primary"><span class="text"><i class="fa-solid fa-circle-plus"></i> Tambah Data</span></a>

    <div class="row row-deck row-cards mt-2">
      <table id="myTable" class="nowrap table table-striped hover">
        <thead>
          <tr class="text-center">
            <th>No.</th>
            <th>Nama Jabatan</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (mysqli_num_rows($result) === 0) : ?>
            <tr>
              <td colspan="3">Data masih kosong, silahkan tambah data baru</td>
            </tr>
          <?php else : ?>
            <?php $no = 1;
            while ($jabatan = mysqli_fetch_array($result)) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= $jabatan['jabatan'] ?></td>
                <td class="text-center">
                  <a href="<?= base_url('admin/data_jabatan/edit.php?id=' . $jabatan['id']) ?>" class="badge bg-primary badge-pill">Edit</a>
                  <a href="<?= base_url('admin/data_jabatan/hapus.php?id=' . $jabatan['id']) ?>" class="badge bg-danger badge-pill tombol-hapus">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include('../layout/footer.php') ?>