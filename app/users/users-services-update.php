<?php
include "../../controllers/users/controller_consultas_users_update.php";
include '../../validations/validateCampos.php';
include '../../saveImages/saveImage.php';

class usersAPI
{
    function UpdateUser()
    {
        $objDB = new ExtraerDatos();

        $nom = validarCampo('nom', 'nom');
        $tel = validarCampo('tel', 'tel');
        $emai = validarCampo('emai', 'emai');
        $usuario = validarCampo('user', 'user');
        $rolUser = validarCampo('rolUser', 'rolUser');
        $id = validarCampo('id', 'id');

        if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"] != null) {
            $foto = $_FILES["photo"];
            $folder = "users";
            $rutafoto = handleFileUpload($foto, $folder);

            $ejecucion = $objDB->updateUserfoto($id, $nom, $tel, $emai, $usuario, $rutafoto, $rolUser);

            if ($ejecucion) {
                echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha actualizado Exitosamente",));
            } else {
                echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo actualizar",));
            }
        } else {
            $ejecucion = $objDB->updateUser($id, $nom, $tel, $emai, $usuario, $rolUser);

            if ($ejecucion) {
                echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha actualizado Exitosamente",));
            } else {
                echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo actualizar",));
            }
        }
    }
}
