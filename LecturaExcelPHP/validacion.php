<?php
session_start();
$password = "$2y$05$2r8LGRFniFV3MYQMfrBXLO354N4dpEDHpVcXlcyq0/Q653RhyAi.S";
/*password_hash("Outlet2021$", PASSWORD_BCRYPT, ['cost'=>5]);*/

if(isset($_POST['estados']) || isset($_POST['pagos'])){
	if(password_verify($_POST['password'], $password)){
		$_SESSION['mensaje'] = "Bienvenido";
		$_SESSION['usuario'] = true;
		if(isset($_POST['estados'])){
			header('Location: estados.php');
		}
		elseif(isset($_POST['pagos'])){
			header('Location: pagos.php');
		}
	}else{
		$_SESSION['mensajeError'] = "Contraseña incorrecta";
		header('Location: index.php');
	}
}else{
	$_SESSION['mensajeError'] = "Acceso restringido";
	header('Location: index.php');
}