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
	function updateUser($id,$nom, $tel, $emai, $usuario, $rol)
	{
		// $passw = sha1($password);

		$ejecucion = $this->dbOperaciones("UPDATE usuarios SET nombre='$nom', telefono=$tel, email='$emai', usuario='$usuario', id_rol=$rol WHERE id=$id");

		return $ejecucion;
	}

	function updateUserfoto($id, $nom, $tel, $emai, $usuario, $foto, $rol)
	{

		$ejecucion = $this->dbOperaciones("UPDATE usuarios SET nombre='$nom', telefono=$tel, email='$emai', usuario='$usuario', foto_user='$foto', id_rol=$rol WHERE id=$id");

		return $ejecucion;
	}

}//fin CLASE