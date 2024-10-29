<?php 
require 'conexion.php';

// Verificar que el ID se haya pasado
if (!isset($_GET['id'])) {
    echo "Error: No se proporcionó un ID.";
    exit;
}

$id = $_GET['id'];
$nombre = $_POST['nombre'];
$descripcion = $_POST['descripcion'];
$precio = $_POST['precio'];

// Escapar los valores para evitar inyecciones SQL
$nombre = mysqli_real_escape_string($conexion, $nombre);
$descripcion = mysqli_real_escape_string($conexion, $descripcion);
$precio = mysqli_real_escape_string($conexion, $precio);

if ($_FILES['imagen']['name']) {
    $rutaImagen = 'uploads/' . basename($_FILES['imagen']['name']);
    
    // Subir la imagen al servidor
    if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
        // Actualizar con la nueva imagen
        $query = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio', imagen='$rutaImagen' WHERE id=$id";
    } else {
        echo "Error al subir la imagen.";
        exit;
    }
} else {
    // Actualizar sin cambiar la imagen
    $query = "UPDATE productos SET nombre='$nombre', descripcion='$descripcion', precio='$precio' WHERE id=$id";
}

// Ejecutar la consulta
if (mysqli_query($conexion, $query)) {
    echo "Producto actualizado correctamente!!";
    header('Location: ../index.php');
} else {
    echo "Error: " . mysqli_error($conexion);
}
?>
