<?php
date_default_timezone_set('America/Mexico_City');
setlocale (LC_TIME, 'es_ES.UTF-8');
session_start();
include_once "complementos/header.php";
include_once "complementos/redirectIfNotSession.php";
include_once "complementos/session.php";
?>
<div class="container">
	<div class="row">
		<div class="col-12 mx-auto mt-4">
			<div class="botones col-12">
				<h3 class="col-12 col-md-8">Estado de resultados</h3>
				<a href="index.php" class="btn btn-danger col-3 col-md-4 mx-auto my-2">
					Salir
				</a>
			</div>
			<table class="table table-responsive col-12 col-md-10 mx-auto table-striped " style="width: max-content;">
				<thead class="table-inverse">
					<tr>
						<th>Archivo</th>
						<th>Modificado hace:</th>
						<th>Descargar</th>
						<th>Visualizar</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$ruta = 'Archivos/ESTADOS FINANCIEROS/';
					if ($directorio = opendir($ruta)) {
					    while (false !== ($archivo = readdir($directorio))) {
				        	if(count(explode('ESTADOS FINANCIEROS', $archivo)) == 2 ){
				        		echo "
				        			<tr>
				        				<td><b>Carpeta: ".$archivo."</b></td>
				        				<td>
				        					-
				        				</td>
				        				<td>
				        					-
				        				</td>
				        				<td>
				        					-
				        				</td>
				        			</tr>
				        		";
				        		if ($directorio2 = opendir($ruta.$archivo)) {
				    				while (false !== ($archivo2 = readdir($directorio2))) {
				    					if (count(explode('ESTADOS FINANCIEROS', $archivo2)) == 2 ) {
				    						if($archivo2[0] == '~') continue;

				    						$fecha1 = new DateTime(date('Y-m-d h:i:s', filemtime($ruta.$archivo."/".$archivo2)));
				    						$fecha2 = new DateTime(date('Y-m-d h:i:s'));
				    						$hace = $fecha1->diff($fecha2)->y." años";
				    						if(explode(' ', $hace)[0] == 0){
					    						$hace = $fecha1->diff($fecha2)->days." dias";
					    						if(explode(' ', $hace)[0] == 0){
					    							$hace = $fecha1->diff($fecha2)->h." horas";
					    							if(explode(' ', $hace)[0] == 0){
					    								$hace = $fecha1->diff($fecha2)->i." minutos";
					    								if(explode(' ', $hace)[0] == 0){
					    									$hace = $fecha1->diff($fecha2)->s." segundos";
					    								}
					    							}
					    						}
					    					}
					    					echo "
							        			<tr>
							        				<td>-> ".$archivo2."</td>
							        				<td>
							        					".$hace."
							        				</td>
							        				<td>
							        					<a href='descargar_archivo.php?archivo=ESTADOS FINANCIEROS/$archivo/$archivo2'
							        						class='btn btn-success btn-sm'>
							        						Descargar fichero
							        					</a>
							        				</td>
							        				<td>
							        					<a href='visualizar_estado.php?archivo=ESTADOS FINANCIEROS/$archivo/$archivo2'
							        						class='btn btn-primary btn-sm'>
							        						Ver
							        					</a>
							        				</td>
							        			</tr>
							        		";
							        	}
				    				}
				    			}
				        	}

					    }
					    closedir($directorio);
					}else{
						echo "
						<tr><td colspan='3'>
							No hay archivos por el momento
						</td></tr>";
					}

					?>

				</tbody>
			</table>
		</div>
	</div>
</div>

<?php include_once "complementos/footer.php"; ?>