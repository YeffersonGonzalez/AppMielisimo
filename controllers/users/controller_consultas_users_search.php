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
	function usersSearch2($usuario)
	{
		$sql = "SELECT * from usuarios where usuario LIKE '%$usuario%' ";
		$lista = $this->consulta_generales($sql);
		return $lista;
	}
	// DETALLE DE USUARIOS SELECICONADA SEGUN ID
	function usersSearch($TextoBuscar)
	{
		$sql = "SELECT * from usuarios WHERE id!=1 AND nombre LIKE '%$TextoBuscar%'  
			OR id!=1 AND  email LIKE '%$TextoBuscar%'  
			OR id!=1 AND  usuario LIKE '%$TextoBuscar%' ORDER BY nombre ASC; ";
		$lista = $this->consulta_generales($sql);
		return $lista;
	}
}//fin CLASE