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
$title = 'Ketidakhadiran';

include_once('../../config.php');

$id = $_SESSION['id'];
$result = mysqli_query($connection, "SELECT * FROM ketidakhadiran WHERE id_pegawai = '$id' ORDER BY id DESC");

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
                    <!-- <span class="d-none d-sm-inline">
                        <a href="#" class="btn">
                            New view
                        </a>
                    </span> -->
                    <a href="<?= base_url('pegawai/ketidakhadiran/pengajuan_ketidakhadiran.php') ?>" class="btn btn-primary d-none d-sm-inline-block">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                        Ajukan Ketidakhadiran
                    </a>
                    <a href="<?= base_url('pegawai/ketidakhadiran/pengajuan_ketidakhadiran.php') ?>" class="btn btn-primary d-sm-none btn-icon">
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

<!-- page body -->
<div class="page-body">
    <div class="container-xl">
        <table class="table table-bordered mt-2">
            <tr class="text-center">
                <th>No.</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Deskripsi</th>
                <th>File</th>
                <th>Status Pengajuan</th>
                <th>Aksi</th>
            </tr>
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
                        <td><?= $data['keterangan'] ?></td>
                        <td><?= $data['deskripsi'] ?></td>
                        <td class="text-center">
                            <a target="_blank" href="<?= base_url('assets/file_ketidakhadiran/' . $data['file']) ?>" class="badge badge-pill bg-primary">Lihat</a>
                        </td>
                        <td class="text-center"><?= $data['status_pengajuan'] ?></td>
                        <td class="text-center">
                            <a href="edit.php?id=<?= $data['id'] ?>" class="badge badge-pill bg-success">Update</a>
                            <a href="hapus.php?id=<?= $data['id'] ?>" class="badge badge-pill bg-danger tombol-hapus">Hapus</a>
                        </td>
                    </tr>
                <?php endwhile; ?>

            <?php } ?>
        </table>

    </div>
</div>

<?php include('../layout/footer.php') ?>