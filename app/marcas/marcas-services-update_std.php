<?php
include "../../controllers/marcas/controller_consultas_marcas_update_std.php";
include '../../validations/validateCampos.php';

class marcasAPI
{
    function UpdateMarcaStd()
    {
        $objDB = new ExtraerDatos();
        /* Validacion de campos */
        $id = validarCampo('pk', 'pk');
        $std = validarCampo('activo', 'activo');

        $ejecucion = $objDB->UpdateMarca($id, $std);

        if ($ejecucion) {
            echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha actualizado Exitosamente",));
        } else {
            echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo actualizar",));
        }
    }
}
