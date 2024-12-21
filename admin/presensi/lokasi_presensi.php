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
        height: 530px;
        border-radius: 10px;
    }

    .custom-marker {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        border-radius: 50%;
        border: 3px solid white
    }
</style>

<?php
ob_start();
session_start();
if (!isset($_SESSION["login"])) {
    header("location: ../../auth/login.php?pesan=belum_login");
} else if ($_SESSION["role"] != "admin") {
    header("location: ../../auth/login.php?pesan=tolak_akses");
}
$title = 'Lihat Lokasi Terkini';
include('../layout/header.php');
include_once('../../config.php');
date_default_timezone_set('Asia/Jakarta');
$tanggal_hari_ini = date('Y-m-d');
$result = mysqli_query($connection, "SELECT presensi.*, pegawai.id, pegawai.nama, pegawai.foto FROM presensi JOIN pegawai ON presensi.id_pegawai = pegawai.id WHERE tanggal_masuk = '$tanggal_hari_ini' ORDER BY tanggal_masuk DESC");
?>

<div class="page-header">
    <div class="container-xl">
        <div class="row align-items-center">
            <div class="col">
                <!-- <div class="page-pretitle">
          Overview
        </div> -->
                <h2 class="page-title">
                    <span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-map-pin">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M18.364 4.636a9 9 0 0 1 .203 12.519l-.203 .21l-4.243 4.242a3 3 0 0 1 -4.097 .135l-.144 -.135l-4.244 -4.243a9 9 0 0 1 12.728 -12.728zm-6.364 3.364a3 3 0 1 0 0 6a3 3 0 0 0 0 -6z" />
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
<div class="page-body">
    <div class="container-xl">
        <div class="row row-deck row-cards">
            <div class="col-12">
                <div class="row row-cards">
                    <div class="col-sm-6 col-lg-8">
                        <div id="map"></div>
                    </div>
                    <div class="col-sm-6 col-lg-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Kehadiran Hari ini</h3>
                            </div>
                            <div class="list-group list-group-flush overflow-auto" style="max-height: 35rem">
                                <?php while ($rekap = mysqli_fetch_array($result)) : ?>
                                    <div class="list-group-item">
                                        <div class="row">
                                            <div class="col-auto">
                                                <a href="#">
                                                    <span class="avatar" style="background-image: url(../../assets/img/foto_pegawai/<?= $rekap['foto'] ?>)"></span>
                                                </a>
                                            </div>
                                            <div class="col text-truncate">
                                                <a href="#" class="text-body d-block"><b><?= $rekap['nama'] ?></b></a>
                                                <div class="text-secondary text-truncate mt-n1"><?= date('d/m/Y', strtotime($rekap['tanggal_masuk'])) . ' | ' . $rekap['jam_masuk'] ?></div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let map = L.map('map').setView([-6.353655, 107.367626], 15);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    <?php
    $row = mysqli_query($connection, "SELECT presensi.*, pegawai.id, pegawai.nama, pegawai.foto FROM presensi JOIN pegawai ON presensi.id_pegawai = pegawai.id WHERE tanggal_masuk = '$tanggal_hari_ini' ORDER BY tanggal_masuk DESC"); ?>
    <?php while ($lokasi = mysqli_fetch_assoc($row)) { ?>
        var greenIcon<?= $lokasi['id_pegawai'] ?> = L.icon({
            iconUrl: '../../assets/img/foto_pegawai/<?= $lokasi['foto'] ?>',
            // shadowUrl: 'leaf-shadow.png',
            className: 'custom-marker',
            iconSize: [50, 50], // size of the icon
            // shadowSize: [50, 64], // size of the shadow
            // iconAnchor: [22, 94], // point of the icon which will correspond to marker's location
            // shadowAnchor: [4, 62], // the same for the shadow
            popupAnchor: [-3, -18] // point from which the popup should open relative to the iconAnchor
        });
        L.marker([<?= $lokasi['latitude_masuk'] ?>, <?= $lokasi['longitude_masuk'] ?>], {
            icon: greenIcon<?= $lokasi['id_pegawai'] ?>
        }).addTo(map).bindPopup("<?= $lokasi['nama'] ?>").openPopup();
    <?php } ?>

    <?php
    // $result = mysqli_query($connection, "SELECT * FROM lokasi_presensi WHERE nama_lokasi = '$lokasi_presensi'");
    $lok = $_SESSION['lokasi_presensi'];
    $result = mysqli_query($connection, "SELECT * FROM lokasi_presensi WHERE nama_lokasi = '$lok' ");
    ?>
    <?php while ($lok = mysqli_fetch_array($result)) : ?>
        let markers = L.marker([<?= $lok['latitude'] ?>, <?= $lok['longitude'] ?>]).addTo(map).bindPopup("<b>Lokasi Presensi.").openPopup();
        // var marker = L.marker([latitude_peg, longitude_peg]).addTo(map).bindPopup("<b>Lokasi anda saat ini.").openPopup();
        var circle = L.circle([<?= $lok['latitude'] ?>, <?= $lok['longitude'] ?>], {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.1,
            radius: 500
        }).addTo(map);
        var circle1 = L.circle([<?= $lok['latitude'] ?>, <?= $lok['longitude'] ?>], {
            color: 'green',
            fillColor: '#00ff3d',
            fillOpacity: 0.0,
            radius: 5000
        }).addTo(map);
        var circle2 = L.circle([<?= $lok['latitude'] ?>, <?= $lok['longitude'] ?>], {
            color: 'blue',
            fillColor: '#0800ff',
            fillOpacity: 0.0,
            radius: 10000
        }).addTo(map);
    <?php endwhile; ?>
</script>

<?php include('../layout/footer.php') ?>