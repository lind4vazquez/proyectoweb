<?php
// Mostrar errores en desarrollo (quítalo en producción)
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'conexion.php'; // asegúrate que conexion.php NO hace echo ni imprime nada

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    
    // Recoger y sanitizar
    $usuario = trim($_POST['usuario'] ?? '');
    $correo = trim($_POST['correo'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    // Validaciones básicas
    if (empty($usuario) || empty($correo) || empty($password) || empty($password2)) {
        die('Faltan campos obligatorios.');
    }

    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        die('Correo inválido.');
    }
    if($password !== $password2) {
        ?><script>
            alert("Las contraseñas no coinciden.");
            window.location.href = "registro.html";
        </script><?php
        exit();
    }
    // Hashear contraseña (no almacenes contraseñas en texto plano)
    $hash = password_hash($password, PASSWORD_DEFAULT);

    // Preparar consulta
    $sql = $conexion->prepare("INSERT INTO usuarios (usuario, correo, password) VALUES (?, ?, ?)");
    if (!$sql) {
        die("Error en prepare(): " . $conexion->error);
    }

    $sql->bind_param("sss", $usuario, $correo, $hash);

    if ($sql->execute()) {
        $sql->close();
        $conexion->close();
        // Redirigir
        header("Location: index.php");
        exit();
    } else {
        // Mostrar error del statement (útil para depurar)
        echo "Error al registrar: " . $sql->error;
    }

    $sql->close();
    $conexion->close();
}
?>
