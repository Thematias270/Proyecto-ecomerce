<?php
session_start();
require 'conexion.php';

if(!isset($_SESSION['rol'])|| $_SESSION['rol'] !== 'admin'){
    header('Location: ../index.php');
    exit;
}


$id = $_GET['id'];
$query = "DELETE FROM productos WHERE id=$id";

if(mysqli_query($conexion,$query)){
    echo "Producto Eliminado Correctamente!!";
}else{
    echo "Error: " . mysqli_error($conexion);
}


?>