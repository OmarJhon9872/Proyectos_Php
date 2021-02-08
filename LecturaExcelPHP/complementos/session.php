<?php

if(isset($_SESSION['mensajeError'])){
	echo "
	<div class='row mt-4'>
		<div class='col-12 col-md-6 mx-auto mt-3'>
			<div class='alert alert-danger' role='alert'>
				".$_SESSION['mensajeError']."
			</div>
		</div>
	</div>";
	unset($_SESSION['mensajeError']);
}
if(isset($_SESSION['mensaje'])){
	echo "
	<div class='row mt-4'>
		<div class='col-12 col-md-6 mx-auto mt-3'>
			<div class='alert alert-success' role='alert'>
				".$_SESSION['mensaje']."
			</div>
		</div>
	</div>";
	unset($_SESSION['mensaje']);
}