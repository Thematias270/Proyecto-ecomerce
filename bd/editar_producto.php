<?php
session_start();
require 'conexion.php';

// Verificar si el usuario es administrador
if (!isset($_SESSION['rol']) || $_SESSION['rol'] !== 'admin') {
    header('Location: ../index.php');
    exit;
}

// Verificar si el ID fue pasado correctamente
if (!isset($_GET['id'])) {
    echo "Error: No se proporcionó un ID de producto.";
    exit;
}

$id = $_GET['id'];

// Consulta para obtener los detalles del producto
$query = "SELECT * FROM productos WHERE id = $id";
$resultado = mysqli_query($conexion, $query);

// Verificar si la consulta fue exitosa y si el producto existe
if ($resultado && mysqli_num_rows($resultado) > 0) {
    $producto = mysqli_fetch_assoc($resultado); // Producto encontrado
} else {
    echo "Error: Producto no encontrado o consulta fallida.";
    exit;
}

?>

<!-- HTML para el formulario de edición del producto -->
<form action="actualizar_producto.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
    <input type="text" name="nombre" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
    <textarea name="descripcion" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
    <input type="number" name="precio" value="<?php echo htmlspecialchars($producto['precio']); ?>" step="0.01" required>
    <input type="file" name="imagen">
    <button type="submit">Actualizar</button>
</form>

