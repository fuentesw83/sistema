<?php 
require 'conexion.php';
class Data extends Conexion
{
	function infoPlanes(){
		$sql = "SELECT * FROM planesibot;";
		$consulta = Conexion::conectar()->query($sql);
		$con = $consulta->fetchAll();
		return $con;
	}

	function infoWallet($USUARIOID){
		$suma = 0;
		$sql = "SELECT valor FROM planesxusuario WHERE estado = 1 AND usuarioid = ". $USUARIOID.";";
		$consulta = Conexion::conectar()->query($sql);
		$con = $consulta->fetchAll();
		foreach ($con as $k) {
			$suma = $k['valor'] + $suma;
		}
		return $suma;
		
	}
    

}
?>