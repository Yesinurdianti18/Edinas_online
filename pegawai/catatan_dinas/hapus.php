<?php

session_start();
require_once('../../config.php');

$id = $_GET['id'];

$result = mysqli_query($connection, "DELETE FROM catatan_dinas WHERE id=$id");
$_SESSION['berhasil'] = "Catatan berhasil dihapus.";
header("location: catatan.php");
exit;
?>

<?php include('../layout/footer.php'); ?>
