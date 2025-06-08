<?php
include "../../controllers/productos/controller_consultas_productos_api.php";
include '../../validations/validateCampos.php';


class productosAPI
{
    function getAllProductos()
    {
        include '../../config/config.php';
        $objDB = new ExtraerDatos();
        $data = array();

        if (isset($_GET["id"])) {
            $data = $objDB->ProductosDetalle($_GET["id"]);
        } else {
            $data = $objDB->listadoProductos();
        }

        $marca = array();
        $marca["data"] = array();

        if ($data) {
            foreach ($data as $row) {
                $item = array(
                    "pk" => $row["id"],
                    "cod" => $row["codigo"],
                    "nom" => $row["nombre"],
                    "stock" => $row["stock"],
                    "stock_min" => $row["stock_minimo"],
                    "prc_compra" => $row["precio_compra"],
                    "prc_venta" => $row["precio_venta"],
                    "fch_vnc" => $row["fecha_venc"],
                    "obs" => $row["observaciones"],
                    "id_mrc" => $row["id_marca"],
                    "nom_mrc" => $row["nombre_marca"],
                    "act" => $row["activo"],
                    "fch_reg" => $row["fecha_creacion"],
                    "fch_mod" => $row["fecha_actualizacion"],
                );
                array_push($marca["data"], $item);
            }
            $marca["msg"] = "OK";
            $marca["error"] = "0";
            echo json_encode($marca);
        } else {
            echo json_encode(array("data" => null, "error" => "4", "msg" => $errorResponse[4]));
        }
    }
}
