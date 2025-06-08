<?php
include "../../controllers/users/controller_consultas_users_update_password.php";

class usersAPI
{
    function UpdatePassword($datos)
    {
        if ($datos) {

            if (isset($datos['pass']) && isset($datos['id'])) {
                $objDB = new ExtraerDatos();

                $password = $datos['pass'];
                $id = $datos['id'];

                $ejecucion = $objDB->UpdatePasswordUser($id, $password);

                if ($ejecucion) {
                    echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha actualizado Exitosamente",));
                } else {
                    echo json_encode(array("data" => null, "error" => "1", "msg" => "La contraseña no se pudo actualizar :(",));
                }
            } else {
                echo json_encode(array("data" => null, "error" => "1", "msg" => "Falta el pass y el id",));
            }
        } else {
            echo json_encode(array("data" => null, "error" => "1", "msg" => "Faltan datos",));
        }
    }
}
