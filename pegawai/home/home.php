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
$judul = 'Home';
include_once('../../config.php');

$lokasi_presensi = $_SESSION['lokasi_presensi'];
$result = mysqli_query($connection, "SELECT * FROM lokasi_presensi WHERE nama_lokasi = '$lokasi_presensi'");

while ($lokasi = mysqli_fetch_array($result)) {
  $latitude_kantor = $lokasi['latitude'];
  $longitude_kantor = $lokasi['longitude'];
  $radius = $lokasi['radius'];
  $zona_waktu = $lokasi['zona_waktu'];
  $jam_masuk_kantor = date('H:i:s', strtotime($lokasi['jam_masuk']));
  $jam_masuk = $lokasi['jam_masuk'];
  $jam_pulang = $lokasi['jam_pulang'];
}
if ($zona_waktu == "WIB") {
  date_default_timezone_set('Asia/Jakarta');
} elseif ($zona_waktu == "WITA") {
  date_default_timezone_set('Asia/Makassar');
} elseif ($zona_waktu == "WIT") {
  date_default_timezone_set('Asia/Jayapura');
}
?>
<!-- page header -->
<div class="page-header">
  <div class="container-xl">
    <div class="row align-items-center">
      <div class="col-auto">
        <span class="avatar avatar-lg rounded-circle" style="background-image: url(../../assets/img/foto_pegawai/<?= $_SESSION['foto'] ?>); border: 3px solid white"></span>
      </div>
      <div class="col">
        <div class="page-pretitle">
          Selamat datang
        </div>
        <h2 class="page-title"><?= $_SESSION['nama'] ?></h2>
        <div class="page-subtitle">
          <div class="row">
            <div class="col-auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-briefcase">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M3 7m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" />
                <path d="M8 7v-2a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v2" />
                <path d="M12 12l0 .01" />
                <path d="M3 13a20 20 0 0 0 18 0" />
              </svg>
              <a href="#" class="text-reset"><?= $_SESSION['jabatan'] ?></a>
            </div>
            <div class="col-auto">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-id">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M3 4m0 3a3 3 0 0 1 3 -3h12a3 3 0 0 1 3 3v10a3 3 0 0 1 -3 3h-12a3 3 0 0 1 -3 -3z" />
                <path d="M9 10m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                <path d="M15 8l2 0" />
                <path d="M15 12l2 0" />
                <path d="M7 16l10 0" />
              </svg>
              <a href="#" class="text-reset"><?= $_SESSION['nip'] ?></a>
            </div>
            <!-- <div class="col-auto text-success">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                <path d="M5 12l5 5l10 -10"></path>
              </svg>
              
            </div> -->
          </div>
        </div>
      </div>
      <div class="col-auto d-none d-md-flex">
        <a href="../../pegawai/catatan_dinas/catatan.php?modal=tambah" class="btn btn-primary">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-notebook">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M6 4h11a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-11a1 1 0 0 1 -1 -1v-14a1 1 0 0 1 1 -1m3 0v18" />
            <path d="M13 8l2 0" />
            <path d="M13 12l2 0" />
          </svg>
          Buat Catatan
        </a>
      </div>
    </div>
  </div>

</div>


<!-- Page body -->
<div class="page-body">
  <div class="container-xl">
    <div class="row row-cards">
      <div class="col-md-12 col-lg-12">
        <div class="card bg-primary text-primary-fg">
          <div class="card-stamp">
            <div class="card-stamp-icon bg-white text-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-fingerprint">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M18.9 7a8 8 0 0 1 1.1 5v1a6 6 0 0 0 .8 3" />
                <path d="M8 11a4 4 0 0 1 8 0v1a10 10 0 0 0 2 6" />
                <path d="M12 11v2a14 14 0 0 0 2.5 8" />
                <path d="M8 15a18 18 0 0 0 1.8 6" />
                <path d="M4.9 19a22 22 0 0 1 -.9 -7v-1a8 8 0 0 1 12 -6.95" />
              </svg>
            </div>
          </div>
          <div class="card-body">
            <div class="row row-cards">
              <div class="col-md-12 col-lg-4">
                <h3 class="card-title">Hari ini <b id="tanggal_realtime"></b> </h3>
                <p class="badge bg-yellow text-light" id="">Jangan Lupa absen tepat waktu!</p>
                <h3 class=""><i class="fa-solid fa-clock fa-lg"></i>
                  <?= date('H:i', strtotime($jam_masuk))  . '-' . date('H:i', strtotime($jam_pulang)) ?></h3>
              </div>
              <!-- Presensi Masuk -->
              <div class="col-md-6 col-lg-4">
                <?php
                $id_pegawai = $_SESSION['id'];
                $tanggal_hari_ini = date('Y-m-d');
                $cek_presensi_masuk = mysqli_query($connection, "SELECT * FROM presensi WHERE id_pegawai = '$id_pegawai' AND tanggal_masuk = '$tanggal_hari_ini'");
                ?>
                <?php if (mysqli_num_rows($cek_presensi_masuk) === 0) { ?>
                  <form id="form_masuk" method="POST" action="<?= base_url('pegawai/presensi/presensi_masuk.php') ?>">
                    <input type="hidden" value="" name="latitude_pegawai" id="latitude_pegawai">
                    <input type="hidden" value="" name="longitude_pegawai" id="longitude_pegawai">
                    <input type="hidden" value="<?= $latitude_kantor ?>" name="latitude_kantor" id="">
                    <input type="hidden" value="<?= $longitude_kantor ?>" name="longitude_kantor" id="">
                    <input type="hidden" value="<?= $radius ?>" name="radius" id="">
                    <input type="hidden" value="<?= $zona_waktu ?>" name="zona_waktu" id="">
                    <input type="hidden" value="<?= date("y-m-d") ?>" name="tanggal_masuk" id="">
                    <input type="hidden" value="<?= date("H:i:s") ?>" name="jam_masuk" id="">
                    <a href="#" onclick="tombolMasuk();" class="card card-link card-link-pop">
                      <div class="card-body text-body ">
                        <div class="row">
                          <!-- <div class="col-2 d-flex align-items-center bg-success rounded-circle">
                          <i class="fa-solid fa-fingerprint fa-rotate-90 fa-2x text-light"></i>
                        </div> -->
                          <div class="col-2">
                            <button type="submit" name="tombol_masuk" id="tombol_masuk" class="btn btn-success rounded-circle" style="width: 50px; height: 50px;">
                              <i class="fa-solid fa-fingerprint  fa-2x text-light"></i>
                            </button>
                          </div>
                          <div class="ms-3 col-6 d-xl-block ps-2">
                            <div><b>MASUK</b></div>
                            <div class="medium text-secondary" id="jam_realtime"></div>
                          </div>
                        </div>
                      </div>
                    </a>
                  </form>
                <?php } else { ?>
                  <a href="#" class="card card-link card-link-pop">
                    <div class="card-body text-body ">
                      <div class="row">
                        <!-- <div class="col-2 d-flex align-items-center  rounded-circle" style="width: 50px; height: 50px;">
                        <i class="fa-solid fa-circle-check fa-3x text-success"></i>
                      </div> -->
                        <div class="col-2">
                          <button type="submit" name="tombol_masuk" id="tombol_masuk" class="btn btn-success rounded-circle" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-check fa-beat fa-2x"></i>
                            <!-- <i class="fa-regular fa-circle-check fa-3x text-light"></i> -->
                            <!-- <i class="fa-solid fa-fingerprint  fa-2x text-light"></i> -->
                          </button>
                        </div>
                        <div class="ms-3 col-6 d-xl-block ps-2">
                          <div><b>MASUK PADA</b></div>
                          <?php
                          $id_pegawai = $_SESSION['id'];
                          $tanggal_hari_ini = date('Y-m-d');
                          $hasil = mysqli_query($connection, "SELECT * FROM presensi WHERE id_pegawai = '$id_pegawai' AND tanggal_masuk = '$tanggal_hari_ini'");
                          while ($data = mysqli_fetch_array($hasil)) :
                          ?>
                            <div class="medium text-secondary"><?= $data['jam_masuk'] ?></div>
                          <?php endwhile; ?>
                        </div>
                      </div>
                    </div>
                  </a>
                <?php } ?>
              </div>
              <!--  -->
              <!-- Presensi Keluar -->
              <div class="col-md-6 col-lg-4">
                <?php $ambil_data_presensi = mysqli_query($connection, "SELECT * FROM presensi WHERE id_pegawai = '$id_pegawai' AND tanggal_masuk = '$tanggal_hari_ini'") ?>
                <?php
                $waktu_sekarang = date('H:i:s');

                if (strtotime($waktu_sekarang) <= strtotime($jam_masuk) && mysqli_num_rows($ambil_data_presensi) == 0) { ?>
                  <a href="#" onclick="tombolKeluar();" class="card card-link card-link-pop">
                    <div class="card-body text-body ">
                      <div class="row">
                        <div class="col-2">
                          <button type="submit" name="tombol_keluar" id="tombol_keluar" class="btn btn-warning rounded-circle" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-exclamation fa-beat fa-2x"></i>
                          </button>
                        </div>
                        <div class="ms-3 col-8 d-xl-block ps-2">
                          <div><b>SILAHKAN PRESENSI MASUK TERLEBIH DAHULU</b></div>
                          <div class="medium text-secondary" id=""></div>
                        </div>
                      </div>
                    </div>
                  </a>

                <?php } elseif (strtotime($waktu_sekarang) >= strtotime($jam_masuk) && mysqli_num_rows($ambil_data_presensi) == 0) { ?>
                  <a href="#" onclick="tombolKeluar();" class="card card-link card-link-pop">
                    <div class="card-body text-body ">
                      <div class="row">
                        <div class="col-2">
                          <button type="submit" name="tombol_keluar" id="tombol_keluar" class="btn btn-warning rounded-circle" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-exclamation fa-beat fa-2x"></i>
                          </button>
                        </div>
                        <div class="ms-3 col-8 d-xl-block ps-2">
                          <div><b>[TELAT] SILAHKAN PRESENSI MASUK TERLEBIH DAHULU</b></div>
                          <div class="medium text-secondary" id=""></div>
                        </div>
                      </div>
                    </div>
                  </a>

                <?php } elseif (strtotime($waktu_sekarang) <= strtotime($jam_pulang)) { ?>
                  <a href="#" onclick="tombolKeluar();" class="card card-link card-link-pop">
                    <div class="card-body text-body ">
                      <div class="row">
                        <div class="col-2">
                          <button type="submit" name="tombol_keluar" id="tombol_keluar" class="btn btn-warning rounded-circle" style="width: 50px; height: 50px;">
                            <i class="fa-regular fa-hourglass-half fa-spin fa-2x"></i>
                          </button>
                        </div>
                        <div class="ms-3 col-8 d-xl-block ps-2">
                          <div><b>BELUM WAKTUNYA PULANG</b></div>
                          <div class="medium text-secondary" id=""></div>
                        </div>
                      </div>
                    </div>
                  </a>

                <?php } elseif (strtotime($waktu_sekarang) >= strtotime($jam_pulang) && mysqli_num_rows($ambil_data_presensi) == 0) { ?>
                  <a href="#" onclick="tombolKeluar();" class="card card-link card-link-pop">
                    <div class="card-body text-body ">
                      <div class="row">
                        <div class="col-2">
                          <button type="submit" name="tombol_keluar" id="tombol_keluar" class="btn btn-warning rounded-circle" style="width: 50px; height: 50px;">
                            <i class="fa-solid fa-exclamation fa-beat fa-2x"></i>
                          </button>
                        </div>
                        <div class="ms-3 col-8 d-xl-block ps-2">
                          <div><b>SILAHKAN PRESENSI MASUK TERLEBIH DAHULU</b></div>
                          <div class="medium text-secondary" id=""></div>
                        </div>
                      </div>
                    </div>
                  </a>



                <?php } else { ?>
                  <?php while ($cek_presensi_keluar = mysqli_fetch_array($ambil_data_presensi)) { ?>
                    <?php if (($cek_presensi_keluar['tanggal_masuk']) && $cek_presensi_keluar['tanggal_keluar'] == '0000-00-00') {
                    ?>
                      <form method="POST" action="<?= base_url('pegawai/presensi/presensi_keluar.php') ?>">
                        <input type="hidden" value="<?= $cek_presensi_keluar['id'] ?>" name="id" id="">
                        <input type="hidden" value="" name="latitude_pegawai" id="latitude_pegawai">
                        <input type="hidden" value="" name="longitude_pegawai" id="longitude_pegawai">
                        <input type="hidden" value="<?= $latitude_kantor ?>" name="latitude_kantor" id="">
                        <input type="hidden" value="<?= $longitude_kantor ?>" name="longitude_kantor" id="">
                        <input type="hidden" value="<?= $radius ?>" name="radius" id="">
                        <input type="hidden" value="<?= $zona_waktu ?>" name="zona_waktu" id="">
                        <input type="hidden" value="<?= date("y-m-d") ?>" name="tanggal_keluar" id="">
                        <input type="hidden" value="<?= date("H:i:s") ?>" name="jam_keluar" id="">
                        <a href="#" onclick="tombolKeluar();" class="card card-link card-link-pop">
                          <div class="card-body text-body ">
                            <div class="row">
                              <div class="col-2">
                                <button type="submit" name="tombol_keluar" id="tombol_keluar" class="btn btn-warning rounded-circle" style="width: 50px; height: 50px;">
                                  <i class="fa-solid fa-fingerprint  fa-2x text-light"></i>
                                </button>
                              </div>
                              <div class="ms-2 col-6 d-xl-block ps-2">
                                <div><b>KELUAR</b></div>
                                <div class="medium text-secondary" id="jam_realtime"></div>
                              </div>
                            </div>
                          </div>
                        </a>
                      </form>
                    <?php } else { ?>
                      <a href="#" class="card card-link card-link-pop">
                        <div class="card-body text-body ">
                          <div class="row">
                            <div class="col-2">
                              <button type="submit" name="tombol_masuk" id="tombol_masuk" class="btn btn-success rounded-circle" style="width: 50px; height: 50px;">
                                <i class="fa-solid fa-check fa-beat fa-2x"></i>
                              </button>
                            </div>
                            <div class="ms-3 col-6 d-xl-block ps-2">
                              <div><b>KELUAR PADA</b></div>
                              <?php
                              $id_pegawai = $_SESSION['id'];
                              $tanggal_hari_ini = date('Y-m-d');
                              $hasil = mysqli_query($connection, "SELECT * FROM presensi WHERE id_pegawai = '$id_pegawai' AND tanggal_masuk = '$tanggal_hari_ini'");
                              while ($data = mysqli_fetch_array($hasil)) :
                              ?>
                                <div class="medium text-secondary"><?= $data['jam_keluar'] ?></div>
                              <?php endwhile; ?>
                            </div>
                          </div>
                        </div>
                      </a>
                    <?php } ?>
                  <?php } ?>
                <?php } ?>
              </div>
              <!--  -->

            </div>
          </div>
        </div>
      </div>
      <!-- Page header -->
      <div class="page-header">
        <div class="container-xl">
          <div class="row align-items-center">
            <div class="col">
              <div class="page-pretitle">
                Overview
              </div>
              <h2 class="page-title">
                Riwayat Presensi
              </h2>
            </div>
            <!-- <div class="col-auto ms-auto">
              <div class="btn-list">
                <a href="../../admin/presensi/lokasi_presensi.php" class="btn btn-primary d-sm-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-map-pin">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" />
                  </svg>
                  Lihat Titik Presensi
                </a>
              </div>
            </div> -->
          </div>
        </div>
      </div>
      <div class="col-md-8 col-lg-12">
        <div class="card">
          <div class="table-responsive">
            <table
              class="table table-vcenter card-table">
              <thead>
                <tr>
                  <th>Tanggal</th>
                  <th>Jam Masuk</th>
                  <th>Jam Pulang</th>
                  <th>Status Presensi</th>
                  <th class="w-1"></th>
                </tr>
              </thead>
              <tbody>
                <?php
                $id = $_SESSION['id'];
                $result = mysqli_query($connection, "SELECT * FROM presensi WHERE id_pegawai = '$id' ORDER BY tanggal_masuk DESC");
                // $result = mysqli_query($connection, "SELECT presensi.*, pegawai.* FROM presensi JOIN pegawai ON presensi.id_pegawai = pegawai.id WHERE tanggal_masuk = '$tanggal_hari_ini' ORDER BY tanggal_masuk DESC");
                ?>
                <?php while ($rekap = mysqli_fetch_array($result)) : ?>
                  <tr>
                    <td data-label="Name">
                      <?= date('d F Y', strtotime($rekap['tanggal_masuk'])) ?>
                    </td>
                    <td data-label="Title">
                      <div class="d-flex py-1 align-items-center">
                        <span class="avatar me-2" style="background-image: url(../presensi/foto/<?= $rekap['foto_masuk'] ?>)"></span>
                        <div class="flex-fill">
                          <div class="font-weight-medium"><?= $rekap['jam_masuk'] ?></div>
                        </div>
                      </div>
                    </td>
                    <td data-label="Title">
                      <div class="d-flex py-1 align-items-center">
                        <span class="avatar me-2" style="background-image: url(../../assets/img/foto_pegawai/<?= $rekap['foto_keluar'] ?>)"></span>
                        <div class="flex-fill">
                          <div class="font-weight-medium"><?= $rekap['jam_keluar'] ?></div>
                        </div>
                      </div>
                    </td>
                    <?php
                    // hitung total jam terlambat
                    $jam_masuk = date('H:i:s', strtotime($rekap['jam_masuk']));
                    $timestamp_jam_masuk_real = strtotime($jam_masuk);
                    $timestamp_jam_masuk_kantor = strtotime($jam_masuk_kantor);
                    $terlambat = $timestamp_jam_masuk_real - $timestamp_jam_masuk_kantor;
                    $total_jam_terlambat = floor($terlambat / 3600);
                    $terlambat -= $total_jam_terlambat * 3600;
                    $selisih_menit_terlambat = floor($terlambat / 60);
                    ?>
                    <td class="text-secondary" data-label="Role">
                      <?php if ($total_jam_terlambat < 0): ?>
                        <span class="badge bg-success text-light">TEPAT WAKTU</span>
                      <?php else : ?>
                        <span class="badge bg-warning text-light">
                          Terlambat <?= $total_jam_terlambat . ' Jam ' . $selisih_menit_terlambat . ' Menit' ?>
                        </span>
                      <?php endif; ?>

                    </td>
                    <td>
                      <div class="btn-list flex-nowrap">
                        <a href="#" class="btn" data-bs-toggle="modal" data-bs-target="#modal-lihatpresensi<?= $rekap['id'] ?>">
                          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                          </svg>
                          Lihat
                        </a>
                        <!-- start modal lihat -->
                        <div class="modal modal-blur fade" id="modal-lihatpresensi<?= $rekap['id'] ?>" tabindex="-1" role="dialog" aria-hidden="true">
                          <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h5 class="modal-title">Detail Presensi <?= date('d F Y', strtotime($rekap['tanggal_masuk'])) ?>
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <div class="modal-body">
                                <div class="row">
                                  <div class="col">
                                    <table>
                                      <thead>
                                        <tr>
                                          <th colspan="3">PRESENSI MASUK</th>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <img class="w-100 rounded" src="../presensi/foto/<?= $rekap['foto_masuk'] ?>" alt="">
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Jam</td>
                                          <td>:</td>
                                          <td>
                                            <?= $rekap['jam_masuk'] ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Titik Lokasi</td>
                                          <td>:</td>
                                          <td>
                                            <?= $rekap['latitude_masuk'] ?> / <?= $rekap['longitude_masuk'] ?>
                                          </td>
                                        </tr>
                                      </thead>
                                    </table>
                                  </div>
                                  <div class="col">
                                    <table>
                                      <thead>
                                        <tr>
                                          <th colspan="3">PRESENSI KELUAR</th>
                                        </tr>
                                        <tr>
                                          <td colspan="3">
                                            <img class="w-100 rounded" src="../presensi/foto/<?= $rekap['foto_keluar'] ?>" alt="">
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Jam</td>
                                          <td>:</td>
                                          <td>
                                            <?= $rekap['jam_keluar'] ?>
                                          </td>
                                        </tr>
                                        <tr>
                                          <td>Titik Lokasi</td>
                                          <td>:</td>
                                          <td>
                                            <?= $rekap['latitude_keluar'] ?> / <?= $rekap['longitude_keluar'] ?>
                                          </td>
                                        </tr>
                                      </thead>
                                    </table>
                                  </div>
                                </div>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Selesai</button>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- end modal lihat -->

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


  <script>
    // set waktu
    window.setTimeout("waktuMasuk()", 1000);
    arrbulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

    function waktuMasuk() {
      const waktu = new Date();
      setTimeout("waktuMasuk()", 1000);
      document.getElementById("tanggal_realtime").innerHTML = waktu.getDate() + ' ' + arrbulan[waktu.getMonth()] + ' ' + waktu.getFullYear();
      document.getElementById("jam_realtime").innerHTML = waktu.getHours() + ':' + waktu.getMinutes() + ':' + waktu.getSeconds();
    }

    // ambil lokasi
    getLocation();

    function getLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
      } else {
        alert("Browser Tidak mendukung lokasi.");
      }
    }

    function showPosition(position) {
      $('#latitude_pegawai').val(position.coords.latitude)
      $('#longitude_pegawai').val(position.coords.longitude)
    }

    function tombolMasuk() {
      document.getElementById('tombol_masuk').click();
    }
  </script>
  <?php include('../layout/footer.php') ?>