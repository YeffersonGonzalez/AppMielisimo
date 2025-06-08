<?php
session_start();
require_once("../../models/models_admin.php");
class DBOperations extends DBConfig
{

	// GET
	function consulta_generales($sql){
		  $this->config();
		  $this->conexion(); 
		  
  		  $records = $this->Consultas($sql);		 		  		  		  
		  if ($records) {			  		    
			while ($dtrow = mysql_fetch_assoc($records)){
			   $lista[] = $dtrow;	
			}
			return $lista;						 			
			mysql_free_result($records);
		  }else{
			  return false;  
		  }	  
		  $this->close();		
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
	// DETALLE DE marcas SELECICONADA SEGUN ID
	function marcasSearch($TextoBuscar)
	{
		$sql = "SELECT * from marcas WHERE codigo LIKE '$TextoBuscar'";

		$lista = $this->consulta_generales($sql);
		return $lista;

	}
}//fin CLASE