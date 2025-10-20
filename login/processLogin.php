<?php
session_start();
if (!isset($_POST['codEmpresa'], $_POST['username'], $_POST['password'])) {
    echo json_encode(["success" => false, "message" => "Faltan datos"]);
    exit;
}

$codEmpresa = $_POST['codEmpresa'];
$username = $_POST['username'];
$password = $_POST['password'];

$parametros = json_encode([
    "companyCode" => $codEmpresa,
    "username" => $username,
    "password" => $password
]);

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => 'https://ffull.lightdata.app/api/auth/login',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_POSTFIELDS => $parametros,
    CURLOPT_HTTPHEADER => ['Content-Type: application/json'],
]);

$response = curl_exec($curl);
curl_close($curl);

$result = json_decode($response, true);

// print_r($result);
// exit;

if ($result && isset($result['success']) && $result['success']) {
    $data = $result['data'];
    $_SESSION['logueado'] = true;
    $_SESSION['user'] = json_encode($data['user']);
    $_SESSION['idUser'] = $data['user']['did'];
    $_SESSION['perfilUser'] = $data['user']['perfil'];
    $_SESSION['nombreUser'] = $data['user']['nombre'];
    $_SESSION['apellidoUser'] = $data['user']['apellido'];
    $_SESSION['idEmpresa'] = $data['company']['did'];
    $_SESSION['codEmpresa'] = $data['company']['codigo'];
    $_SESSION['nombreEmpresa'] = $data['company']['nombre'];
    $_SESSION['logoEmpresa'] = $data['company']['imagen'];
    $_SESSION['modoTrabajoEmpresa'] = $data['company']['modo_trabajo'];
    $_SESSION['authToken'] = $data['user']['token'];

    echo json_encode([
        "success" => true,
        "message" => $result['message'] ?? "Login correcto",
        "data" => $data
    ]);
} else {
    $_SESSION['logueado'] = false;
    echo json_encode([
        "success" => false,
        "message" => $result['message'] ?? "Usuario o contraseña incorrectos"
    ]);
}
