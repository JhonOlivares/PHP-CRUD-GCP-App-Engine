<?php
	// if you are in localhost
	if($_SERVER['HTTP_HOST'] == 'localhost'){
		$database="dbaerolinea";
		$user='root';
		$password='';


		try {
			
			//localhost
			$cone=new PDO('mysql:host=localhost;dbname='.$database,$user,$password);

			

		} catch (PDOException $e) {
			echo "Error".$e->getMessage();
		}
	}
	else{
		// conexion a Cloud SQL: ver las varibles de entorno en el archivo app.yaml
		$dsn = getenv('MYSQL_DSN');
		$user = getenv('MYSQL_USER');
		$password = getenv('MYSQL_PASSWORD');

		if(!isset($dsn, $user) || false === $password){
			throw new Exception('set MYSQL_DSN, MYSQL_USER, and MYSQL_PASSWORD environment variables');
		}

		try {
			
			$cone=new PDO($dsn, $user, $password);

		} catch (PDOException $e) {
			echo "Error".$e->getMessage();
		}

	}
	

?>