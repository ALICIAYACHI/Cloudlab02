<?php
include("conexion.php");
$con = conexion();

$id = $_GET['id'];
$sql = "SELECT * FROM persona WHERE idpersona = '$id'";
$result = pg_query($con, $sql);
$row = pg_fetch_assoc($result);

if (!$row) {
    die("Persona no encontrada.");
}
?>
<!doctype html>
<html lang="es">
<head>
  <title>Eliminar Persona</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

  <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
    <h5 class="my-0 mr-md-auto font-weight-normal">
      <img src="index2.png" style="width: 30px; position: absolute;">
      <span style="position: relative; left: 35px;">Index</span>
    </h5>
    <nav class="my-2 my-md-0 mr-md-3">
      <a class="p-2 text-dark" href="index.php">Registrar</a>
      <a class="p-2 text-dark" href="actualizar.php">Actualizar</a>
      <a class="p-2 text-dark font-weight-bold" href="eliminar.php">Eliminar</a>
      <a class="p-2 text-dark" href="listar.php">Listar</a>
    </nav>
  </div>

  <div class="container px-3 py-3 pt-md-5 pb-md-4 mx-auto text-center">
    <h1 class="display-4">Eliminar Persona</h1>
    <p class="lead">PostgreSQL + PHP</p>
  </div>

  <div class="container">
    <div class="card border-danger">
      <div class="card-body">

        <div class="alert alert-danger">
          ⚠️ ¿Estás seguro de que deseas eliminar este registro? Esta acción no se puede deshacer.
        </div>

        <table class="table table-bordered">
          <tr><th>ID</th>         <td><?= $row['idpersona'] ?></td></tr>
          <tr><th>Documento</th>  <td><?= htmlspecialchars($row['documento']) ?></td></tr>
          <tr><th>Nombre</th>     <td><?= htmlspecialchars($row['nombre']) ?></td></tr>
          <tr><th>Apellido</th>   <td><?= htmlspecialchars($row['apellido']) ?></td></tr>
          <tr><th>Dirección</th>  <td><?= htmlspecialchars($row['direccion']) ?></td></tr>
          <tr><th>Celular</th>    <td><?= htmlspecialchars($row['celular']) ?></td></tr>
        </table>

        <a href="listar.php" class="btn btn-secondary">Cancelar</a>
        <a href="eliminar-post.php?id=<?= $row['idpersona'] ?>" class="btn btn-danger float-right">
          🗑️ Sí, eliminar
        </a>

      </div>
    </div>

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
      <div class="col-12 col-md">
        <small class="d-block mb-3 text-muted">&copy; 2023-1</small>
      </div>
    </footer>
  </div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>