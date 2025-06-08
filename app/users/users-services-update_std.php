<?php
include "../../controllers/users/controller_consultas_users_update_std.php";
include '../../validations/validateCampos.php';
include '../../saveImages/saveImage.php';

class usersAPI
{
    function UpdateUsers()
    {
        $objDB = new ExtraerDatos();
        /* Validacion de campos */
        $id = validarCampo('id', 'id');
        $std = validarCampo('std', 'std');
        /* $std =  $_POST['std']; */
        if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"] != null) {
            $foto = $_FILES["photo"];
            $folder = "users";
            $rutafoto = handleFileUpload($foto, $folder);

            $ejecucion = $objDB->UpdateUsersfoto($id, $std, $rutafoto);

            if ($ejecucion) {
                echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha actualizado Exitosamente",));
            } else {
                echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo actualizar",));
            }
        } else {
            $ejecucion = $objDB->UpdateUsers($id, $std);

            if ($ejecucion) {
                echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha actualizado Exitosamente",));
            } else {
                echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo actualizar",));
            }
        }
    }
}
