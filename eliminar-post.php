<?php
include("conexion.php");
$con = conexion();

$id = $_GET['id'];

$sql = "DELETE FROM persona WHERE idpersona = '$id'";
$result = pg_query($con, $sql);

if (!$result) {
    die("Error al eliminar: " . pg_last_error($con));
}

header("location:listar.php");
exit();
?>