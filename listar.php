<?php
include("conexion.php");
$con = conexion();

// Búsqueda
$busqueda = isset($_GET['buscar']) ? pg_escape_string($con, $_GET['buscar']) : '';

if ($busqueda !== '') {
    $sql = "SELECT * FROM persona WHERE 
            documento ILIKE '%$busqueda%' OR 
            nombre ILIKE '%$busqueda%' OR 
            apellido ILIKE '%$busqueda%' OR 
            direccion ILIKE '%$busqueda%' OR 
            celular ILIKE '%$busqueda%'
            ORDER BY idpersona ASC";
} else {
    $sql = "SELECT * FROM persona ORDER BY idpersona ASC";
}

$result = pg_query($con, $sql);
$total = pg_num_rows($result);
?>
<!doctype html>
<html lang="es">
<head>
  <title>Listar Personas</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Space+Mono:wght@400;700&family=DM+Sans:wght@300;400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <style>
    :root {
      --bg: #0b0f1a;
      --surface: #141824;
      --card: #1a2035;
      --border: #252d45;
      --accent: #00e5a0;
      --accent2: #5b8cff;
      --danger: #ff4d6d;
      --text: #e8eaf6;
      --muted: #6b7aaa;
      --header-h: 68px;
    }

    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    body {
      background: var(--bg);
      color: var(--text);
      font-family: 'DM Sans', sans-serif;
      min-height: 100vh;
    }

    /* ── NAV ── */
    .topbar {
      height: var(--header-h);
      background: var(--surface);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      padding: 0 2rem;
      gap: 1.5rem;
      position: sticky;
      top: 0;
      z-index: 100;
    }
    .topbar .brand {
      font-family: 'Space Mono', monospace;
      font-size: .95rem;
      color: var(--accent);
      letter-spacing: .04em;
      margin-right: auto;
      display: flex;
      align-items: center;
      gap: .5rem;
    }
    .topbar .brand span.dot {
      width: 8px; height: 8px;
      background: var(--accent);
      border-radius: 50%;
      display: inline-block;
      animation: pulse 2s infinite;
    }
    @keyframes pulse {
      0%,100% { opacity: 1; transform: scale(1); }
      50%      { opacity: .4; transform: scale(1.4); }
    }
    .topbar a {
      font-size: .85rem;
      color: var(--muted);
      text-decoration: none;
      padding: .35rem .75rem;
      border-radius: 6px;
      transition: all .2s;
      font-weight: 500;
    }
    .topbar a:hover, .topbar a.active {
      background: var(--border);
      color: var(--text);
    }

    /* ── HERO ── */
    .hero {
      padding: 3rem 2rem 2rem;
      text-align: center;
    }
    .hero h1 {
      font-family: 'Space Mono', monospace;
      font-size: clamp(1.6rem, 4vw, 2.6rem);
      font-weight: 700;
      background: linear-gradient(135deg, var(--accent) 0%, var(--accent2) 100%);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
      background-clip: text;
      margin-bottom: .5rem;
    }
    .hero p {
      color: var(--muted);
      font-size: .95rem;
    }

    /* ── STATS STRIP ── */
    .stats-strip {
      display: flex;
      justify-content: center;
      gap: 1rem;
      padding: 0 2rem 2rem;
      flex-wrap: wrap;
    }
    .stat-pill {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 999px;
      padding: .4rem 1.2rem;
      font-size: .8rem;
      color: var(--muted);
      display: flex;
      align-items: center;
      gap: .45rem;
    }
    .stat-pill strong { color: var(--text); font-weight: 700; }
    .stat-pill .ico { font-size: 1rem; }

    /* ── TOOLBAR ── */
    .toolbar {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 1.5rem 1.5rem;
      display: flex;
      gap: 1rem;
      align-items: center;
      flex-wrap: wrap;
    }
    .search-wrap {
      flex: 1;
      min-width: 200px;
      position: relative;
    }
    .search-wrap input {
      width: 100%;
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 10px;
      color: var(--text);
      padding: .65rem 1rem .65rem 2.8rem;
      font-size: .9rem;
      font-family: 'DM Sans', sans-serif;
      transition: border-color .2s;
      outline: none;
    }
    .search-wrap input::placeholder { color: var(--muted); }
    .search-wrap input:focus { border-color: var(--accent2); }
    .search-wrap .search-ico {
      position: absolute;
      left: .9rem;
      top: 50%;
      transform: translateY(-50%);
      color: var(--muted);
      font-size: 1rem;
      pointer-events: none;
    }
    .btn-search {
      background: var(--accent2);
      color: #fff;
      border: none;
      border-radius: 10px;
      padding: .65rem 1.4rem;
      font-family: 'DM Sans', sans-serif;
      font-weight: 600;
      font-size: .88rem;
      cursor: pointer;
      transition: opacity .2s, transform .15s;
    }
    .btn-search:hover { opacity: .85; transform: translateY(-1px); }
    .btn-clear {
      background: transparent;
      color: var(--muted);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: .65rem 1rem;
      font-family: 'DM Sans', sans-serif;
      font-size: .85rem;
      cursor: pointer;
      text-decoration: none;
      transition: all .2s;
    }
    .btn-clear:hover { border-color: var(--muted); color: var(--text); }
    .btn-new {
      background: var(--accent);
      color: var(--bg);
      border: none;
      border-radius: 10px;
      padding: .65rem 1.2rem;
      font-family: 'DM Sans', sans-serif;
      font-weight: 700;
      font-size: .88rem;
      cursor: pointer;
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: .4rem;
      transition: opacity .2s, transform .15s;
    }
    .btn-new:hover { opacity: .85; transform: translateY(-1px); color: var(--bg); text-decoration: none; }

    /* ── TABLE ── */
    .table-wrap {
      max-width: 1100px;
      margin: 0 auto;
      padding: 0 1.5rem 3rem;
    }
    .table-card {
      background: var(--card);
      border: 1px solid var(--border);
      border-radius: 14px;
      overflow: hidden;
    }
    table {
      width: 100%;
      border-collapse: collapse;
    }
    thead tr {
      background: var(--surface);
      border-bottom: 1px solid var(--border);
    }
    thead th {
      padding: .9rem 1.1rem;
      font-family: 'Space Mono', monospace;
      font-size: .72rem;
      letter-spacing: .08em;
      text-transform: uppercase;
      color: var(--muted);
      font-weight: 400;
    }
    tbody tr {
      border-bottom: 1px solid var(--border);
      transition: background .15s;
    }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: rgba(91,140,255,.06); }
    tbody td {
      padding: .85rem 1.1rem;
      font-size: .88rem;
      color: var(--text);
      vertical-align: middle;
    }

    /* avatar / badge */
    .avatar {
      width: 34px; height: 34px;
      border-radius: 50%;
      background: linear-gradient(135deg, var(--accent2), var(--accent));
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: .75rem;
      font-weight: 700;
      color: #fff;
      margin-right: .6rem;
      flex-shrink: 0;
    }
    .name-cell {
      display: flex;
      align-items: center;
    }
    .badge-doc {
      background: rgba(0,229,160,.12);
      color: var(--accent);
      font-family: 'Space Mono', monospace;
      font-size: .72rem;
      padding: .2rem .55rem;
      border-radius: 5px;
      letter-spacing: .04em;
    }

    /* action buttons */
    .action-btn {
      border: none;
      border-radius: 7px;
      padding: .3rem .7rem;
      font-size: .78rem;
      font-family: 'DM Sans', sans-serif;
      font-weight: 600;
      cursor: pointer;
      transition: opacity .15s, transform .1s;
      text-decoration: none;
    }
    .action-btn:hover { opacity: .8; transform: translateY(-1px); text-decoration: none; }
    .btn-edit  { background: rgba(91,140,255,.15); color: var(--accent2); margin-right: .3rem; }
    .btn-del   { background: rgba(255,77,109,.12); color: var(--danger); }

    /* empty state */
    .empty {
      text-align: center;
      padding: 4rem 2rem;
    }
    .empty .ico { font-size: 2.8rem; margin-bottom: 1rem; }
    .empty p { color: var(--muted); font-size: .9rem; }

    /* highlight match */
    mark {
      background: rgba(0,229,160,.25);
      color: var(--accent);
      border-radius: 3px;
      padding: 0 2px;
    }

    /* footer */
    footer {
      text-align: center;
      padding: 1.5rem;
      border-top: 1px solid var(--border);
      color: var(--muted);
      font-size: .78rem;
      font-family: 'Space Mono', monospace;
    }
  </style>
</head>
<body>

<!-- NAV -->
<nav class="topbar">
  <div class="brand">
    <span class="dot"></span> INDEX DB
  </div>
  <a href="index.php">Registrar</a>
  <a href="actualizar.php">Actualizar</a>
  <a href="eliminar.php">Eliminar</a>
  <a href="listar.php" class="active">Listar</a>
</nav>

<!-- HERO -->
<div class="hero">
  <h1>Directorio de Personas</h1>
  <p>PostgreSQL · PHP · Railway</p>
</div>

<!-- STATS -->
<div class="stats-strip">
  <div class="stat-pill">
    <span class="ico">👥</span>
    <strong><?= $total ?></strong>
    <?= $busqueda ? 'resultado(s) encontrado(s)' : 'persona(s) registrada(s)' ?>
  </div>
  <?php if ($busqueda): ?>
  <div class="stat-pill">
    <span class="ico">🔍</span>
    Búsqueda: <strong>"<?= htmlspecialchars($busqueda) ?>"</strong>
  </div>
  <?php endif; ?>
</div>

<!-- TOOLBAR -->
<div class="toolbar">
  <form method="GET" action="listar.php" class="search-wrap" style="display:contents;">
    <div class="search-wrap">
      <span class="search-ico">🔎</span>
      <input
        type="text"
        name="buscar"
        placeholder="Buscar por nombre, documento, dirección..."
        value="<?= htmlspecialchars($busqueda) ?>"
        autofocus
      >
    </div>
    <button type="submit" class="btn-search">Buscar</button>
    <?php if ($busqueda): ?>
      <a href="listar.php" class="btn-clear">✕ Limpiar</a>
    <?php endif; ?>
  </form>
  <a href="index.php" class="btn-new">＋ Nuevo</a>
</div>

<!-- TABLE -->
<div class="table-wrap">
  <div class="table-card">
    <?php if ($total === 0): ?>
      <div class="empty">
        <div class="ico">🗂️</div>
        <p><?= $busqueda ? 'No se encontraron resultados para "' . htmlspecialchars($busqueda) . '".' : 'Aún no hay personas registradas.' ?></p>
      </div>
    <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Documento</th>
          <th>Nombre completo</th>
          <th>Dirección</th>
          <th>Celular</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // Función definida UNA sola vez, fuera del loop
        function resaltar($texto, $busq) {
          if ($busq === '') return htmlspecialchars($texto);
          return preg_replace('/(' . preg_quote(htmlspecialchars($busq), '/') . ')/i', '<mark>$1</mark>', htmlspecialchars($texto));
        }

        $i = 1;
        while ($row = pg_fetch_assoc($result)):
          $iniciales = strtoupper(substr($row['nombre'], 0, 1) . substr($row['apellido'], 0, 1));
        ?>
        <tr>
          <td style="color:var(--muted); font-family:'Space Mono',monospace; font-size:.75rem;"><?= $i++ ?></td>
          <td><span class="badge-doc"><?= resaltar($row['documento'], $busqueda) ?></span></td>
          <td>
            <div class="name-cell">
              <div class="avatar"><?= $iniciales ?></div>
              <span><?= resaltar($row['nombre'] . ' ' . $row['apellido'], $busqueda) ?></span>
            </div>
          </td>
          <td style="color:var(--muted);"><?= resaltar($row['direccion'], $busqueda) ?></td>
          <td><?= resaltar($row['celular'], $busqueda) ?></td>
          <td>
            <a href="actualizar.php?id=<?= $row['idpersona'] ?>" class="action-btn btn-edit">✏️ Editar</a>
            <a href="eliminar.php?id=<?= $row['idpersona'] ?>" class="action-btn btn-del" onclick="return confirm('¿Eliminar a <?= htmlspecialchars($row['nombre']) ?>?')">🗑️ Eliminar</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
    <?php endif; ?>
  </div>
</div>

<footer>
  &copy; 2024 · INDEX DB · PostgreSQL + PHP
</footer>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" crossorigin="anonymous"></script>
</body>
</html>