<?php
include "../../app/marcas/marcas-services.php";
include "../../config/config.php";
$objAPI = new marcasAPI();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':
        $objAPI->getAllMarcas();
        break;

    default:
        echo json_encode(array("data" => null, "error" => "3", "msg" => $errorResponse[3]));
        break;
}
error_log("Request method: " . $_SERVER['REQUEST_METHOD']);
