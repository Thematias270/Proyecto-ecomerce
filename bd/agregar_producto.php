<?php
session_start();
require 'conexion.php';

// Verifica si el usuario está autenticado y tiene el rol de admin
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit(); // Asegúrate de salir después de redirigir
}

// Manejo del formulario al enviar datos
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $descripcion = mysqli_real_escape_string($conexion, $_POST['descripcion']);
    $precio = mysqli_real_escape_string($conexion, $_POST['precio']);

    // Manejo de la imagen
    if ($_FILES['imagen']['name']) {
        $rutaImagen = 'uploads/' . basename($_FILES['imagen']['name']);
        if (move_uploaded_file($_FILES['imagen']['tmp_name'], $rutaImagen)) {
            // Inserta el producto en la base de datos
            $query = "INSERT INTO productos (nombre, descripcion, precio, imagen) VALUES ('$nombre', '$descripcion', '$precio', '$rutaImagen')";
            if (mysqli_query($conexion, $query)) {
                header('Location: ../index.php');
                echo "Producto agregado correctamente!!";
            } else {
                echo "Error al agregar el producto: " . mysqli_error($conexion); // Corrige el error de mysqli_query
            }
        } else {
            echo "Error al subir la imagen.";
        }
    } else {
        echo "No se ha seleccionado ninguna imagen.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <!-- <link rel="stylesheet" href="path/to/tu/stylesheet.css">  -->
</head>
<body>
    <div class="container">
        <h2>Agregar Nuevo Producto</h2>
        <form action="agregar_producto.php" method="POST" enctype="multipart/form-data">
            <div>
                <label for="nombre">Nombre:</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div>
                <label for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" required></textarea>
            </div>
            <div>
                <label for="precio">Precio:</label>
                <input type="number" id="precio" name="precio" step="0.01" required>
            </div>
            <div>
                <label for="imagen">Imagen:</label>
                <input type="file" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <button type="submit">Agregar Producto</button>
        </form>
    </div>
</body>
</html>
