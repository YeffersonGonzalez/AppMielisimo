<?php
session_start();
require_once("../../models/models_admin.php");
class DBOperations extends DBConfig
{
    // GET
    function consulta_generales($sql)
    {
        $this->config();
        $this->conexion();

        $records = $this->Consultas($sql);

        // Check if the query execution was successful
        if (!$records) {
            throw new Exception("Error executing query: " . $sql);
        }

        $this->close();
        return $records;
    }
}


/**
 * IMPLEMENTACION DE ACCESO A CONSULTAS PARA PROTEGER MAS LA VISTA
 */
class ExtraerDatos extends DBOperations
{


	// ****************************************************************************
	// Agregue aqui debajo el resto de Funciones - Se ha dejado  Listado y detalle
	// ****************************************************************************
	//MUESTRA LISTADO DE USUARIO
	function listadoMarcas($start = 0, $regsCant = 0)
	{
		$sql = "SELECT * FROM marcas WHERE activo=1 ORDER BY nombre ASC";
		if ($regsCant > 0)
			$sql = "SELECT * from marcas $start,$regsCant";
		$lista = $this->consulta_generales($sql);
		return $lista;
	}
	// DETALLE DE marcas SELECICONADA SEGUN ID
	function MarcasDetalle($idu)
	{
		$sql = "SELECT * from marcas where id=$idu ";
		$lista = $this->consulta_generales($sql);
		return $lista;
	}

}//fin CLASE