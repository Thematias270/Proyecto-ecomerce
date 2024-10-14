<?php
session_start();
include 'conexion.php'; 

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['email']) && isset($_POST['password'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if ($conexion) {
            $query = "SELECT * FROM usuarios WHERE email = ?";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();

            if($user && password_verify($password, $user['password'])){
                session_regenerate_id();
                $_SESSION['usuario'] = $user['nombre'];
                $_SESSION['rol'] = $user['rol'];

                header('Location: ../index.php');
            } else {
                echo 'Credenciales Incorrectas';
            }
        } else {
            echo "Error en la conexión a la base de datos.";
        }
    } else {
        echo "Correo electrónico y contraseña son requeridos.";
    }
}
?>
