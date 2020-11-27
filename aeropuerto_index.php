<?php
	include_once 'controllers/conexion.php';

	$sentencia_select=$cone->prepare('SELECT * FROM aeropuerto INNER JOIN ciudad ON aeropuerto.ciudadID=ciudad.ciudadID ORDER BY nombreAeropuerto');
	$sentencia_select->execute();
	$resultado=$sentencia_select->fetchAll();

	// metodo buscar
	if(isset($_POST['btn_buscar'])){
		$buscar_text=$_POST['buscar'];
		$select_buscar=$cone->prepare('
        SELECT * FROM aeropuerto INNER JOIN ciudad ON aeropuerto.ciudadID=ciudad.ciudadID WHERE nombreAeropuerto LIKE :campo OR IATA_aeropuertoID LIKE :campo ORDER BY nombreAeropuerto;'
		);

		$select_buscar->execute(array(
			':campo' =>"%".$buscar_text."%"
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


    <br>
    <div class="container shadow p-3 mb-5 bg-white rounded">
        <h2>Aeropuertos</h2>
        <hr>
        <div class="container">
            <form action="" class="formulario" method="post">


                <div class="form-row">
                    <div class="col-md-10 mb-3">
                        <input type="text" name="buscar" value="<?php if(isset($buscar_text)) echo $buscar_text; ?>"
                            class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button class="btn btn-outline-primary" type="submit" name="btn_buscar">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="table-responsive-xl">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Código IATA</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Ciudad</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($resultado as $fila):?>
                    <tr>
                        <td><?php echo $fila['IATA_aeropuertoID']; ?></td>
                        <td><?php echo $fila['nombreAeropuerto']; ?></td>
                        <td><?php echo $fila['nombreCiudad']; ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
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