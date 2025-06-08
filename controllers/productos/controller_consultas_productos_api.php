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
	function listadoProductos($start = 0, $regsCant = 0)
	{
		$sql = "SELECT p.*, m.nombre as nombre_marca 
				FROM productos as p 
				INNER JOIN marcas as m ON p.id_marca = m.id 
				WHERE p.activo=1 ORDER BY p.nombre ASC";
		if ($regsCant > 0)
			$sql = "SELECT * from productos $start,$regsCant";
		$lista = $this->consulta_generales($sql);
		return $lista;
	}
	// DETALLE DE productos SELECICONADA SEGUN ID
	function ProductosDetalle($id)
	{
		$sql = "SELECT p.*, m.nombre as nombre_marca 
				FROM productos as p 
				INNER JOIN marcas as m ON p.id_marca = m.id 
				where p.id=$id";
		$lista = $this->consulta_generales($sql);
		return $lista;
	}

}//fin CLASE