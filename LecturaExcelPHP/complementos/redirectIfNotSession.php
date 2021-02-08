<?php
if(!isset($_SESSION['usuario'])){
	session_unset();
	session_start();
	header('Location: index.php');
}