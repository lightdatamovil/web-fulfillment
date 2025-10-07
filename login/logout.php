<?php

session_start(); // Iniciás la sesión actual

// Limpiás todas las variables de sesión
$_SESSION = [];

// Destruís la cookie de sesión si está seteada
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente destruís la sesión
session_destroy();

echo json_encode(["estado"=>true, "mensaje"=>"Sesión cerrada correctamente"]);

?>