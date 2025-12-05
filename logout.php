<?php
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Redirige al login o a la página principal
header("Location: index.php");
exit;
?>
