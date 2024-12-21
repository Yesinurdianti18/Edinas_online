<?php
session_start();
if (!isset($_SESSION["login"])) {
  header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "admin") {
  header("location: ../../auth/login.php?pesan=tolak_akses");
}
$title = "Dashboard Admin";
include('../layout/header.php');
$pegawai = mysqli_query($connection, "SELECT pegawai.*, users.status FROM pegawai JOIN users ON pegawai.id = users.id_pegawai WHERE status = 'Aktif'");
$total_pegawai_aktif = mysqli_num_rows($pegawai);
date_default_timezone_set('Asia/Jakarta');
$tanggal_hari_ini = date('Y-m-d');
$kehadiran = mysqli_query($connection, "SELECT * FROM presensi WHERE tanggal_masuk = '$tanggal_hari_ini'");
$total_kehadiran = mysqli_num_rows($kehadiran);
$total_alpa = $total_pegawai_aktif - $total_kehadiran;
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
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-dashboard">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <path d="M12 2.954a10 10 0 0 1 6.222 17.829a1 1 0 0 1 -.622 .217h-11.2a1 1 0 0 1 -.622 -.217a10 10 0 0 1 6.222 -17.829m4.207 5.839a1 1 0 0 0 -1.414 0l-2.276 2.274a2.003 2.003 0 0 0 -2.514 1.815l-.003 .118a2 2 0 1 0 3.933 -.517l2.274 -2.276a1 1 0 0 0 0 -1.414" />
            </svg>
          </span>
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
<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-12">
        <div class="row row-cards">
          <!--  -->
          <div class="col-md-6 col-lg-3">
            <a href="../data_pegawai/pegawai.php" class="card card-link card-link-rotate">
              <div class="card bg-primary text-primary-fg">
                <div class="card-stamp">
                  <div class="card-stamp-icon bg-white text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                      <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    </svg>
                  </div>
                </div>
                <div class="card-body">
                  <h3 class="card-title">Total Pegawai Aktif</h3>
                  <h1><?= $total_pegawai_aktif ?> Pegawai</h1>
                </div>
              </div>
            </a>

          </div>
          <div class="col-md-6 col-lg-3">
            <a href="../data_pegawai/pegawai.php" class="card card-link card-link-rotate">
              <div class="card bg-success text-primary-fg">
                <div class="card-stamp">
                  <div class="card-stamp-icon bg-white text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-check">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                      <path d="M6 21v-2a4 4 0 0 1 4 -4h4" />
                      <path d="M15 19l2 2l4 -4" />
                    </svg>
                  </div>
                </div>
                <div class="card-body">
                  <h3 class="card-title">Total Kehadiran</h3>
                  <h1><?= $total_kehadiran ?> Pegawai</h1>
                </div>
              </div>
            </a>

          </div>
          <div class="col-md-6 col-lg-3">
            <a href="../data_pegawai/pegawai.php" class="card card-link card-link-rotate">
              <div class="card bg-danger text-primary-fg">
                <div class="card-stamp">
                  <div class="card-stamp-icon bg-white text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-x">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                      <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                      <path d="M22 22l-5 -5" />
                      <path d="M17 22l5 -5" />
                    </svg>
                  </div>
                </div>
                <div class="card-body">
                  <h3 class="card-title">Total Alpa</h3>
                  <h1><?= $total_alpa ?> Pegawai</h1>
                </div>
              </div>
            </a>

          </div>
          <div class="col-md-6 col-lg-3">
            <a href="../data_pegawai/pegawai.php" class="card card-link card-link-rotate">
              <div class="card bg-yellow text-primary-fg">
                <div class="card-stamp">
                  <div class="card-stamp-icon bg-white text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user-question">
                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                      <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />
                      <path d="M6 21v-2a4 4 0 0 1 4 -4h3.5" />
                      <path d="M19 22v.01" />
                      <path d="M19 19a2.003 2.003 0 0 0 .914 -3.782a1.98 1.98 0 0 0 -2.414 .483" />
                    </svg>
                  </div>
                </div>
                <div class="card-body">
                  <h3 class="card-title">Total Cuti/Izin/Sakit</h3>
                  <h1>0 Pegawai</h1>
                </div>
              </div>
            </a>
          </div>
          <!--  -->
          <!-- Page header -->
          <div class="page-header">
            <div class="container-xl">
              <div class="row align-items-center">
                <div class="col">
                  <div class="page-pretitle">
                    Overview
                  </div>
                  <h2 class="page-title">
                    Presensi Hari Ini
                  </h2>
                </div>
                <div class="col-auto ms-auto">
                  <div class="btn-list">
                    <a href="../../admin/presensi/lokasi_presensi.php" class="btn btn-primary d-sm-inline-block">
                      <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-map-pin">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" />
                      </svg>
                      Lihat Titik Presensi
                    </a>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card">
              <div class="table-responsive">
                <table
                  class="table table-vcenter card-table">
                  <thead>
                    <tr>
                      <th>Nama</th>
                      <th>Pangkat dan Jabatan</th>
                      <th>Jam Masuk</th>
                      <th>Status Masuk</th>
                      <th class="w-1"></th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $result = mysqli_query($connection, "SELECT presensi.*, pegawai.* FROM presensi JOIN pegawai ON presensi.id_pegawai = pegawai.id WHERE tanggal_masuk = '$tanggal_hari_ini' ORDER BY tanggal_masuk DESC");
                    ?>
                    <?php while ($rekap = mysqli_fetch_array($result)) : ?>
                      <tr>
                        <td data-label="Name">
                          <div class="d-flex py-1 align-items-center">
                            <span class="avatar me-2" style="background-image: url(../../assets/img/foto_pegawai/<?= $rekap['foto'] ?>)"></span>
                            <div class="flex-fill">
                              <div class="font-weight-medium"><?= $rekap['nama'] ?></div>
                              <div class="text-secondary"><a href="#" class="text-reset"><?= $rekap['nip'] ?></a></div>
                            </div>
                          </div>
                        </td>
                        <td data-label="Title">
                          <!-- <div>MAHASANTUY</div> -->
                          <div class="text-secondary text-uppercase"><?= $rekap['jabatan'] ?></div>
                        </td>
                        <td data-label="Role">
                          <?= $rekap['jam_masuk'] ?>
                        </td>
                        <td class="text-secondary" data-label="Role">
                          TEPAT WAKTU
                        </td>
                        <td>
                          <div class="btn-list flex-nowrap">
                            <a href="#" class="btn">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                              </svg>
                              Lihat
                            </a>
                            <a href="#" class="btn">
                              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-brand-whatsapp">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9" />
                                <path d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1" />
                              </svg>
                              Hubungi
                            </a>
                          </div>
                        </td>
                      </tr>
                    <?php endwhile; ?>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('../layout/footer.php') ?>