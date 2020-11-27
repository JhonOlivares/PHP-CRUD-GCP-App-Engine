<?php
	include_once 'controllers/conexion.php';

	$sentencia_select=$cone->prepare('SELECT * FROM vuelo_programado ORDER BY numeroVuelo');
	$sentencia_select->execute();
	$resultado=$sentencia_select->fetchAll();

	// metodo buscar
	if(isset($_POST['btn_buscar'])){
		$buscar_text=$_POST['buscar'];
		$select_buscar=$cone->prepare('
			SELECT * FROM vuelo_programado WHERE numeroVuelo LIKE :campo OR origen LIKE :campo OR destino LIKE :campo;'
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
        <h2>Vuelos Estandar</h2>
        <hr>
        <div class="container">
            <form action="" class="formulario" method="post">


                <div class="form-row">
                    <div class="col-md-10 mb-3">
                        <input type="text" name="buscar" placeholder="Buscar por número de vuelo o código de aeropuerto"
                            value="<?php if(isset($buscar_text)) echo $buscar_text; ?>" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <button class="btn btn-outline-primary" type="submit" name="btn_buscar">Buscar</button>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <a href="vueloprog_create.php" class="btn btn-primary">Programar nuevo vuelo</a>
        <div class="table-responsive-xl">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Número</th>
                        <th scope="col">Origen</th>
                        <th scope="col">Destino</th>
                        <th scope="col">Hora</th>
                        <th scope="col">Fecha Inicio</th>
                        <th scope="col">Fecha Fin</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($resultado as $fila):?>
                    <tr>
                        <td><?php echo $fila['numeroVuelo']; ?></td>
                        <td><?php echo $fila['origen']; ?></td>
                        <td><?php echo $fila['destino']; ?></td>
                        <td><?php echo $fila['horaSalida']; ?></td>
                        <td><?php echo $fila['fechaInicio']; ?></td>
                        <td><?php echo $fila['fechaFin']; ?></td>
                        <td>
                            <a href="vueloprog_edit.php?id=<?php echo $fila['numeroVuelo']; ?>"
                                class="btn btn-primary">Editar</a>
                        </td>
                        <td>
                            <a href="vueloprog_eliminar.php?id=<?php echo $fila['numeroVuelo']; ?>"
                                class="btn btn-danger"
                                onclick="return confirm('Está seguro de elimiar el registro?');">Eliminar</a>
                        </td>
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