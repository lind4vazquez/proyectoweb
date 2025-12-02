<?php
session_start();
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $usuario = trim($_POST['usuario'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($usuario) || empty($password)) {
        die("Faltan datos.");
    }

    // Buscar usuario en la base
    $sql = $conexion->prepare("SELECT id, usuario, password FROM usuarios WHERE usuario = ?");
    $sql->bind_param("s", $usuario);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows === 1) {

        $fila = $resultado->fetch_assoc();
        $hash = $fila['password'];

        // Verificar contraseña
        if (password_verify($password, $hash)) {

            // Guardar sesión
            $_SESSION['usuario_id'] = $fila['id'];
            $_SESSION['usuario'] = $fila['usuario'];

            header("Location: index.html");
            exit;
        } else {
            echo "Contraseña incorrecta.";
        }

    } else {
        echo "El usuario no existe.";
    }

    $sql->close();
    $conexion->close();
}
?>
