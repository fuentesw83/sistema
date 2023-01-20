<?php 
session_start();
require 'conexion.php';
$conexion = new Conexion();

if($_POST['ACCION'] == 'addPlanxUsuario'){
    
        $sql = "INSERT INTO planesxusuario
        (USUARIOID,PLANID,TIPOPAGO,VALOR,ESTADO) 
        VALUES(
        ".$_SESSION['id_usuario'].",
        ".$_POST['planid'].",
        '".$_POST['paga']."',
        ".$_POST['valor'].",
        0
        )";
        $consulta = $conexion->conectar()->query($sql);
        if($consulta){
            echo "<script>
                alert('Plan Adquirido, por favor envia el soporte de Pago al correo info@ibotcoinsfs.com');
                location.href = 'mailto:info@ibotcoinsfs.com';
                //location.href = '../planes.php';
            </script>";
        }
        
    
}
    


?>