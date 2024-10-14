<?php
session_start();
require 'conexion.php';
if(!isset($_SESSION['rol'])|| $_SESSION['rol'] !== 'admin'){
    header('Location: ../index.php')
}

$id = $_GET['id'];
$query = "SELECT * FROM productos WHERE id = $id";
$resultado = mysqli_query($conexion,$query);
$producto = mysqli_fetch_assoc($resultado);
?>
<div class="container">
    <h2>Editar Producto</h2>
    <form action="actualizar_producto.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
        <input type="text" name="nombre" value="<?php echo $producto['nombre']; ?> required">
        <textarea name="descripcion" required><?php echo $producto['descripcion'];?></textarea>
        <input type="number" name="precio" value="<?php echo $producto['precio'];?>" step="0.01" required>
        <input type="file" name="imagen">
        <button type="submit">Actualizar</button>
    </form>
</div>