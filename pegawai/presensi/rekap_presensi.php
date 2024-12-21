<?php
ob_start();
session_start();
if (!isset($_SESSION["login"])) {
    header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "pegawai") {
    // header("location: ../../auth/login.php?pesan=tolak_akses");
    include('../../admin/layout/header.php');
} else {
    include('../layout/header.php');
}
$title = 'Rekap Presensi';
include_once('../../config.php');

if (empty($_GET['tanggal_dari'])) {
    $id = $_SESSION['id'];
    $result = mysqli_query($connection, "SELECT * FROM presensi WHERE id_pegawai = '$id' ORDER BY tanggal_masuk DESC");
} else {
    $id = $_SESSION['id'];
    $tanggal_dari = $_GET['tanggal_dari'];
    $tanggal_sampai = $_GET['tanggal_sampai'];
    $result = mysqli_query($connection, "SELECT * FROM presensi WHERE id_pegawai = '$id' AND tanggal_masuk BETWEEN '$tanggal_dari' AND '$tanggal_sampai' ORDER BY tanggal_masuk DESC");
}



$lokasi_presensi = $_SESSION['lokasi_presensi'];
$lokasi = mysqli_query($connection, " SELECT * FROM lokasi_presensi WHERE nama_lokasi = '$lokasi_presensi'");

while ($lokasi_result = mysqli_fetch_array($lokasi)) {
    $jam_masuk_kantor = date('H:i:s', strtotime($lokasi_result['jam_masuk']));
}

?>
<!-- page header -->
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
                    <form method="GET" action="">
                        <div class="input-group">
                            <input type="date" class="form-control" name="tanggal_dari">
                            <input type="date" class="form-control" name="tanggal_sampai">
                            <button type="submit" class="btn btn-primary">Tampilkan</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</div>
<!-- page body -->
<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-5">
            </div>
        </div>
        <div class="table-responsive">
            <table id="myTable" class="nowrap table table-striped hover">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Total Jam Kerja</th>
                        <th>Status Presensi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php if (mysqli_num_rows($result) === 0) { ?>
                    <tr>
                        <td colspan="6">Data Presensi Masih kosong.</td>
                    </tr>
                <?php } else { ?>
                    <?php $no = 1;
                            while ($rekap = mysqli_fetch_array($result)) :
                                // hitung total jam kerja
                                $jam_tanggal_masuk = date('Y-m-d H:i:s', strtotime($rekap['tanggal_masuk'] . '' . $rekap['jam_masuk']));
                                $jam_tanggal_keluar = date('Y-m-d H:i:s', strtotime($rekap['tanggal_keluar'] . '' . $rekap['jam_keluar']));
                                $timestamp_masuk = strtotime($jam_tanggal_masuk);
                                $timestamp_keluar = strtotime($jam_tanggal_keluar);
                                $selisih = $timestamp_keluar - $timestamp_masuk;
                                $total_jam_kerja = floor($selisih / 3600);
                                $selisih -= $total_jam_kerja * 3600;
                                $selisih_menit_kerja = floor($selisih / 60);

                                // hitung total jam terlambat
                                $jam_masuk = date('H:i:s', strtotime($rekap['jam_masuk']));
                                $timestamp_jam_masuk_real = strtotime($jam_masuk);
                                $timestamp_jam_masuk_kantor = strtotime($jam_masuk_kantor);
                                $terlambat = $timestamp_jam_masuk_real - $timestamp_jam_masuk_kantor;
                                $total_jam_terlambat = floor($terlambat / 3600);
                                $terlambat -= $total_jam_terlambat * 3600;
                                $selisih_menit_terlambat = floor($terlambat / 60);

                    ?>
                        <tr>
                            <td class="text-center"><?= $no++ ?></td>
                            <td><?= date('d F Y', strtotime($rekap['tanggal_masuk'])) ?></td>
                            <td class=" text-center"><?= $rekap['jam_masuk'] ?></td>
                            <td class="text-center"><?= $rekap['jam_keluar'] ?></td>
                            <td class="text-center">
                                <?php if ($rekap['tanggal_keluar'] == '0000-00-00') : ?>
                                    <span class="">0 Jam 0 Menit</span>
                                <?php else : ?>
                                    <?= $total_jam_kerja . ' Jam ' . $selisih_menit_kerja . ' Menit' ?>
                            </td>
                        <?php endif; ?>
                        <td class="text-center">
                            <?php if ($total_jam_terlambat < 0): ?>
                                <span class="badge bg-success text-light">TEPAT WAKTU</span>
                            <?php else : ?>
                                Terlambat <?= $total_jam_terlambat . ' Jam ' . $selisih_menit_terlambat . ' Menit' ?>
                        </td>
                    <?php endif; ?>

                        </tr>
                    <?php endwhile; ?>
                <?php } ?>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>
<?php include('../layout/footer.php') ?>