<?php
include "../../controllers/users/controller_consultas_users_delete.php";

class usersAPI
{
    function DeleteUser($datos)
    {



        if ($datos) {

            if (isset($datos['id'])) {
                $id = $datos['id'];
                $objDB = new ExtraerDatos();

                $ejecucion = $objDB->DeleteUser($id);

                if ($ejecucion) {
                    echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha Eliminado Exitosamente",));
                } else {
                    echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo eliminar",));
                }
            } else {
                echo json_encode(array("data" => null, "error" => "1", "msg" => "Debe seleccionar el usuario a eliminar",));
            }
        } else {
            echo json_encode(array("data" => null, "error" => "1", "msg" => "Faltan datos",));
        }
    }
}
