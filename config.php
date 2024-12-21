<?php

$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "presensi_edinas";

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$connection) {
    echo "Koneksi ke Database gagal!" . mysqli_connect_error();
}

// Base URL path assets
function base_url($url = null)
{
    // $base_url = 'https://4da9-140-213-11-124.ngrok-free.app/edinas';
    $base_url = 'http://localhost/edinas';
    if ($url != null) {
        return $base_url . '/' . $url;
    } else {
        return $base_url;
    }
}
