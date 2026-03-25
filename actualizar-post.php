<?php
include("conexion.php");
$con = conexion();

$id  = $_POST['id'];
$doc = trim($_POST['doc']);
$nom = trim($_POST['nom']);
$ape = trim($_POST['ape']);
$dir = trim($_POST['dir']);
$cel = preg_replace('/\D/', '', trim($_POST['cel']));

$sql = "UPDATE persona SET 
        documento  = '$doc',
        nombre     = '$nom',
        apellido   = '$ape',
        direccion  = '$dir',
        celular    = '$cel'
        WHERE idpersona = '$id'";

$result = pg_query($con, $sql);

if (!$result) {
    die("Error al actualizar: " . pg_last_error($con));
}

header("location:listar.php");
exit();
?>