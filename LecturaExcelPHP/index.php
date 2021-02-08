<?php
/*Descomprimir PHPExcel.rar*/
session_start();
session_destroy();
session_unset();

include_once "complementos/header.php";
include_once "complementos/session.php"; ?>

<div class="container d-flex flex-column justify-content-center align-items-center mt-4" style="height: 100vh;">
	<div class="col-12 col-md-6 mx-auto mt-4">
		<form action="validacion.php" method="post">
			<div class="form-group">
				<label>Estados financieros</label>
				<input type="password"
						name="password"
						placeholder="Contraseña"
						class="form-control"
						required>
				<button type="submit"
						class="btn btn-success mt-2"
						name="estados">
					Visualizar datos
				</button>
			</div>
		</form>
		<form action="validacion.php" method="post">
			<div class="form-group">
				<label>Pagos provicionales</label>
				<input type="password"
						name="password"
						placeholder="Contraseña"
						class="form-control"
						required>
				<button type="submit"
						class="btn btn-success mt-2"
						name="pagos">
					Visualizar datos
				</button>
			</div>
		</form>
	</div>
</div>


<?php include_once "complementos/footer.php"; ?>