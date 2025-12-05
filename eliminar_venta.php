<?php
session_start();
include "conexion.php";

// Asegurarse que SOLO el admin puede eliminar
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: index.php");
    exit;
}

if (!isset($_GET['id'])) {
    die("ID inválido.");
}

$id = intval($_GET['id']);

$stmt = $conexion->prepare("DELETE FROM ventas WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: admin.php?msg=eliminado");
} else {
    echo "Error al eliminar: " . $stmt->error;
}

$stmt->close();
?>
