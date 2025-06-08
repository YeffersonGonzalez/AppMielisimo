<?php
include "../../app/users/users-services-update_std.php";
include "../../config/config.php";
$objAPI = new usersAPI();

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'POST':
        $objAPI->UpdateUsers();
        break;

    default:
        echo json_encode(array("data" => null, "error" => "3", "msg" => $errorResponse[3]));
        break;
}
