<?php

$filename = "archivoData.txt";
/*Verificamos si tenemos permisos de escritura sobre el archivo*/
if (is_writable($filename)) {
    /*Comprobamos es legible*/
    if (!$fp = fopen($filename, 'a')) {
        echo "No se puede abrir en el archivo ($filename)";
        exit;
    }
    /*Leemos la data que se reciba en formato JSON*/
    $json = file_get_contents('php://input');
    /*Decodeamos para hacer entendible por php a nivel de array*/
    $data = json_decode($json, true);
    /*Escribimos la data en el archivo*/
    foreach ($data as $key => $value) {
        fwrite($fp, "- ".$key ." => ". $value."\n");
    }

    echo "Listo, todo agregado al archivo ($filename)";
    /*Cerramos la lectura y se libera memora buffer de lectura-escritura*/
    fclose($fp);
} else {
    echo "El archivo $filename no tiene permisos de escritura";
}
