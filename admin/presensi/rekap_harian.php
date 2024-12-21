<?php
ob_start();
session_start();
if (!isset($_SESSION["login"])) {
  header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "admin") {
  header("location: ../../auth/login.php?pesan=tolak_akses");
}
$title = 'Rekap Presensi Harian';
include('../layout/header.php');
include_once('../../config.php');

if (empty($_GET['tanggal_dari'])) {
  $tanggal_hari_ini = date('Y-m-d');
  $result = mysqli_query($connection, "SELECT presensi.*, pegawai.nama, pegawai.lokasi_presensi FROM presensi JOIN pegawai ON presensi.id_pegawai = pegawai.id 
    WHERE tanggal_masuk = '$tanggal_hari_ini' ORDER BY tanggal_masuk DESC");
} else {
  $tanggal_dari = $_GET['tanggal_dari'];
  $tanggal_sampai = $_GET['tanggal_sampai'];
  $result = mysqli_query($connection, "SELECT presensi.*, pegawai.nama, pegawai.lokasi_presensi FROM presensi JOIN pegawai ON presensi.id_pegawai = pegawai.id WHERE tanggal_masuk BETWEEN '$tanggal_dari' AND '$tanggal_sampai' ORDER BY tanggal_masuk DESC");
}
if (empty($_GET['tanggal_dari'])) {
  $tanggal = date('Y-m-d');
} else {
  $tanggal = $_GET['tanggal_dari'] . '-' . $_GET['tanggal_sampai'];
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
      <div class="col-auto ms-auto">
        <div class="btn-list">
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

<!-- page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row">
      <div class="col-md-2">
        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#exampleModal">
          Export Excel
        </button>

      </div>
      <div class="col-md-10">
        <form method="GET" action="">
          <div class="input-group">
            <input type="date" class="form-control" name="tanggal_dari">
            <input type="date" class="form-control" name="tanggal_sampai">
            <button type="submit" class="btn btn-primary">Tampilkan</button>
          </div>
        </form>
      </div>
    </div>

    <?php if (empty($_GET['tanggal_dari'])) : ?>
      <span>Rekap Presensi Tanggal : <?= date('d F Y', strtotime($tanggal)) ?></span>
    <?php else : ?>
      <span>Rekap Presensi Tanggal : <?= date('d F Y', strtotime($_GET['tanggal_dari'])) . ' sampai ' . date('d F Y', strtotime($_GET['tanggal_sampai'])) ?></span>
    <?php endif; ?>
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

<?php include('../layout/footer.php') ?>