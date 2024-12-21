<?php
ob_start();
session_start();
if (!isset($_SESSION["login"])) {
    header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "admin") {
    header("location: ../../auth/login.php?pesan=tolak_akses");
}
$title = 'Rekap Presensi Bulanan';
include('../layout/header.php');
include_once('../../config.php');

if (empty($_GET['filter_bulan'])) {
    $bulan_sekarang = date('Y-m');
    $result = mysqli_query($connection, "SELECT presensi.*, pegawai.nama, pegawai.lokasi_presensi FROM presensi JOIN pegawai ON presensi.id_pegawai = pegawai.id
    WHERE DATE_FORMAT(tanggal_masuk, '%Y-%m') = '$bulan_sekarang' ORDER BY tanggal_masuk DESC");
} else {
    $filter_tahun_bulan = $_GET['filter_tahun'] . '-' . $_GET['filter_bulan'];
    $result = mysqli_query($connection, "SELECT presensi.*, pegawai.nama, pegawai.lokasi_presensi FROM presensi JOIN pegawai
    ON presensi.id_pegawai = pegawai.id WHERE DATE_FORMAT(tanggal_masuk, '%Y-%m') = '$filter_tahun_bulan' ORDER BY tanggal_masuk DESC");
}

if (empty($_GET['filter_bulan'])) {
    $bulan = date('Y-m');
} else {
    $bulan = $_GET['filter_tahun'] . '-' . $_GET['filter_bulan'];
}



// $lokasi_presensi = $_SESSION['lokasi_presensi'];
// $lokasi = mysqli_query($connection, " SELECT * FROM lokasi_presensi WHERE nama_lokasi = '$lokasi_presensi'");
// while($lokasi_result = mysqli_fetch_array($lokasi)) {
//     $jam_masuk_kantor = date('H:i:s', strtotime($lokasi_result['jam_masuk']));
// }
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
        <div class="row">
            <div class="col-md-10">
                <form method="GET" action="">
                    <div class="input-group">
                        <select name="filter_bulan" class="form-control" id="">
                            <option value="">--Pilih Bulan--</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                        <select name="filter_tahun" class="form-control" id="">
                            <option value="">--Pilih Tahun--</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <option value="2026">2026</option>
                        </select>

                        <button type="submit" class="btn btn-primary">Tampilkan</button>
                    </div>
                </form>
            </div>
        </div>
        <span>Rekap Presensi Bulan : <?= date('F Y', strtotime($bulan)) ?></span>
        <div class="table-responsive">
            <table id="myTable" class="nowrap table table-striped hover">
                <thead>
                    <tr class="text-center">
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Tanggal</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Total Jam</th>
                        <th>Total Terlambat</th>
                    </tr>
                </thead>
                <tbody>
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
                            // start opsi session to db

                            $lokasi_presensi = $rekap['lokasi_presensi'];
                            $lokasi = mysqli_query($connection, " SELECT * FROM lokasi_presensi WHERE nama_lokasi = '$lokasi_presensi'");
                            while ($lokasi_result = mysqli_fetch_array($lokasi)) {
                                $jam_masuk_kantor = date('H:i:s', strtotime($lokasi_result['jam_masuk']));
                            }
                            // end opsi session to db
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
                                <td><?= $no++ ?></td>
                                <td><?= $rekap['nama'] ?></td>
                                <td><?= date('d F Y', strtotime($rekap['tanggal_masuk'])) ?></td>
                                <td class="text-center"><?= $rekap['jam_masuk'] ?></td>
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
                                    <span class="badge bg-success">ON TIME</span>
                                <?php else : ?>
                                    <?= $total_jam_terlambat . ' Jam ' . $selisih_menit_terlambat . ' Menit' ?>
                            </td>
                        <?php endif; ?>
                            </tr>
                        <?php endwhile; ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- modal -->
<div class="modal" id="exampleModal" tabindex="-1">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci animi beatae delectus deleniti dolorem eveniet facere fuga iste nemo nesciunt nihil odio perspiciatis, quia quis reprehenderit sit tempora totam unde.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
            </div>
        </div>
    </div>
</div>

<?php include('../layout/footer.php') ?>