<?php
session_start();
require_once('../config.php') ?>
<?php
if (isset($_POST["login"])) {
  $username = $_POST["username"];
  $password = $_POST["password"];
  $result = mysqli_query($connection, "SELECT * FROM users JOIN pegawai ON users.id_pegawai = pegawai.id WHERE username = '$username'");

  if (mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);
    if (password_verify($password, $row["password"])) {
      if ($row["status"] == "Aktif") {
        $_SESSION["login"] = true;
        $_SESSION["id"] = $row["id"];
        $_SESSION["role"] = $row["role"];
        $_SESSION["nama"] = $row["nama"];
        $_SESSION["nip"] = $row["nip"];
        $_SESSION["jabatan"] = $row["jabatan"];
        $_SESSION["lokasi_presensi"] = $row["lokasi_presensi"];
        $_SESSION["foto"] = $row["foto"];
        $_SESSION["berhasil"] = "LOGIN BERHASIL!";

        if ($row["role"] === "admin") {
          header("location: ../admin/home/home.php");
          exit();
        } else {
          header("location: ../pegawai/home/home.php");
          exit();
        }
      } else {
        $_SESSION["gagal"] = "Akun anda belum Aktif.";
      }
    } else {
      $_SESSION["gagal"] = "Password salah, silahkan coba lagi.";
    }
  } else {
    $_SESSION["gagal"] = "Username salah, silahkan coba lagi.";
  }
}
?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>eDinas | Presensi Digital</title>
  <link rel="icon" href="../assets/img/logo5.png" type="image/png" sizes="64x64">
  <!-- CSS files -->
  <link href="<?= base_url('assets/css/tabler.min.css?1692870487') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/tabler-vendors.min.css?1692870487') ?>" rel="stylesheet" />
  <link href="<?= base_url('assets/css/demo.min.css?1692870487') ?>" rel="stylesheet" />
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
      /* background-image: url(../assets/img/423-image.png); */
    }
  </style>
</head>

<body class=" d-flex flex-column">
  <script src="<?= base_url('assets/js/demo-theme.min.js?1692870487') ?>"></script>
  <div class="page page-center">
    <div class="container container-normal py-4">
      <div class="row align-items-center g-4">
        <div class="col-lg d-none d-lg-block">
          <img src="<?= base_url('assets/img/undraw_secure_login_pdn4.svg') ?>" height="300" class="d-block mx-auto" alt="">
          <!-- <img src="../assets/img/Lambang_Polri.png" height="200" alt="" /> -->

          <!-- <h1 class="card-title">Polsek Telukjambe Barat</h1>
          <p class="card-text">Selamat datang di website absensi e-Dinas, Yuk Absen!</p>
          <h2 id="jam"></h2>
          <h4 id="tanggal"></h4> -->

        </div>
        <div class="col-lg">
          <div class="container-tight">
            <div class="text-center mb-4">
              <a href="." class="navbar-brand navbar-brand-autodark"><img style="border-radius: 20px;" src="../assets/img/logo2.png" height="100" alt=""></a>
              <!-- <h2>e-Dinas</h2> -->
            </div>
            <?php
            if (isset($_GET["pesan"])) {
              if ($_GET["pesan"] == "belum_login") {
                $_SESSION["gagal"] = "Anda belum Login.";
              } else if ($_GET["pesan"] == "tolak_akses") {
                $_SESSION["gagal"] = "Akses ke Halaman ini ditolak.";
              }
            }
            ?>


            <div class="card card-md">
              <div class="card-body">
                <h2 class="h2 text-center mb-4">Masuk Untuk melakukan Presensi</h2>
                <form action="" method="POST" autocomplete="off" novalidate>
                  <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" autofocus class="form-control" name="username" placeholder="Username" autocomplete="off">
                  </div>
                  <div class="mb-2">
                    <label class="form-label">
                      Password
                    </label>
                    <div class="input-group input-group-flat">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off">
                      <span class="input-group-text" id="showHide">
                        <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                            <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                          </svg>
                        </a>
                      </span>
                    </div>
                  </div>
                  <div class="mb-2">
                    <label class="form-check">
                      <input type="checkbox" class="form-check-input" />
                      <span class="form-check-label">Remember me on this device</span>
                    </label>
                  </div>
                  <div class="form-footer">
                    <button type="submit" name="login" class="btn btn-primary w-100">Masuk</button>
                  </div>
                </form>
              </div>

              <!--  -->
              <div class="hr-text"></div>
            </div>
            <div class="text-center text-secondary mt-3">
              Belum punya Akun? <a href="signup.php" tabindex="-1">Register</a>
            </div>
            <!--  -->
          </div>
        </div>
      </div>
      <!-- cscs -->
    </div>
  </div>
  </div>
  <script>
    setInterval(() => {
      arrhari = ["Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu", "Minggu"];
      arrbulan = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
      date = new Date();
      detik = date.getSeconds().toString().padStart(2, "0");
      menit = date.getMinutes().toString().padStart(2, "0");
      jam = date.getHours().toString().padStart(2, "0");
      hari = date.getDay();
      tanggal = date.getDate().toString().padStart(2, "0");
      bulan = date.getMonth().toString().padStart(2, "0");
      tahun = date.getFullYear();
      document.getElementById("jam").innerHTML = jam + ":" + menit + ":" + detik;
      document.getElementById("tanggal").innerHTML = arrhari[hari] + ", " + tanggal + " " + arrbulan[bulan] + " " + tahun;
    }, 1000); // setiap 1000milidetik bisa refresh waktu

    function getClockIn() {
      const cin = arrhari[hari] + ", " + tanggal + " " + arrbulan[bulan] + " " + tahun + "<br/>" + jam + ":" + menit + ":" + detik;
      document.getElementById("clockin").innerHTML = cin;
    }

    function getClockOut() {
      const cout = arrhari[hari] + ", " + tanggal + " " + arrbulan[bulan] + " " + tahun + "<br/>" + jam + ":" + menit + ":" + detik;
      document.getElementById("clockout").innerHTML = cout;
    }
  </script>
  <script>
    const password = document.getElementById('password'); // id dari input password
    const showHide = document.getElementById('showHide'); // id span showHide dalam input group password

    password.type = 'password'; // set type input password menjadi password
    // showHide.innerHTML = '<i class="bi bi-eye"></i>'; // masukan icon eye dalam icon bootstrap 5
    showHide.style.cursor = 'pointer'; // ubah cursor menjadi pointer
    // jadi ketika span di hover maka cursornya berubah pointer

    showHide.addEventListener('click', () => {
      // ketika span diclick
      if (password.type === 'password') {
        // jika type inputnya password
        password.type = 'text'; // ubah type menjadi text
        // showHide.innerHTML = '<i class="bi bi-eye-slash"></i>'; // ubah icon menjadi eye slash
      } else {
        // jika type bukan password (text)
        // showHide.innerHTML = '<i class="bi bi-eye"></i>'; // ubah icon menjadi eye
        password.type = 'password'; // ubah type menjadi password
      }
    });
  </script>
  <!-- jquey cdn -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
  <!-- Libs JS -->
  <script src="<?= base_url('assets/libs/apexcharts/dist/apexcharts.min.js?1692870487') ?>" defer></script>
  <script src="<?= base_url('assets/libs/jsvectormap/dist/js/jsvectormap.min.js?1692870487') ?>" defer></script>
  <script src="<?= base_url('assets/libs/jsvectormap/dist/maps/world.js?1692870487') ?>" defer></script>
  <script src="<?= base_url('assets/libs/jsvectormap/dist/maps/world-merc.js?1692870487') ?>" defer></script>
  <!-- Tabler Core -->
  <script src="<?= base_url('assets/js/tabler.min.js?1692870487') ?>" defer></script>
  <script src="<?= base_url('assets/js/demo.min.js?1692870487') ?>" defer></script>
  <!-- Sweet Alert -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script>
    <?php if ($_SESSION['gagal']) { ?>

      Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "<?= $_SESSION['gagal']; ?>",
        // footer: '<a href="#">Why do I have this issue?</a>'
      });
  </script>
  <?php unset($_SESSION['gagal']); ?>
<?php } ?>


</body>

</html>