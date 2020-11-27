<?php 
    include_once 'controllers/conexion.php';
    
    //obtener el listado de aeropuertos
    $sentenciaGetAirplanes=$cone->prepare('SELECT * FROM aeropuerto INNER JOIN ciudad ON 
    aeropuerto.ciudadID = ciudad.ciudadID ORDER BY nombreAeropuerto');
	$sentenciaGetAirplanes->execute();
	$listAeropuerto=$sentenciaGetAirplanes->fetchAll();
	
	if(isset($_POST['guardar'])){
		$numeroVuelo=$_POST['numeroVuelo'];
		$origen=$_POST['origen'];
		$destino=$_POST['destino'];
		$horaSalida=$_POST['horaSalida'];
		$fechaInicio=$_POST['fechaInicio'];
		$fechaFin=$_POST['fechaFin'];

		if(!empty($origen) && !empty($numeroVuelo) && ($origen != $destino)){
            
			$consulta_insert=$cone->prepare('INSERT INTO vuelo_programado(numeroVuelo,origen,destino,horaSalida,fechaInicio,fechaFin) VALUES(:numeroVuelo,:origen,:destino,:horaSalida,:fechaInicio,:fechaFin)');
			$consulta_insert->execute(array(
				':numeroVuelo' =>$numeroVuelo,
				':origen' =>$origen,
				':destino' =>$destino,
				':horaSalida' =>$horaSalida,
				':fechaInicio' =>$fechaInicio,
				':fechaFin' =>$fechaFin
			));            
            echo "<script> location.href='vueloprog_index.php'; </script>";
            exit;
			
		}else{
			echo "<script> alert('llenar los campos requeridos, -el origen y destino deben ser diferentes-');</script>";
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
        <h2>Programar un vuelo diario</h2>
        <hr>
        <div class="container">
            <form action="" method="post">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="origen">Aeropuerto de origen</label>
                        <select name="origen" id="origen" class="form-control" required>
                            <option value="">Seleccionar Origen</option>

                            <?php foreach($listAeropuerto as $fila):?>
                            <option value="<?php echo $fila['IATA_aeropuertoID']; ?>">
                                <?php echo $fila['nombreAeropuerto']; ?> (<?php echo $fila['IATA_aeropuertoID']; ?>) -
                                <?php echo $fila['nombreCiudad']; ?>
                            </option>

                            <?php endforeach ?>

                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="destino">Aeropuerto destino</label>
                        <select name="destino" id="destino" class="form-control" required>
                            <option value="">Seleccionar Destino</option>

                            <?php foreach($listAeropuerto as $fila):?>
                            <option value="<?php echo $fila['IATA_aeropuertoID']; ?>">
                                <?php echo $fila['nombreAeropuerto']; ?> (<?php echo $fila['IATA_aeropuertoID']; ?>) -
                                <?php echo $fila['nombreCiudad']; ?>
                            </option>

                            <?php endforeach ?>

                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-2 mb-3">
                        <label for="numeroVuelo">Número de vuelo</label>
                        <input type="text" name="numeroVuelo" id="numeroVuelo" class="form-control" required>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="horaSalida">Hora de Salida</label>
                        <input type="time" name="horaSalida" id="horaSalida" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fechaInicio">Fecha de inicio del ciclo</label>
                        <input type="date" name="fechaInicio" id="fechaInicio" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fechaFin">Fecha de cierre de ciclo</label>
                        <input type="date" name="fechaFin" id="fechaFin" class="form-control" required>
                    </div>

                </div>

                <div class="container">
                    <div class="text-right">
                        <a href="vueloprog_index.php" class="btn btn-link">Cancelar</a>
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