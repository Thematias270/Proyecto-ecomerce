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
         // Validaciones de la contraseña
         $password_valid = true;
         $errors = [];
 
         // Longitud mínima de la contraseña
         if (strlen($password) < 8) {
             $password_valid = false;
             $errors[] = "La contraseña debe tener al menos 8 caracteres.";
         }
 
         // Debe incluir al menos una letra mayúscula
         if (!preg_match('/[A-Z]/', $password)) {
             $password_valid = false;
             $errors[] = "La contraseña debe incluir al menos una letra mayúscula.";
         }
 
         // Debe incluir al menos una letra minúscula
         if (!preg_match('/[a-z]/', $password)) {
             $password_valid = false;
             $errors[] = "La contraseña debe incluir al menos una letra minúscula.";
         }
 
         // Debe incluir al menos un número
         if (!preg_match('/[0-9]/', $password)) {
             $password_valid = false;
             $errors[] = "La contraseña debe incluir al menos un número.";
         }
 
         // Debe incluir al menos un carácter especial
         if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $password)) {
             $password_valid = false;
             $errors[] = "La contraseña debe incluir al menos un carácter especial.";
         }
 
         if (!$password_valid) {
             echo "Errores de validación de contraseña:<br>";
             foreach ($errors as $error) {
                 echo $error . "<br>";
             }
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
