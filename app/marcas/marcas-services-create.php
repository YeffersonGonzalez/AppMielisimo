<?php
include "../../controllers/marcas/controller_consultas_marcas_create.php";
include '../../validations/validateCampos.php';

class marcasAPI
{
    function SaveMarca()
    {
        $objDB = new ExtraerDatos();

        $cod = validarCampo('cod', 'cod');
        $nombre = validarCampo('nom', 'nom');

        $ejecucion = $objDB->SaveMarca($cod, $nombre);

        if ($ejecucion) {
            echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha Registrado Exitosamente",));
        } else {
            echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo registrar",));
        }
        /* echo json_encode(array("data" => null, "error" => "1", "msg" => "Debe enviar una imagen",)); */
    }
}
