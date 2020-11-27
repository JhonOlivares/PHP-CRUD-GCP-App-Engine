<?php
	include_once 'controllers/conexion.php';

	$sentencia_select=$cone->prepare('SELECT * FROM avion A LEFT JOIN estado_avion EA ON A.estadoID=EA.estadoID ORDER BY fabricante');
	$sentencia_select->execute();
	$resultado=$sentencia_select->fetchAll();

	// metodo buscar
	if(isset($_POST['btn_buscar'])){
		$buscar_text=$_POST['buscar'];
		$select_buscar=$cone->prepare('
        SELECT * FROM avion A INNER JOIN estado_avion EA ON A.estadoID=EA.estadoID
        WHERE avionMatricula LIKE :campo OR modelo LIKE :campo OR serie LIKE :campo OR fabricante LIKE :campo OR EA.estado LIKE :campo
        ORDER BY fabricante'
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
        <h2>Aviones</h2>
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
        <a href="avion_create" class="btn btn-primary">Agregar Nuevo Avión</a>
        <div class="table-responsive-xl">
            <table class="table">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">Matricula</th>
                        <th scope="col">Fabricante/Modelo</th>
                        <th scope="col">Serie</th>
                        <th scope="col">Estado</th>
                        <th colspan="2">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($resultado as $fila):?>
                    <tr>
                        <td><?php echo $fila['avionMatricula']; ?></td>
                        <td><?php echo $fila['fabricante']; ?> <?php echo $fila['modelo']; ?></td>
                        <td><?php echo $fila['serie']; ?></td>
                        <td><?php echo $fila['estado']; ?></td>
                        <td>
                            <a href="avion_edit?id=<?php echo $fila['avionMatricula']; ?>"
                                class="btn btn-primary">Editar</a>
                        </td>
                        <td>
                            <a href="avion_eliminar?id=<?php echo $fila['avionMatricula']; ?>"
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