<?php
include "../../app/marcas/marcas-services-update_std.php";
include "../../config/config.php";
$objAPI = new marcasAPI();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'POST':
        $objAPI->UpdateMarcaStd();
        break;

    default:
        echo json_encode(array("data" => null, "error" => "3", "msg" => $errorResponse[3]));
        break;
}
