<?php

class Producto
{

    public function __construct() {}

    public function postImage($data)
    {
        global $mysqli;
        global $GLOBAL_empresa_id;

        $Arespuesta = array();
        $ok = false;

        foreach ($data as $key => $value) {
            $Adatos = array();
            $Adatos["didproducto"] = $value["didProducto"];
            $Adatos["quien"] = $_SESSION["user"];
            $Adatos["idEmpresa"] = $_SESSION["configuracion"]["id"];
            $Adatos["imagen"] = $value["image"];

            //print_r($Adatos);

            $url = 'https://files.lightdata.app/uploadFF.php';

            // Inicializa cURL
            $ch = curl_init($url);

            // Configura las opciones de cURL
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Adatos));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);

            $response = curl_exec($ch);

            curl_close($ch);

            $quien = $value["quien"];
            $didproducto = $value["didProducto"];
            $server = 1;
            //echo $tipo."\n";

            if ($quien == 0) {
                $quien = $_SESSION["user"];
            }


            // $did = Fultimodid("envios_fotos");

            // $con = "INSERT INTO envios_fotos (did,didProducto,nombre,quien,server) VALUES (?,?,?,?,?)";

            // $stmt = $mysqli->prepare($con);
            // $stmt->bind_param("iisii", $did, $didproducto, $response, $quien, $server);
            // if ($stmt->execute()) {
            //     $ok = true;
            // }
            // $stmt->close();
        }
    }
}
