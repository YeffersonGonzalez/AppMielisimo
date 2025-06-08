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

	function SaveProducto($cod, $nom, $stock, $stock_min, $prc_compra, $prc_venta, $fch_vnc, $obs, $id_mrc)
	{
		$ejecucion = $this->dbOperaciones("INSERT INTO productos(codigo, nombre, stock, stock_minimo, precio_compra, precio_venta, fecha_venc, observaciones, id_marca)
		VALUES($cod, '$nom', $stock, $stock_min, $prc_compra, $prc_venta, '$fch_vnc', '$obs', $id_mrc)");

		return $ejecucion;
	}
}//fin CLASE