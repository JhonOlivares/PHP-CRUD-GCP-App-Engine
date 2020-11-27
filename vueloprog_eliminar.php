<?php 

	include_once 'controllers/conexion.php';
	if(isset($_GET['id'])){
		$id=$_GET['id'];
		$delete=$cone->prepare('DELETE FROM vuelo_programado WHERE numeroVuelo=:id');
		$delete->execute(array(
			':id'=>$id
		));        
        echo "<script> location.href='vueloprog_index.php'; </script>";
        exit;
    }
    else{        
        echo "<script> location.href='vueloprog_index.php'; </script>";
        exit;
	}
 ?>