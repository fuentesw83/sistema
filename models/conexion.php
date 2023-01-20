<?php  
/**
* 
*/
class Conexion
{
	public function conectar(){
		$datos = "mysql:dbname=sistemaibot; host=localhost;";
		$user = "root";
		$pass = "";
		try {
			$pdo = new PDO($datos,$user,$pass);
		
			return $pdo;
		} catch (Exception $e) {
			$e->getMessage();
		}
	}
}
?>