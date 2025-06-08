<?php
include "../../controllers/marcas/controller_consultas_marcas_search.php";
include "../../config/config.php";

class marcasAPI
{
    function searchMarca()
    {
        include '../../config/config.php';
        $objDB = new ExtraerDatos();
        $data = array();

        if (isset($_GET["cod"])) {
            $data = $objDB->marcasSearch($_GET[1]);


            $marcas = array();
            $marcas["data"] = array();

            if ($data) {
                foreach ($data as $row) {
                    $item = array(
                        "pk" => $row["id"],
                        "cod" => $row["codigo"],
                        "nom" => $row["nombre"],
                        "act" => $row["activo"]
                    );
                    array_push($marcas["data"], $item);
                }
                $marcas["msg"] = "OK";
                $marcas["error"] = "0";
                echo json_encode($marcas);
            } else {
                echo json_encode(array("data" => null, "error" => "4", "msg" => $errorResponse[4]));
            }
        } else {
            echo json_encode(array("data" => null, "error" => "1", "msg" => "Debe enviar el search",));
        }
    }
}
