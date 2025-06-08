<?php
include "../../controllers/productos/controller_consultas_productos_create.php";
include '../../validations/validateCampos.php';

class productosAPI
{
    function SaveProducto()
    {
        $objDB = new ExtraerDatos();
        $cod = validarCampo('cod', 'cod');
        $nom = validarCampo('nom', 'nom');
        $stock = validarCampo('stock', 'stock');
        $stock_min = validarCampo('stock_minimo', 'stock_minimo');
        $prc_compra = validarCampo('prc_compra', 'prc_compra');
        $prc_venta = validarCampo('prc_venta', 'prc_venta');
        $id_mrc = validarCampo('id_marca', 'id_marca');
        //campos sin validar
        $fch_vnc = $_POST['fch_vnc'];
        $obs = $_POST['obs'];

        $ejecucion = $objDB->SaveProducto($cod, $nom, $stock, $stock_min, $prc_compra, $prc_venta, $fch_vnc, $obs, $id_mrc);

        if ($ejecucion) {
            echo json_encode(array("data" => null, "error" => "0", "msg" => "Se ha Registrado Exitosamente",));
        } else {
            echo json_encode(array("data" => null, "error" => "1", "msg" => "No se pudo registrar",));
        }
    }
}
