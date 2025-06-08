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
	function listadoUsers($start = 0, $regsCant = 0)
	{
		$sql = "SELECT * FROM usuarios WHERE id!=1 AND id!=2 AND estado=1 ORDER BY nombre ASC";
		if ($regsCant > 0)
			$sql = "SELECT * from usuarios $start,$regsCant";
		$lista = $this->consulta_generales($sql);
		return $lista;
	}
	// DETALLE DE USUARIOS SELECICONADA SEGUN ID
	function UsersDetalle($idu)
	{
		$sql = "SELECT * from usuarios where id=$idu ";
		$lista = $this->consulta_generales($sql);
		return $lista;
	}

}//fin CLASE