<?php
session_start();

if (isset($_SESSION["logueado"])) {
    if ($_SESSION["logueado"] === true) {
        include("home.php"); // Usuario logueado correctamente
    } else {
        include("login/homebloqueada.php"); // Usuario bloqueado
    }
} else {
    include("login/login.php"); // No inició sesión o faltan datos
}
