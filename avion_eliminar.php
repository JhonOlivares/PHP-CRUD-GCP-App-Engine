<?php 

include_once 'controllers/conexion.php';
if(isset($_GET['id'])){
    //$id=(int) $_GET['id'];
    $id=$_GET['id'];
    $delete=$cone->prepare('DELETE FROM avion WHERE avionMatricula=:id');
    $delete->execute(array(
        ':id'=>$id
    ));
    echo "<script> location.href='avion_index'; </script>";
    exit;
}
else{
    echo "<script> location.href='avion_index'; </script>";
    exit;
}
?>