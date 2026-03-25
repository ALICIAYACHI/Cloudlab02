<?php
include("conexion.php");
$con = conexion();

$doc = trim($_POST["doc"]);
$nom = trim($_POST["nom"]);
$ape = trim($_POST["ape"]);
$dir = trim($_POST["dir"]);
$cel = preg_replace('/\D/', '', trim($_POST["cel"])); // elimina todo lo que no sea dígito

// Validación básica: evita insertar vacíos
if (empty($doc) || empty($nom) || empty($ape)) {
    die("Error: Documento, Nombre y Apellidos son obligatorios.");
}

$sql = "INSERT INTO persona(documento,nombre,apellido,direccion,celular) VALUES('$doc','$nom','$ape','$dir','$cel')";
$result = pg_query($con, $sql);

if (!$result) {
    die("Error al insertar: " . pg_last_error($con));
}

header("location:index.php");
exit();
?>