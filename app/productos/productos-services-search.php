<?php
include "../../controllers/productos/controller_consultas_productos_search.php";
include "../../config/config.php";

class productosAPI
{
    function searchProductos()
    {
        include '../../config/config.php';
        $objDB = new ExtraerDatos();
        $data = array();

        if (isset($_GET["cod"])) {
            $data = $objDB->ProductosSearch($_GET["cod"]);


            $productos = array();
            $productos["data"] = array();

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
                    "act" => $row["activo"],
                    "fch_reg" => $row["fecha_creacion"],
                    "fch_mod" => $row["fecha_actualizacion"],
                    );
                    array_push($productos["data"], $item);
                }
                $productos["msg"] = "OK";
                $productos["error"] = "0";
                echo json_encode($productos);
            } else {
                echo json_encode(array("data" => null, "error" => "4", "msg" => $errorResponse[4]));
            }
        } else {
            echo json_encode(array("data" => null, "error" => "1", "msg" => "Debe enviar el search",));
        }
    }
}
