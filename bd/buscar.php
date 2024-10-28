<?php

include('conexion.php');

if(isset($_GET['query'])){
    $query = $_GET['query'];

    $query = mysqli_real_escape_string($conexion,$query);

    $sql = "SELECT * FROM productos WHERE nombre LIKE '%$query%' OR descripcion LIKE '%$query%'";
    $resultado = mysqli_query($conexion,$sql);

    if(mysqli_num_rows($resultado) > 0){
        echo "<h2> Resultados para '$query':</h2>";
        echo "<div class='row'>";

        while($row = mysqli_fetch_assoc($resultado)){
            echo "
            <div class='col-md-4'>
                <div class='card mb-4'>
                    <img src='" .$row['imagen'] . "' class='card-img-top' alt='" . $row['nombre'] . "'>
                    <div class=' card-body'>
                        <h5 class='card-title'>" . $row['nombre'] . "</h5>
                        <p class='card-text'>" . substr($row['descripcion'], 0, 100) . "...</p>
                        <a href='producto.php?id=" . $row['id'] . "' class='btn btn-primary'>Ver más</a>
                    </div>
                </div>
            </div>
            ";
        }

        echo "</div>";
    }else{
        echo "<h2> No se encontraron resultados para '$query'</h2>";
    }
}else{
    echo "<h2>Por favor, ingrese un término de búsqueda.</h2>";
}




?>