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
    $sql = $conexion->prepare("SELECT id, usuario, password, tipo FROM usuarios WHERE usuario = ?");
    $sql->bind_param("s", $usuario);
    $sql->execute();
    $resultado = $sql->get_result();

    if ($resultado->num_rows === 1) {

        $fila = $resultado->fetch_assoc();
        $hash = $fila['password'];

        // Verificar contraseña
        if (password_verify($password, $hash)) {

            $_SESSION['usuario_id'] = $fila['id'];
            $_SESSION['id_usuario'] = $fila['id'];
            $_SESSION['usuario'] = $fila['usuario'];
            $_SESSION['tipo'] = $fila['tipo']; 

            // 👇 redirección automática
            if ($fila['tipo'] === 'admin') {
                header("Location: admin.php");
                exit;
            } else {
                header("Location: index.php");
                exit;
            }
        }
    else {
                ?><html><script>
            alert("Contraseña incorrecta.");
            window.location.href = "sesion.html";
        </script></html><?php
            }

    } else {
        ?><html><script>
            alert("El usuario no existe.");
            window.location.href = "sesion.html";
        </script></html><?php
    }

    $sql->close();
    $conexion->close();
}
?>
