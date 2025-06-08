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
	function UpdateProductos($id, $cod, $nom, $stock, $stock_min, $prc_compra, $prc_venta, $id_marca, $fch_vnc, $obs)
	{
		// $passw = sha1($password);

		$ejecucion = $this->dbOperaciones("UPDATE productos SET codigo=$cod, nombre='$nom', stock=$stock, stock_minimo=$stock_min, 
											precio_compra=$prc_compra, precio_venta=$prc_venta, fecha_venc='$fch_vnc', observaciones='$obs',
											id_marca=$id_marca WHERE id=$id");

		return $ejecucion;
	}
}//fin CLASE