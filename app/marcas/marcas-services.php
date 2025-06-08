<?php
include "../../controllers/marcas/controller_consultas_marcas_api.php";
include '../../validations/validateCampos.php';


class marcasAPI
{
    function getAllMarcas()
    {
        include '../../config/config.php';
        $objDB = new ExtraerDatos();
        $data = array();

        if (isset($_GET["id"])) {
            $data = $objDB->MarcasDetalle($_GET["id"]);
        } else {
            $data = $objDB->listadoMarcas();
        }

        $marca = array();
        $marca["data"] = array();

        if ($data) {
            foreach ($data as $row) {
                $item = array(
                    "pk" => $row["id"],
                    "cod" => $row["codigo"],
                    "nom" => $row["nombre"],
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
