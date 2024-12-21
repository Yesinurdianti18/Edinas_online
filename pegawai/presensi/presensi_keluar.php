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
$judul = 'Presensi Keluar';

include_once('../../config.php');

if (isset($_POST['tombol_keluar'])) {
  $id = $_POST['id'];
  $latitude_pegawai = $_POST['latitude_pegawai'];
  $longitude_pegawai = $_POST['longitude_pegawai'];
  $latitude_kantor = $_POST['latitude_kantor'];
  $longitude_kantor = $_POST['longitude_kantor'];
  $radius = $_POST['radius'];
  $zona_waktu = $_POST['zona_waktu'];
  $tanggal_keluar = $_POST['tanggal_keluar'];
  $jam_keluar = $_POST['jam_keluar'];
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
  $_SESSION['gagal'] = "Anda berda diluar area Kantor";
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
              <input type="hidden" name="" id="id" value="<?= $id ?>">
              <input type="hidden" name="" id="tanggal_keluar" value="<?= $tanggal_keluar ?>">
              <input type="hidden" name="" id="jam_keluar" value="<?= $jam_keluar ?>">
              <input type="hidden" name="" id="latitude_keluar" value="<?= $latitude_pegawai ?>">
              <input type="hidden" name="" id="longitude_keluar" value="<?= $longitude_pegawai ?>">
              <div id="my_camera"></div>
              <div id="my_result"></div>
              <div><?= date('d F Y', strtotime($tanggal_keluar)) . ' - ' . $jam_keluar ?></div>
              <button class="btn btn-warning mt-2 w-80" id="ambil-foto">
                <i class="fa-solid fa-fingerprint fa-2x text-light me-2"></i>
                PRESENSI KELUAR</button>
            </div>
        </div>
        <div class="col-md-6">
          <dic class="card">
            <div class="card-body">
              <p>Anda berada sejauh <b><?= number_format($jarak_meter, 0, ',', '.')  ?> Meter</b> dari Titik Lokasi Presensi</p>
              <div id="map"></div>
            </div>
          </dic>
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
      let tanggal_keluar = document.getElementById('tanggal_keluar').value;
      let jam_keluar = document.getElementById('jam_keluar').value;
      let latitude_keluar = document.getElementById('latitude_keluar').value;
      let longitude_keluar = document.getElementById('longitude_keluar').value;
      Webcam.snap(function(data_uri) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          document.getElementById("my_result").innerHTML = '<img src="' + data_uri + '"/>';
          if (xhttp.readyState == 4 && xhttp.status == 200) {
            window.location.href = "../home/home.php";
          }
        };
        xhttp.open("POST", "presensi_keluar_aksi.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send(
          'photo=' + encodeURIComponent(data_uri) +
          '&id=' + id +
          '&tanggal_keluar=' + tanggal_keluar +
          '&jam_keluar=' + jam_keluar +
          '&latitude_keluar=' + latitude_keluar +
          '&longitude_keluar=' + longitude_keluar
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