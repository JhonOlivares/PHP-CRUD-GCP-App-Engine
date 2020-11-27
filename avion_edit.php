<?php
	include_once 'controllers/conexion.php';

	if(isset($_GET['id'])){
		//$id=(int) $_GET['id'];
		$id=$_GET['id'];

		$buscar_id=$cone->prepare('SELECT * FROM avion LEFT JOIN estado_avion ON avion.estadoID=estado_avion.estadoID WHERE avionMatricula=:id LIMIT 1');
		$buscar_id->execute(array(
			':id'=>$id
		));
        $resultado=$buscar_id->fetch();
        

        //para obtener el listado de estado_avion
        $sentenciaGetEstadoAvion=$cone->prepare('SELECT * FROM estado_avion ORDER BY estado');
	    $sentenciaGetEstadoAvion->execute();
	    $listStadoAvion=$sentenciaGetEstadoAvion->fetchAll();
    }
    
    else{
        echo "<script> location.href='avion_index'; </script>";
        exit;
	}


	if(isset($_POST['guardar'])){
		$modelo=$_POST['modelo'];
		$serie=$_POST['serie'];
		$fabricante=$_POST['fabricante'];
		$estadoID=$_POST['estadoID'];
		// $id= (int) $_GET['id'];
		$id=$_GET['id'];

		if(!empty($modelo) && !empty($serie) && !empty($fabricante)){
                if($estadoID == 0 )
                {
                    $estadoID = null;
                }
				$consulta_update=$cone->prepare('UPDATE avion SET  
					modelo=:modelo,
					serie=:serie,
					fabricante=:fabricante,
                    estadoID=:estadoID
					WHERE avionMatricula=:id;'
				);
				$consulta_update->execute(array(
					':modelo' =>$modelo,
					':serie' =>$serie,
					':fabricante' =>$fabricante,
                    ':estadoID' =>$estadoID,
					':id' =>$id
				));                
                echo "<script> location.href='avion_index'; </script>";
                exit;
			
		}else{
			echo "<script> alert('Los campos estan vacios');</script>";
		}
	}

?>

<!------------------------------------- HTML ----------------------->

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include_once 'includes/1_head.php';
    ?>
</head>

<body>
    <header>
        <?php
    include_once 'includes/2_header.php';
    ?>
    </header>


    
    <br>
    <div class="container shadow p-3 mb-5 bg-white rounded">
        <h2>Editar: <?php if($resultado) echo $resultado['avionMatricula']; ?></h2>
        <hr>
        <div class="container">
            <form action="" method="post">
                <div class="form-row">
                    <div class="col-md-5 mb-3">
                        <label for="fabricante">Fabricante</label>                        
                        <select class="form-control" id="fabricante" name="fabricante" required>
                            <option value="">Selecciona</option>
                            <option value="BOEING">BOEING</option>
                            <option value="AIRBUS">AIRBUS</option>
                            <option value="United Technologies">United Technologies</option>
                        </select>
                    </div>
                    <div class="col-md-7 mb-3">
                        <label for="modelo">Modelo</label>
                        <input type="text" name="modelo" id="modelo" class="form-control"
                            value="<?php if($resultado) echo $resultado['modelo']; ?>" required>
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-9 mb-3">
                        <label for="serie">Serie</label>
                        <input type="text" name="serie" id="serie" class="form-control"
                            value="<?php if($resultado) echo $resultado['serie']; ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="estadoID">Estado</label>

                        <select name="estadoID" id="estadoID" class="form-control">
                            <option value="0">Seleccionar estado</option>


                            <?php foreach($listStadoAvion as $fila):?>
                            <option value="<?php echo $fila['estadoID']; ?>"><?php echo $fila['estado']; ?></option>

                            <?php endforeach ?>

                        </select>



                    </div>
                </div>

                <div class="container">
                    <div class="text-right">
                        <a href="avion_index" class="btn btn-link">Cancelar</a>
                        <input type="submit" class="btn btn-primary" value="Guardar" name="guardar" />
                    </div>
                </div>
                <hr />
            </form>
        </div>

    </div>

    <?php
    include_once 'includes/3_footer.php';
    ?>
    <?php
    include_once 'includes/4_js.php';
    ?>

</body>
<script>
window.addEventListener("load", selectElement('estadoID', '<?php if($resultado) echo $resultado['estadoID']; ?>'), false);
window.addEventListener("load", selectElement('fabricante', '<?php if($resultado) echo $resultado['fabricante']; ?>'), false);

function selectElement(id, valueToSelect) {
    let element = document.getElementById(id);
    element.value = valueToSelect;
}
</script>

</html>