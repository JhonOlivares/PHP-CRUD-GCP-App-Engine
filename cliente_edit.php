<?php
	include_once 'controllers/conexion.php';

	if(isset($_GET['id'])){
		$id=(int) $_GET['id'];

		$buscar_id=$cone->prepare('SELECT * FROM cliente LEFT JOIN pais ON cliente.nacionalidad = pais.IATA_paisID WHERE clienteID=:id LIMIT 1');
		$buscar_id->execute(array(
			':id'=>$id
		));
        $resultado=$buscar_id->fetch();
        

        //para obtener el listado de nacionalidades
        $sentenciaGetContryList=$cone->prepare('SELECT * FROM pais ORDER BY nombrePais');
	    $sentenciaGetContryList->execute();
	    $listPaises=$sentenciaGetContryList->fetchAll();
    }
    
    else{
        echo "<script> location.href='cliente_index.php'; </script>";
        exit;
	}


	if(isset($_POST['guardar'])){
		$pasaporte=$_POST['pasaporte'];
		$nombre=$_POST['nombre'];
		$Apellido=$_POST['Apellido'];
		$sexo=$_POST['sexo'];
		$nacionalidad=$_POST['nacionalidad'];
		$telefono=$_POST['telefono'];
		$direccion=$_POST['direccion'];
		$e_mail=$_POST['e_mail'];
		$id= (int) $_GET['id'];

		if(!empty($nombre) && !empty($pasaporte)){
                if(empty($nacionalidad))
                {
                    $nacionalidad = null;
                }
				$consulta_update=$cone->prepare('UPDATE cliente SET
					pasaporte=:pasaporte,
					nombre=:nombre,
					Apellido=:Apellido,
                    telefono=:telefono,
                    e_mail=:e_mail,
                    sexo=:sexo,
                    direccion=:direccion,
                    nacionalidad=:nacionalidad
					WHERE clienteID=:id;'
				);
				$consulta_update->execute(array(
					':pasaporte' =>$pasaporte,
					':nombre' =>$nombre,
					':Apellido' =>$Apellido,
                    ':telefono' =>$telefono,
                    ':e_mail' =>$e_mail,
                    ':sexo' =>$sexo,
                    ':direccion' =>$direccion,
                    ':nacionalidad' =>$nacionalidad,
					':id' =>$id
				));
				echo "<script> location.href='cliente_index.php'; </script>";
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
        <h2>Editar: <?php if($resultado) echo $resultado['nombre']; ?> <?php if($resultado) echo $resultado['Apellido']; ?></h2>
        <hr>
        <div class="container">
            <form action="" method="post">
                <div class="form-row">
                    <div class="col-md-3 mb-3">
                        <label for="pasaporte">Pasaporte</label>
                        <input type="text" name="pasaporte" id="pasaporte" class="form-control"
                        value="<?php if($resultado) echo $resultado['pasaporte']; ?>" required>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control"
                        value="<?php if($resultado) echo $resultado['nombre']; ?>" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="Apellido">Apellidos</label>
                        <input type="text" name="Apellido" id="Apellido" class="form-control"
                        value="<?php if($resultado) echo $resultado['Apellido']; ?>" >
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="sexo">Sexo</label>
                        <select class="form-control" id="sexo" name="sexo">
                            <option value="">Selecciona</option>
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
                        <input type="text" name="telefono" id="telefono" class="form-control"
                        value="<?php if($resultado) echo $resultado['telefono']; ?>" >
                    </div>
                    <div class="col-md-2 mb-3">
                        <label for="e_mail">Email</label>
                        <input type="email" name="e_mail" id="e_mail" class="form-control" 
                        value="<?php if($resultado) echo $resultado['e_mail']; ?>" >
                    </div>
                    <div class="col-md-5 mb-3">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" id="direccion" class="form-control"
                        value="<?php if($resultado) echo $resultado['direccion']; ?>" >
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
<script>
    window.addEventListener("load", selectElement('sexo', '<?php if($resultado) echo strval($resultado['sexo']); ?>'), false);
    window.addEventListener("load", selectElement('nacionalidad', '<?php if($resultado) echo strval($resultado['nacionalidad']); ?>'), false);

    function selectElement(idr, valueToSelect) {
        let element = document.getElementById(idr);
        element.value = valueToSelect;
    }
</script>
</html>