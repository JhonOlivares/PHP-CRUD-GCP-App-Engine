<?php 
    include_once 'controllers/conexion.php';
    
    $sentenciaGetEstadoAvion=$cone->prepare('SELECT * FROM estado_avion ORDER BY estado');
	$sentenciaGetEstadoAvion->execute();
	$listStadoAvion=$sentenciaGetEstadoAvion->fetchAll();
	
	if(isset($_POST['guardar'])){
		$avionMatricula=$_POST['avionMatricula'];
		$modelo=$_POST['modelo'];
		$serie=$_POST['serie'];
		$fabricante=$_POST['fabricante'];
		$estadoID=$_POST['estadoID'];

		if(!empty($avionMatricula) && !empty($modelo) && !empty($serie) && !empty($fabricante)){
            if($estadoID == 0 )
                {
                    $estadoID = null;
                }
				$consulta_insert=$cone->prepare('INSERT INTO avion(avionMatricula,modelo,serie,fabricante,estadoID) VALUES(:avionMatricula,:modelo,:serie,:fabricante,:estadoID)');
				$consulta_insert->execute(array(
					':avionMatricula' =>$avionMatricula,
					':modelo' =>$modelo,
					':serie' =>$serie,
					':fabricante' =>$fabricante,
					':estadoID' =>$estadoID
				));
                echo "<script> location.href='avion_index'; </script>";
                exit;
			
		}else{
			echo "<script> alert('todos los campos son requeridos, no pueden quedar en blanco.');</script>";
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
        <h2>Agregar nuevo avión</h2>
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
                        <input type="text" name="modelo" id="modelo" class="form-control" required>
                    </div>

                </div>
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="serie">Serie</label>
                        <input type="text" name="serie" id="serie" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="avionMatricula">Matrícula</label>
                        <input type="text" name="avionMatricula" id="avionMatricula" class="form-control" required>
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

</html>