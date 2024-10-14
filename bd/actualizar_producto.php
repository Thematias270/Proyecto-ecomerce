<?php 
require 'conexion.php';

$id = $_GET['id'];
$nombre = $_GET['nombre'];
$descripcion = $_GET['descripcion'];
$precio = $_GET['precio'];

if($_FILES['imagen']['name']){
    $rutaImagen = 'uploads/' . basename($_FILES['imagen']['name']);
    move_uploaded_file($_FILES['imagen']['tmp_name'],$rutaImagen);
    $query = "UPDATE productos SET nombre=$nombre,descripcion=$descripcion,precio=$precio,imagen=$rutaImagen WHERE id=$id";
}else{
    $query ="UPDATE productos SET nombre=$nombre,descripcion=$descripcion,precio=$precio WHERE id=$id";
}
if(mysqli_query($conexion,$query)){
    echo "Producto Actualizado Correctamente!!"
}else{
    echo "Error: " . mysqli_error($conexion);
}

?>