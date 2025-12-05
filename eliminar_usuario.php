<?php
include "conexion.php";

if (!isset($_GET['id'])) {
    header("Location: admin.php");
    exit;
}

$id = $_GET['id'];

// Gracias a ON DELETE CASCADE se borran automáticamente las ventas del usuario
$stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: admin.php?delete_user=ok");
exit();
?>
