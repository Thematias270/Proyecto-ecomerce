<?php
session_start();
include 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validar que los datos están presentes
    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['confirm_password'])) {
        $nombre = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        // Verificar si las contraseñas coinciden
        if ($password !== $confirm_password) {
            echo "Las contraseñas no coinciden.";
            exit;
        }

        // Verificar si el email ya está registrado
        $query = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conexion->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "El correo electrónico ya está registrado.";
        } else {
            // Cifrar la contraseña
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo usuario en la base de datos
            $query = "INSERT INTO usuarios (nombre, email, password, rol) VALUES (?, ?, ?, 'user')";
            $stmt = $conexion->prepare($query);
            $stmt->bind_param('sss', $nombre, $email, $hashed_password);

            if ($stmt->execute()) {
                echo "Usuario registrado correctamente.";
                // Opcionalmente, redirigir a la página de inicio de sesión
                header('Location: ../index.php');
            } else {
                echo "Error al registrar el usuario.";
            }
        }
    } else {
        echo "Todos los campos son requeridos.";
    }
}
?>
