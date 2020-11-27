<?php 
    include_once 'controllers/conexion.php';
    
    //obtener el listado de paises
    $sentenciaGetContryList=$cone->prepare('SELECT * FROM pais ORDER BY nombrePais');
	$sentenciaGetContryList->execute();
	$listPaises=$sentenciaGetContryList->fetchAll();
	
	if(isset($_POST['guardar'])){
		$pasaporte=$_POST['pasaporte'];
		$nombre=$_POST['nombre'];
		$Apellido=$_POST['Apellido'];
		$sexo=$_POST['sexo'];
		$nacionalidad=$_POST['nacionalidad'];
		$telefono=$_POST['telefono'];
		$direccion=$_POST['direccion'];
		$e_mail=$_POST['e_mail'];

		if(!empty($nombre) && !empty($pasaporte)){
            if(empty($nacionalidad))
                {
                    $nacionalidad = null;
                }
			$consulta_insert=$cone->prepare('INSERT INTO cliente(pasaporte,nombre,Apellido,sexo,nacionalidad,telefono,direccion,e_mail) VALUES(:pasaporte,:nombre,:Apellido,:sexo,:nacionalidad,:telefono,:direccion,:e_mail)');
			$consulta_insert->execute(array(
				':pasaporte' =>$pasaporte,
				':nombre' =>$nombre,
				':Apellido' =>$Apellido,
				':sexo' =>$sexo,
				':nacionalidad' =>$nacionalidad,
				':telefono' =>$telefono,
				':direccion' =>$direccion,
				':e_mail' =>$e_mail
			));            
            echo "<script> location.href='cliente_index.php'; </script>";
            exit;
			
		}else{
			echo "<script> alert('el campo pasaporte y nombre no pueden ser nulos');</script>";
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
        <h2>Detalles del nuevo cliente</h2>
        <hr>
        <div class="container">
            <form action="" method="post">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="pasaporte">Pasaporte</label>
                        <input type="text" name="pasaporte" id="pasaporte" class="form-control" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="Apellido">Apellidos</label>
                        <input type="text" name="Apellido" id="Apellido" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="sexo">Sexo</label>
                        <select class="form-control" id="sexo" name="sexo">
                            <option value="0">Selecciona</option>
                            <option value="M">Masculino</option>
                            <option value="F">Femenino</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="nacionalidad">Nacionalidad</label>                        
                        <select name="nacionalidad" id="nacionalidad" class="form-control">
                            <option value="">Seleccionar Nacionalidad</option>


                            <?php foreach($listPaises as $fila):?>
                            <option value="<?php echo $fila['IATA_paisID']; ?>"><?php echo $fila['nombrePais']; ?></option>

                            <?php endforeach ?>

                        </select>
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="telefono">Telefono</label>
                        <input type="text" name="telefono" id="telefono" class="form-control">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="e_mail">Email</label>
                        <input type="email" name="e_mail" id="e_mail" class="form-control">
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control">
                    </div>

                </div>

                <div class="container">
                    <div class="text-right">
                        <a href="cliente_index.php" class="btn btn-link">Cancelar</a>
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