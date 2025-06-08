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
	function updateUsers($id, $std)
	{
		// $passw = sha1($password);

		$ejecucion = $this->dbOperaciones("UPDATE usuarios SET estado=$std WHERE id=$id");

		return $ejecucion;
	}

	function UpdateUsersfoto($id, $std, $foto)
	{
		$ejecucion = $this->dbOperaciones("UPDATE usuarios SET foto_user='$foto', estado=$std WHERE id=$id");

		return $ejecucion;
	}
}//fin CLASE