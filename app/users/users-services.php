<?php
include "../../controllers/users/controller_consultas_users_api.php";
include '../../validations/validateCampos.php';
include '../../saveImages/saveImage.php';


class usersAPI
{
    function getAllUsers()
    {
        include '../../config/config.php';
        $objDB = new ExtraerDatos();
        $data = array();

        if (isset($_GET["id"])) {
            $data = $objDB->UsersDetalle($_GET["id"]);
        } else {
            $data = $objDB->listadoUsers();
        }

        $User = array();
        $User["data"] = array();

        if ($data) {
            foreach ($data as $row) {
                $item = array(
                    "pk" => $row["id"],
                    "cod" => $row["codigo"],
                    "nom" => $row["nombre"],
                    "std" => $row["estado"],
                    "fch_reg" => $row["fecha_creacion"],
                    "fch_mod" => $row["fecha_actualizacion"],
                );
                array_push($User["data"], $item);
            }
            $User["msg"] = "OK";
            $User["error"] = "0";
            echo json_encode($User);
        } else {
            echo json_encode(array("data" => null, "error" => "4", "msg" => $errorResponse[4]));
        }
    }
}
