<?php
include "../../controllers/marcas/controller_consultas_marcas_update.php";
include '../../validations/validateCampos.php';

class marcasAPI
{
    function UpdateMarca()
    {
        $objDB = new ExtraerDatos();

        $cod = validarCampo('cod', 'cod');
        $nom = validarCampo('nom', 'nom');
        $id = validarCampo('pk', 'pk');

        $ejecucion = $objDB->updateMarca($id, $cod, $nom);

        if ($ejecucion) {
            echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha actualizado Exitosamente",));
        } else {
            echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo actualizar",));
        }
    }
}
