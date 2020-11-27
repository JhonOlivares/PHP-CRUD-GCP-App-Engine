<?php 

	include_once 'controllers/conexion.php';
	if(isset($_GET['id'])){
		$id=(int) $_GET['id'];
		$delete=$cone->prepare('DELETE FROM cliente WHERE clienteID=:id');
		$delete->execute(array(
			':id'=>$id
		));        
        echo "<script> location.href='cliente_index.php'; </script>";
        exit;
    }
    else{
		echo "<script> location.href='cliente_index.php'; </script>";
        exit;
	}
 ?>