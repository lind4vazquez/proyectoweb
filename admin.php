<?php
session_start();
include "conexion.php"; // <--- Conexión a tu BD

if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: index.php");
    exit;
}
?>

<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Tienda PC - Demo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="estilo.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
</head>
<body>
<div class="wrap">

  <!-- HEADER -->
  <header>
    <div class="logo">
      <div class="mark">
        <img src="img/logoPagina.jpg" alt="Logo">
      </div>
      <div>
        <strong>TiendaPC - Admin</strong>
        <div style="font-size:12px;color:var(--muted)">Panel de Administración</div>
      </div>
    </div>

    <nav>
      <a href="index.php">Tienda</a>
      <a href="logout.php">Cerrar Sesión</a>
    </nav>
  </header>

  <div class="container mt-4">
    <h1>Bienvenido al Panel de Administración</h1>
    <p>Aquí puedes gestionar productos, usuarios y pedidos.</p>
    <!-- Contenido del panel de administración -->
  </div>
  <?php
    // === CONSULTA USUARIOS ===
    $usuarios = $conexion->query("SELECT id, usuario, correo, tipo FROM usuarios");

    // === CONSULTA PEDIDOS ===
    $pedidos = $conexion->query("SELECT id, id_usuario, monto, fecha FROM ventas");
    ?>
    <h2 class="mt-5 text-center">Usuarios Registrados</h2>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Tipo</th>
            </tr>
        </thead>
        <tbody>
            <?php while($u = $usuarios->fetch_assoc()): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= $u['usuario'] ?></td>
                <td><?= $u['correo'] ?></td>
                <td><?= $u['tipo'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <h2 class="mt-5 text-center">Ventas Registradas</h2>
    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Id del Usuario</th>
                <th>Monto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php while($u = $pedidos->fetch_assoc()): ?>
            <tr>
                <td><?= $u['id'] ?></td>
                <td><?= $u['id_usuario'] ?></td>
                <td><?= $u['monto'] ?></td>
                <td><?= $u['fecha'] ?></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>