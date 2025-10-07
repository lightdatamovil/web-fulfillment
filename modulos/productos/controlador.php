<?php

$operador = $_POST["operador"];


$autosuficiente = false;
if (!isset($mysqli)) {
    session_start();
    include("../../conf/conector.php");
    include("../../system/functions.php");

    $autosuficiente = true;
}

$producto = new Producto();

switch ($operador) {
    case "postImage":
        echo $producto->postImage($_POST["data"]);
        break;
}

unset($producto);

if ($autosuficiente) {
    include("../../conf/conectorclose.php");
}
