<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conexion.php';

// Verificar sesión
if (!isset($_SESSION['id_usuario'])) {
    // El usuario no inició sesión: redirigir al login
    header("Location: sesion.html");
    exit();
}

$id_usuario = intval($_SESSION['id_usuario']);
$monto_raw = $_POST['totalPago'] ?? null;

// Si no se recibió monto, podemos mostrar error o continuar mostrando la página sin guardar.
if ($monto_raw !== null && $monto_raw !== '') {

    $monto = floatval(str_replace(',', '.', $monto_raw));

    if ($monto <= 0) {
        $error = "Monto inválido: $monto_raw";
    } else {

        // INSERTAR VENTA
        $stmt = $conexion->prepare("INSERT INTO ventas(id_usuario, monto) VALUES (?, ?)");
        if (!$stmt) {
            $error = "Error en prepare(): " . $conexion->error;
        } else {
            $stmt->bind_param("id", $id_usuario, $monto);
            if ($stmt->execute()) {
                $insert_ok = true;
                $id_compra = $stmt->insert_id;
            } else {
                $error = "Error al ejecutar la consulta: " . $stmt->error;
            }
            $stmt->close();
        }

        // 🔹🔹🔹 NUEVO: INSERTAR DIRECCIÓN 🔹🔹🔹
        if (empty($error)) {

            $estado     = $_POST['estado'] ?? null;
            $ciudad     = $_POST['ciudad'] ?? null;
            $cp         = $_POST['cp'] ?? null;
            $colonia    = $_POST['colonia'] ?? null;
            $calle      = $_POST['calle'] ?? null;
            $num_ex     = $_POST['num_ex'] ?? null;
            $num_in     = $_POST['num_in'] ?? null;
            $referencia = $_POST['referencia'] ?? null;

            // Insertar solo si el usuario llenó el formulario
            if ($estado && $ciudad && $cp && $colonia && $calle && $num_ex) {

                $dir = $conexion->prepare("
                    INSERT INTO direcciones
                    (id_usuario, estado, ciudad, cp, colonia, calle, num_ex, num_in, referencia)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
                ");

                $dir->bind_param(
                    "issssssss",
                    $id_usuario,
                    $estado,
                    $ciudad,
                    $cp,
                    $colonia,
                    $calle,
                    $num_ex,
                    $num_in,
                    $referencia
                );

                if ($dir->execute()) {
                    $direccion_ok = true;
                } else {
                    $error = "Error insertando dirección: " . $dir->error;
                }

                $dir->close();
            }
        }
        // 🔹🔹🔹 FIN NUEVO 🔹🔹🔹
    }
}


$codigoSeguimiento = chr(rand(65,90)) . rand(100000, 999999);
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Seguimiento de Pedido</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="estilo.css" rel="stylesheet">
</head>
<body>
<div class="wrap">
    <header>... tu header ...</header>

    <?php if (!empty($error)): ?>
        <div style="background:pink; color:#900; padding:10px; border-radius:6px;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (!empty($insert_ok)): ?>
        <div style="background:#e7ffe7; color:#080; padding:10px; border-radius:6px;">
            Compra registrada correctamente. ID compra: <?= htmlspecialchars($id_compra) ?>
        </div>
    <?php endif; ?>

    <div style="margin-bottom:20px; ...">
        Código de seguimiento:
        <span id="codigoSeguimiento"><?= htmlspecialchars($codigoSeguimiento) ?></span>
    </div>

    <!-- resto de la vista -->
</div>

<script>
 // Si quieres seguir mostrando un código JS, puedes sincronizar con PHP o quitar esto.
</script>
</body>
</html>
