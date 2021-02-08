<?php
session_start();
include_once "complementos/header.php";
include_once "complementos/redirectIfNotSession.php";
include_once "complementos/session.php";
require_once 'PHPExcel/Classes/PHPExcel.php';


if(!empty($_GET['archivo'])){
    $nombreArchivo = $_GET['archivo'];
    $archivo = 'Archivos/'.$nombreArchivo;

    if(empty($nombreArchivo) || !file_exists($archivo)){
        $_SESSION['mensajeError'] = "Archivo no permitido";
		header('Location: index.php');
    }
}else{
	$_SESSION['mensajeError'] = "Acceso restringido, peticion no valida";
	header('Location: index.php');
}

$inputFileType = PHPExcel_IOFactory::identify($archivo);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objPHPExcel = $objReader->load($archivo);
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();



function calcular($sheet, $column, $row){

	$celda = $sheet->getCell($column.$row);
	$valor = $celda->getValue();
	if(strlen($valor) != 0){
		if($valor[0] == '='){
			return "<td>".number_format(round($celda->getCalculatedValue(), 0, PHP_ROUND_HALF_UP))."</td>";
		}
		if(gettype($valor) == 'double'){
			return "<td>".number_format(round($valor, 0, PHP_ROUND_HALF_UP))."</td>";
		}
		if(strlen($valor) > 1){
			return "<td class='text-white' style='background: rgba(0,0,255,0.3);'>".$valor."</td>";
		}
	}
	return "<td>".$valor."</td>";
}

 ?>



 <div class="container mt-4">
	<h4 class="my-3"><?php echo $sheet->getCell('A2')->getValue(); ?></h4>
	<h4 class="my-3"><?php echo $sheet->getCell('A3')->getValue(); ?></h4>
	<h6 class="my-3"><?php echo $sheet->getCell('A4')->getValue(); ?></h6>
	<h6 class="my-3"><?php echo $sheet->getCell('A5')->getValue(); ?></h6>
	<small><i><b><?php echo $_GET['archivo']; ?></b></i></small><br>
	<div class="panel panel-primary">

		<div class="panel-body">
			<div class="col-lg-12">

				<table class="table table-bordered">

					<tbody>

						<?php
						$num=0;
						for ($row = 8; $row <= $highestRow; $row++){ $num++;?>
							<tr>
								<th scope='row'><?php echo $num;?></th>
								<?php for($column = 'A'; $column < $highestColumn; $column++): ?>
									<?php  echo calcular($sheet, $column, $row); ?>
								<?php endfor; ?>
							</tr>
						<?php
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<?php include_once "complementos/footer.php"; ?>