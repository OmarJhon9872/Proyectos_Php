<?php
session_start();
include_once "complementos/redirectIfNotSession.php";


if(!empty($_GET['archivo'])){
    $nombreArchivo = $_GET['archivo'];
    $rutaArchivo = 'Archivos/'.$nombreArchivo;
    $obtenerExtension = explode('.', $nombreArchivo);


    if(!empty($nombreArchivo) &&
        file_exists($rutaArchivo) &&
        count($obtenerExtension) == 2 &&
        (end($obtenerExtension) == 'xls' || end($obtenerExtension) == 'xlsx')){
        // Define headers
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$nombreArchivo");
        if(end($obtenerExtension) == 'xls'){
            header("Content-Type: application/vnd.ms-excel");
        }elseif(end($obtenerExtension) == 'xlsx'){
            header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        }else{
            $_SESSION['mensajeError'] = "Extension no permitida";
            header("Location: index.php");
        }
        header("Content-Transfer-Encoding: binary");

        // Read the file
        readfile($rutaArchivo);
        exit;
    }else{
        $_SESSION['mensajeError'] = "Acceso restringido a otros archivos";
        header('Location: index.php');
    }
}else{
    $_SESSION['mensajeError'] = "Descarga restringida";
    header('Location: index.php');
}