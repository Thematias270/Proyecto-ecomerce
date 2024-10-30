<?php
session_start();
require 'conexion.php'; // Conectar a la base de datos

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $email = $_POST['email'];
    
    // Aquí puedes agregar lógica para guardar la compra en la base de datos,
    // enviar un correo electrónico al usuario, etc.
    
    // Ejemplo de inserción en la base de datos (ajusta según tu estructura):
    $query = "INSERT INTO compras (nombre, direccion, email, total) VALUES ('$nombre', '$direccion', '$email', '".$_SESSION['cart_total']."')";
    mysqli_query($conexion, $query);

    // Limpiar el carrito
    unset($_SESSION['cart']);
    
    // Redirigir a una página de éxito o mostrar un mensaje
    header('Location: compra_exitosa.php');
    exit;
}
