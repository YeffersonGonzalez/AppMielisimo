<?php
include "../../controllers/productos/controller_consultas_productos_update_std.php";
include '../../validations/validateCampos.php';

class productosAPI
{
    function UpdateProducto()
    {
        $objDB = new ExtraerDatos();
        /* Validacion de campos */
        $id = validarCampo('pk', 'pk');
        $activo = validarCampo('activo', 'activo');

        $ejecucion = $objDB->UpdateProducto($id, $activo);

        if ($ejecucion) {
            echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha actualizado Exitosamente",));
        } else {
            echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo actualizar",));
        }
    }
}
