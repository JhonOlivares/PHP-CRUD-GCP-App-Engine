<?php
    include_once 'controllers/conexion.php';
	
	$resultado=array();

	// metodo buscar
	if(isset($_POST['btn_buscar'])){
        $origen=$_POST['origen'];
        $destino=$_POST['destino'];
        $fecha=$_POST['fecha'];
		$select_buscar=$cone->prepare('
        SELECT VP.numeroVuelo, origen, destino, horaSalida, AO.nombreAeropuerto aeropuertoOrigen, AD.nombreAeropuerto aeropuertoDestino,
        CO.nombreCiudad ciudadOrigen, CD.nombreCiudad ciudadDestino, CO.IATA_paisID paisOrigen, CD.IATA_paisID paisDestino
        FROM vuelo_programado VP
        INNER JOIN aeropuerto AO on VP.origen = AO.IATA_aeropuertoID
        INNER JOIN aeropuerto AD on VP.destino = AD.IATA_aeropuertoID
        INNER JOIN ciudad CO ON AO.ciudadID = CO.ciudadID
        INNER JOIN ciudad CD ON AD.ciudadID = CD.ciudadID
        INNER JOIN pais PO ON CO.IATA_paisID = PO.IATA_paisID
        INNER JOIN pais PD ON CD.IATA_paisID = PD.IATA_paisID

        WHERE (origen LIKE :campo OR AO.nombreAeropuerto LIKE :campo OR CO.nombreCiudad LIKE :campo OR PO.nombrePais LIKE :campo) AND
        (destino LIKE :campo2 OR AD.nombreAeropuerto LIKE :campo2 OR CD.nombreCiudad LIKE :campo2 OR PD.nombrePais LIKE :campo2) AND
        VP.fechaInicio <= :ufecha AND VP.fechaFin >= :ufecha'
		);

		$select_buscar->execute(array(
			':campo' =>"%".$origen."%", ':campo2' =>"%".$destino."%", ':ufecha' =>$fecha
		));

		$resultado=$select_buscar->fetchAll();

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

    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="img/pic1.png" alt="First slide">
                <div class="carousel-caption d-none d-md-block">
                    <h1>LLEGÓ EL NUEVO ESTÁNDAR PARA EL CUIDADO DE LA SALUD</h1>
                    <p>Prepárese para experimentar Perú CareStandard℠ en cada paso del viaje.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/pic2.png" alt="Second slide">
                <div class="carousel-caption d-none d-md-block">
                    <h1>MÁS ESPACIO PARA UN VIAJE SEGURO</h1>
                    <p>Continuaremos bloqueando los asientos del pasillo intermedio y limitaremos la cantidad de
                        pasajeros a bordo hasta el 30 de marzo de 2021.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="img/pic3.png" alt="Third slide">
                <div class="carousel-caption d-none d-md-block">
                    <h1>VIAJA A TODO EL MUNDO</h1>
                    <p>Conoce grandes ciudades y lugares turísticos al más bajo precio.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>

    



    
    <br>



    <div class="container">
        <h2>Busca un vuelo disponible</h2>

        <!-- Barra de busqueda -->
        <div class="container">
            <form action="" method="post">
                <div class="form-row">
                    <div class="col-md-4 mb-3">
                        <label for="origen">Origen</label>
                        <input type="text" name="origen" id="origen" value="<?php if(isset($origen)) echo $origen; ?>"
                            class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="destino">Destino</label>
                        <input type="text" name="destino" id="destino"
                            value="<?php if(isset($destino)) echo $destino; ?>" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="fecha">Fecha</label>
                        <input type="date" name="fecha" id="fecha" value="<?php if(isset($fecha)) echo $fecha; ?>"
                            class="form-control" required>
                    </div>
                </div>


                <div class="container">
                    <div class="text-right">
                        <input type="submit" class="btn btn-primary" value="Buscar" name="btn_buscar" />
                    </div>
                </div>
                
            </form>
        </div>

        <!-- FIN Barra de busqueda -->



        



        <?php foreach($resultado as $fila):?>
            <hr>
        <div class="shadow-sm p-3 mb-3 bg-white rounded">
            <div class="form-row">
                <div class="col-md-12 d-flex justify-content-center">
                    <h2><?php echo $fila['numeroVuelo']; ?></h2>
                </div>
            </div>
            <div class="form-row">
                <div class="col-md-5 mb-3">
                    <div class="text-center">
                        <label class="h4"><?php echo $fila['origen']; ?></label>
                        <img src="img/departure.png" alt="logo" width="25">
                    </div>
                    <div class="text-left">
                        <label class="h5"><?php echo $fila['aeropuertoOrigen']; ?></label>
                    </div>
                    <div class="text-left">
                        <label><?php echo $fila['ciudadOrigen']; ?> - <?php echo $fila['paisOrigen']; ?></label>
                    </div>
                </div>
                <div class="col-md-2 mb-3">
                    <div class="col-md-12 d-flex justify-content-center">
                        <label><?php if(isset($fecha)) echo $fecha; ?></label>
                    </div>
                    <div class="text-center">
                        <label><?php echo $fila['horaSalida']; ?></label>
                    </div>
                    <div class="text-center">
                        <img src="img/vuelo.png" alt="logo">
                    </div>
                </div>
                <div class="col-md-5 mb-3">
                    <div class="text-center">
                        <img src="img/arrival.png" alt="logo" width="25">
                        <label class="h4"><?php echo $fila['destino']; ?></label>
                    </div>
                    <div class="text-right">
                        <label class="h5"><?php echo $fila['aeropuertoDestino']; ?></label>
                    </div>
                    <div class="text-right">
                        <label><?php echo $fila['ciudadDestino']; ?> - <?php echo $fila['paisDestino']; ?></label>
                    </div>
                </div>
            </div>
        </div>

        <?php endforeach ?>


    </div>







    <?php    
    include_once 'includes/3_footer.php';
    ?>
    <?php
    include_once 'includes/4_js.php';
    ?>

</body>

</html>