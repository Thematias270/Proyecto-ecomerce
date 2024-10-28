<?php
session_start();
require 'bd/conexion.php'; // Conectar a la base de datos

// Consulta para obtener los productos
$query = "SELECT * FROM productos";
$resultado = mysqli_query($conexion, $query);

if ($resultado) {
    $productos = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $productos[] = $row;
    }
} else {
    echo "Error en la consulta: " . mysqli_error($conexion);
    exit;
}

$autenticado = isset($_SESSION['usuario']);
$isAdmin = false;

// Verificar si el usuario es administrador
if($autenticado){
    $isAdmin = ($_SESSION['rol'] === 'admin');
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/carrusel.css">
    <link rel="stylesheet" href="./css/index.css">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light bgnav">
    <div class="container">
        <!-- Marca (Logo) -->
        <!-- <a class="navbar-brand" href="#">Cyber</a> -->

        <!-- Botón de menú colapsable -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Elementos colapsables del menú -->
        <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link active" aria-current="page" href="#">Cyber</a>
                <?php if(isset($_SESSION['usuario'])): ?>
                    <a href="./bd/logout.php" class="nav-link" id="logout-btn">Cerrar Sesión</a>
                <?php endif; ?>
                
                <?php if ($isAdmin): ?>
                    <a class="nav-link" href="./bd/agregar_producto.php">Agregar Producto</a>
                <?php endif; ?>
            </div>

        <!-- Formulario de búsqueda con AJAX -->
        <form class="d-flex ms-auto bg-white rounded-lg shadow p-2" id="search-form">
            <input class="form-control me-2 border-0 rounded-start" type="search" name="query" id="search-input" placeholder="Buscar productos o descripciones..." aria-label="Buscar" style="background-color: #f0f0f0;">
            <button class="btn btn-primary rounded-end" type="submit">Buscar</button>
        </form>

        <!-- Div para mostrar los resultados debajo del campo de búsqueda -->
        <div id="search-results" class="mt-3" style="display: none;"></div>




            <!-- Ícono de perfil alineado a la derecha -->
            <div class="navbar-nav ms-3">
                <?php if(isset($_SESSION['usuario'])):  ?>
                    <!-- Mostrar nombre del usuario autenticado -->
                    <span class="nav-link">Bienvenido, <?php echo $_SESSION['usuario']; ?>!</span>
                    <?php else: ?>
                        <a class="nav-link" href="./html/login2.html">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 0 448 512">
                                <path d="M224 256A128 128 0 1 0 224 0a128 128 0 1 0 0 256zm-45.7 48C79.8 304 0 383.8 0 482.3C0 498.7 13.3 512 29.7 512H418.3c16.4 0 29.7-13.3 29.7-29.7C448 383.8 368.2 304 269.7 304H178.3z"/>
                    </svg>
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="hero">
    <div class="carrusel">
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="./img/brujo.jpg" class="d-block w-100" alt="Imagen 1">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Título 1</h5>
                        <p>Descripción de la imagen 1.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./img/cyberpunk4k.jpg" class="d-block w-100" alt="Imagen 2">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Título 2</h5>
                        <p>Descripción de la imagen 2.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./img/dias.jpg" class="d-block w-100" alt="Imagen 3">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Título 3</h5>
                        <p>Descripción de la imagen 3.</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="./img/kratos4k.jpg" class="d-block w-100" alt="Imagen 4">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Título 4</h5>
                        <p>Descripción de la imagen 4.</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>

        <!-- Productos listados -->
        <div class="container">
            <section class="grid grid-cols-1 gap-6 p-4 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 md:p-6">
                <?php foreach ($productos as $producto) : ?>
                    <div class="relative overflow-hidden rounded-lg group">
                        <img src="bd/uploads/<?php echo htmlspecialchars(basename($producto['imagen'])); ?>" alt="Imagen del producto" class="object-cover w-full h-60">
                        <div class="p-4 bg-background">
                            <h3 class="text-lg font-semibold md:text-xl"><?php echo htmlspecialchars($producto['nombre']); ?></h3>
                            <p class="text-sm text-muted-foreground"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <div class="flex items-center justify-between">
                                <h4 class="text-base font-semibold md:text-lg">$<?php echo htmlspecialchars($producto['precio']); ?></h4>
                                <button class="btn btn-sm add-to-cart">Agregar al carrito</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </section>
        </div>

        <!-- Carrito de compras -->
        <div class="cart fixed bottom-0 right-0 p-6 bg-white shadow-lg rounded-lg carrito">
            <h2 class="text-xl font-semibold mb-4">Carrito de Compras</h2>
            <ul id="cart-items" class="mb-4"></ul>
            <div class="flex justify-between items-center">
                <span class="text-lg font-semibold">Total: $<span id="cart-total">0.00</span></span>
                <button class="btn btn-primary">Comprar</button>
            </div>
        </div>
        
        <!-- Pie de página (Contacto) -->
        <footer>
            <div class="contact">
                <img src="/public/view/img/contacto/lorenzo-herrera-p0j-mE6mGo4-unsplash.jpg" alt="">
                <div class="form">
                    <h1>Contacto</h1>
                    <div class="inputBx">
                        <p>Nombre</p>
                        <input type="text" placeholder="Nombre Completo" id="">
                    </div>
                    <div class="inputBx">
                        <p>Gmail</p>
                        <input type="email" placeholder="Gmail Completo" id="">
                    </div>
                    <div class="inputBx">
                        <p>Mensaje</p>
                        <textarea cols="30" rows="10"></textarea>
                    </div>
                    <div class="inputBx">
                        <input type="submit" value="Enviar">
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="./js/index2.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- <script src="./js/carrusel.js"></script> -->
</body>
</html>
