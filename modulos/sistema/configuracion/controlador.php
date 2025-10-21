<?php
session_start();

if (isset($_POST['modo_trabajo'])) {
    $_SESSION['modoTrabajoEmpresa'] = $_POST['modo_trabajo'];

    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "message" => "modo_trabajo faltante"]);
}
