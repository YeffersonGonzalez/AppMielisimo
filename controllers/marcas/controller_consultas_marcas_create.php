<?php
session_start();
require_once("../../models/models_admin.php");
class DBOperations extends DBConfig
{
	// CREAR, UPDATE, DELETE
	function dbOperaciones($sql)
	{
		$this->config();
		$this->conexion();

		$records = $this->Operaciones($sql);

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

	function SaveMarca($cod, $nombre)
	{
		$ejecucion = $this->dbOperaciones("INSERT INTO marcas(codigo, nombre)
														values($cod, '$nombre')");

		return $ejecucion;
	}
}//fin CLASE