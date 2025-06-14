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
	// DETALLE DE productos SELECICONADA SEGUN ID
	function ProductosSearch($TextoBuscar)
	{
		$sql = "SELECT * from productos WHERE codigo LIKE '$TextoBuscar'";
		$lista = $this->consulta_generales($sql);
		return $lista;
	}
}//fin CLASE