<?php
include('conexion.php');

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $query = mysqli_real_escape_string($conexion, $query);

    $sql = "SELECT * FROM productos WHERE nombre LIKE '%$query%' OR descripcion LIKE '%$query%'";
    $resultado = mysqli_query($conexion, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        echo "<section class='grid grid-cols-1 gap-6 p-4'>";

        while ($row = mysqli_fetch_assoc($resultado)) {
            echo "
            <div class='relative overflow-hidden rounded-lg group'>
                <img src='bd/uploads/" . htmlspecialchars(basename($row['imagen'])) . "' alt='Imagen del producto' class='object-cover w-full h-60'>
                <div class='p-4 bg-background'>
                    <h3 class='text-lg font-semibold md:text-xl'>" . htmlspecialchars($row['nombre']) . "</h3>
                    
                    <div class='flex items-center justify-between'>
                        <h4 class='text-base font-semibold md:text-lg'>$" . htmlspecialchars($row['precio']) . "</h4>
                        <button class='btn btn-sm add-to-cart'>Agregar al carrito</button>
                    </div>
                </div>
            </div>
            ";
        }

        echo "</section>";
    } else {
        echo "<p>No se encontraron resultados para '$query'</p>";
    }
    echo "</div>";
} else {
    echo "<p>Por favor, ingrese un término de búsqueda.</p>";
}
?>
<!-- <p class='text-sm text-muted-foreground'>" . htmlspecialchars($row['descripcion']) . "</p> -->