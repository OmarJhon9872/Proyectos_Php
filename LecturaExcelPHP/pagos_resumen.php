<?php
session_start();
include_once "complementos/header.php";
include_once "complementos/redirectIfNotSession.php";
include_once "complementos/session.php";
require_once 'PHPExcel/Classes/PHPExcel.php';


if(!empty($_GET['archivo'])){
    $nombreArchivo = $_GET['archivo'];
    $archivo = 'Archivos/PAGOS PROVISIONALES/'.$nombreArchivo;

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
	$meses = array('enero','febrero','marzo','abril','mayo','junio','julio', 'agosto','septiembre','octubre','noviembre','diciembre');

	$pagosProvicionales = [];
	$ivaAFavor = [];
	$retenciones = [];
	$celda = $sheet->getCell($column.$row);
	$valor = $celda->getValue();
	if(strlen($valor) != 0){
		if($valor[0] == '='){
			return number_format(round($celda->getCalculatedValue(), 0, PHP_ROUND_HALF_UP));
		}
		if(gettype($valor) == 'double'){
			return number_format(round($valor, 0, PHP_ROUND_HALF_UP));
		}
		if( $valor == 'Pago provisional del ISR a pagar' ||
			$valor == 'I.V.A. A FAVOR ACUM.' ||
			$valor == 'SUMA'){

			/*Calculamos las 12 columnas (meses del año)*/
			$finalColumn = $column;
			for($i=0;$i<12;$i++){
				++$finalColumn;
			}

			$indice = 0;
			for($position = (++$column); $position<=$finalColumn; $position++){

				if($valor == 'Pago provisional del ISR a pagar'){
					$celda = $sheet->getCell($position.$row);
					$resultado = number_format(round($celda->getCalculatedValue(), 0, PHP_ROUND_HALF_UP));
					if($resultado != 0){
						$pagosProvicionales[$meses[$indice]] = $resultado;
					}else{
						break;
					}
				}
				if($valor == 'I.V.A. A FAVOR ACUM.'){
					$rowRes = $row;
					$celda = $sheet->getCell($position.++$rowRes);
					$resultado = number_format(round($celda->getCalculatedValue(), 0, PHP_ROUND_HALF_UP));

					if($resultado != 0){
						$ivaAFavor[$meses[$indice]] = $resultado;
					}else{
						break;
					}
				}
				if($valor == 'SUMA'){
					$celda = $sheet->getCell($position.$row);
					$resultado = number_format(round($celda->getCalculatedValue(), 0, PHP_ROUND_HALF_UP));
					if($resultado != 0){
						$retenciones[$meses[$indice]] = $resultado;
					}else{
						break;
					}
				}
				$indice++;
			}
			if(count($pagosProvicionales) > 0){
				mostrar($pagosProvicionales, $valor);
				$pagosProvicionales = [];
			}
			if(count($ivaAFavor) > 0){
				mostrar($ivaAFavor, $valor);
				$ivaAFavor = [];
			}
			if(count($retenciones) > 0){
				mostrar($retenciones, $valor);
				$retenciones = [];
			}


		}
	}
	return $valor;
}

function mostrar($variable, $titulo){
	if($titulo == 'SUMA'){
		$titulo = 'Retenciones de ISR';
	}
	echo "
	<tr>
		<td colspan='2' class='table-inverse text-white'><b>$titulo</b></td>
	</tr>
	";
	foreach ($variable as $mes => $cantidad) {
		echo "
		<tr>
			<td>$mes</td>
			<td>$cantidad</td>
		</tr>
		";
	}
}
?>

<div class="container mt-4">
	<h4 class="my-3"><?php echo $sheet->getCell('A3')->getValue(); ?></h4>
	<div class="panel panel-primary">

		<div class="panel-body">
			<div class="col-lg-12">

				<table class="table table-bordered">

					<tbody>

						<?php
						$num=0;
						for ($row = 2; $row <= $highestRow; $row++){ $num++;?>
							<!-- <tr>
								<th scope='row'><?php echo $num;?></th> -->
								<?php for($column = 'A'; $column < $highestColumn; $column++): ?>
									<?php  calcular($sheet, $column, $row); ?>
								<?php endfor; ?>
							<!-- </tr> -->
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