<?php
include "../../app/productos/productos-services-update_std.php";
include "../../config/config.php";
$objAPI = new productosAPI();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'POST':
        $objAPI->UpdateProducto();
        break;

    default:
        echo json_encode(array("data" => null, "error" => "3", "msg" => $errorResponse[3]));
        break;
}
