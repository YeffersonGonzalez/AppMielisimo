<?php
include "../../controllers/productos/controller_consultas_productos_update.php";
include '../../validations/validateCampos.php';

class productosAPI
{
    function UpdateProductos()
    {
        $objDB = new ExtraerDatos();

        $cod = validarCampo('cod', 'cod');
        $nom = validarCampo('nom', 'nom');
        $stock = validarCampo('stock', 'stock');
        $stock_min = validarCampo('stock_minimo', 'stock_minimo');
        $prc_compra = validarCampo('prc_compra', 'prc_compra');
        $prc_venta = validarCampo('prc_venta', 'prc_venta');
        $id_marca = validarCampo('id_marca', 'id_marca');
        $fch_vnc = validarCampo('fch_vnc', 'fch_vnc');
        $obs = validarCampo('obs', 'obs');
        $id = validarCampo('id', 'id');
        
        $ejecucion = $objDB->UpdateProductos($id, $cod, $nom, $stock, $stock_min, $prc_compra, $prc_venta, $id_marca, $fch_vnc, $obs);

        if ($ejecucion) {
            echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha Actualizado Exitosamente",));
        } else {
            echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo actualizar",));
        }
    }
}
