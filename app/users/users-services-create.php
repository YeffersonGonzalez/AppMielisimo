<?php
include "../../controllers/users/controller_consultas_users_create.php";
include '../../validations/validateCampos.php';
include '../../saveImages/saveImage.php';

class usersAPI
{
    function SaveUser()
    {
        $objDB = new ExtraerDatos();

        $dni = validarCampo('dni', 'dni');
        $nombre = validarCampo('nom', 'nom');
        $tel = validarCampo('tel', 'tel');
        $email = validarCampo('emai', 'emai');
        $usuario = validarCampo('user', 'user');
        $password = validarCampo('pass', 'pass');
        $rolUser = validarCampo('rolUser', 'rolUser');
        if (isset($_FILES["photo"]["name"]) && $_FILES["photo"]["name"] != null) {
            $foto = $_FILES["photo"];
            $folder = "users";
            $rutafoto = handleFileUpload($foto, $folder);

            $ejecucion = $objDB->SavePhotoUser($dni, $nombre, $tel, $email, $usuario, $password, $rutafoto, $rolUser);

            if ($ejecucion) {
                echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha Registrado Exitosamente",));
            } else {
                echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo registrar",));
            }
        } else {
            $ejecucion = $objDB->SaveUser($dni, $nombre, $tel, $email, $usuario, $password, $rolUser);

            if ($ejecucion) {
                echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha Registrado Exitosamente",));
            } else {
                echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo registrar",));
            }
            /* echo json_encode(array("data" => null, "error" => "1", "msg" => "Debe enviar una imagen",)); */
        }
    }
}
