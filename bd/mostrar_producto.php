<?php
require 'conexion.php';

$query = "SELECT * FROM productos";
$resultado = mysqli_query($conexion,$query);
?>

<div class="container">
    <h2>Lista de productos</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>descripcion</th>
                <th>Precio</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while($producto = mysqli_fetch_assoc($resultado)) : ?>
                <tr>
                    <td><?php echo $producto['nombre']; ?></td>
                    <td><?php echo $producto['descripcion']; ?></td>
                    <td><?php echo $producto['precio']; ?></td>
                    <td><?php echo $producto['precio']; ?></td>
                    <td><img src="<?php echo $producto['imagen']; ?>"alt="Imagen del producto" width="100"></td>
                    <td>
                        <a href="editar_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-warning">Editar</a>
                        <a href="eliminar_producto.php?id=<?php echo $producto['id']; ?>" class="btn btn-warning">Eliminar</a>
                    </td>
                </tr>
                <?php endwhile;?>
        </tbody>
    </table>
</div>