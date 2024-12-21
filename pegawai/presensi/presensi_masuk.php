<!-- webcam js -->
<script
  src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"
  integrity="sha512-dQIiHSl2hr3NWKKLycPndtpbh5iaHLo6MwrXm7F0FM5e+kL2U16oE9uIwPHUl6fQBeCthiEuV/rzP3MiAB8Vfw=="
  crossorigin="anonymous"
  referrerpolicy="no-referrer"></script>
<!-- leaflet js -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
  integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
  crossorigin="" />
<!-- Make sure you put this AFTER Leaflet's CSS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
  integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
  crossorigin=""></script>
<style>
  #map {
    height: 300px;
    border-radius: 10px;
  }

  #my_camera {
    transform: scaleX(-1);
    border-radius: 15px;
  }
</style>

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
include_once('../../config.php');

if (isset($_POST['tombol_masuk'])) {
  $latitude_pegawai = $_POST['latitude_pegawai'];
  $longitude_pegawai = $_POST['longitude_pegawai'];
  $latitude_kantor = $_POST['latitude_kantor'];
  $longitude_kantor = $_POST['longitude_kantor'];
  $radius = $_POST['radius'];
  $zona_waktu = $_POST['zona_waktu'];
  $tanggal_masuk = $_POST['tanggal_masuk'];
  $jam_masuk = $_POST['jam_masuk'];
}

if (empty($latitude_pegawai) || empty($longitude_pegawai)) {
  $_SESSION['gagal'] = "Presensi Masuk Gagal, Lokasi/GPS anda belum aktif.";
  header('location: ../home/home.php');
  exit;
}
if (empty($latitude_kantor) || empty($longitude_kantor)) {
  $_SESSION['gagal'] = "Presensi Masuk Gagal, Koordinat Kantor belum di Setting.";
  header('location: ../home/home.php');
  exit;
}

$perbedaan_koordinat = $longitude_pegawai - $longitude_kantor;
$jarak = sin(deg2rad($latitude_pegawai)) * sin(deg2rad($latitude_kantor)) + cos(deg2rad($latitude_pegawai)) * cos(deg2rad($latitude_kantor)) * cos(deg2rad($perbedaan_koordinat));
$jarak = acos($jarak);
$jarak = rad2deg($jarak);
$mil = $jarak * 60 * 1.1515;
$jarak_km = $mil * 1.609344;
$jarak_meter = $jarak_km * 1000;

?>

<?php if ($jarak_meter > $radius) { ?>
  <?=
  $_SESSION['gagal'] = "Anda berda diluar area Kantor, jarak anda dari kantor $jarak_meter meter.";
  header('location: ../home/home.php');
  exit;
  ?>
<?php } else { ?>

  <div class="page-body">
    <div class="container-xl">
      <div class="row">
        <div class="col-md-6">
          <dic class="card text-center">
            <div class="card-body" style="margin: auto;">
              <input type="hidden" name="" id="id" value="<?= $_SESSION['id'] ?>">
              <input type="hidden" name="" id="tanggal_masuk" value="<?= $tanggal_masuk ?>">
              <input type="hidden" name="" id="jam_masuk" value="<?= $jam_masuk ?>">
              <input type="hidden" name="" id="latitude_masuk" value="<?= $latitude_pegawai ?>">
              <input type="hidden" name="" id="longitude_masuk" value="<?= $longitude_pegawai ?>">
              <div id="my_camera" class=""></div>
              <div id="my_result"></div>
              <div><?= date('d F Y', strtotime($tanggal_masuk)) . ' - ' . $jam_masuk ?></div>
              <button class="btn btn-success mt-2 w-80" id="ambil-foto">
                <i class="fa-solid fa-fingerprint fa-2x text-light me-2"></i>
                PRESENSI MASUK</button>
            </div>
        </div>
        <div class="col-md-6">
          <div class="card">
            <div class="card-body">
              <p>Anda berada sejauh <b><?= number_format($jarak_meter, 0, ',', '.')  ?> Meter</b> dari Titik Lokasi Presensi</p>
              <div id="map"></div>
            </div>
          </div>
        </div>

      </div>
      </dic>
    </div>
  </div>

  <script language="JavaScript">
    Webcam.set({
      width: 240,
      height: 320,
      dest_width: 480,
      dest_height: 640,
      image_format: 'jpeg',
      jpeg_quality: 100,
      force_flash: false
    });
    Webcam.attach("#my_camera");

    document.getElementById("ambil-foto").addEventListener("click", function() {
      let id = document.getElementById('id').value;
      let tanggal_masuk = document.getElementById('tanggal_masuk').value;
      let jam_masuk = document.getElementById('jam_masuk').value;
      let latitude_masuk = document.getElementById('latitude_masuk').value;
      let longitude_masuk = document.getElementById('longitude_masuk').value;
      Webcam.snap(function(data_uri) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          document.getElementById("my_result").innerHTML = '<img src="' + data_uri + '"/>';
          if (xhttp.readyState == 4 && xhttp.status == 200) {
            window.location.href = "../home/home.php";
          }
        };
        xhttp.open("POST", "presensi_masuk_aksi.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(
          'photo=' + encodeURIComponent(data_uri) +
          '&id=' + id +
          '&tanggal_masuk=' + tanggal_masuk +
          '&jam_masuk=' + jam_masuk +
          '&latitude_masuk=' + latitude_masuk +
          '&longitude_masuk=' + longitude_masuk
        );
      });
    });

    // map leafletjs
    let latitude_ktr = <?= $latitude_kantor ?>;
    let longitude_ktr = <?= $longitude_kantor ?>;
    let radius_presensi = <?= $radius ?>;
    let latitude_peg = <?= $latitude_pegawai ?>;
    let longitude_peg = <?= $longitude_pegawai ?>;

    let map = L.map('map').setView([latitude_peg, longitude_peg], 11);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = L.marker([latitude_ktr, longitude_ktr]).addTo(map).bindPopup("<b>Lokasi Presensi.").openPopup();
    var marker = L.marker([latitude_peg, longitude_peg]).addTo(map).bindPopup("<b>Lokasi anda saat ini.").openPopup();

    var circle = L.circle([latitude_ktr, longitude_ktr], {
      color: 'red',
      fillColor: '#f03',
      fillOpacity: 0.1,
      radius: radius_presensi
    }).addTo(map);
  </script>
<?php } ?>

<?php include('../layout/footer.php') ?>