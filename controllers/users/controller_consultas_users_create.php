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
	function SavePhotoUser($dni, $nombre, $tel, $email, $usuario, $password, $foto, $rol)
	{
		$passw = sha1($password);

		$ejecucion = $this->dbOperaciones("INSERT INTO usuarios(dni, nombre, telefono, email, usuario, password, foto_user, id_rol)
														values( $dni, '$nombre',$tel, '$email', '$usuario', '$passw', '$foto', $rol)");

		return $ejecucion;
	}
	
	function SaveUser($dni, $nombre, $tel, $email, $usuario, $password, $rol)
	{
		$passw = sha1($password);

		$ejecucion = $this->dbOperaciones("INSERT INTO usuarios(dni, nombre, telefono, email, usuario, password, id_rol)
														values($dni, '$nombre',$tel, '$email', '$usuario', '$passw', $rol)");

		return $ejecucion;
	}
}//fin CLASE