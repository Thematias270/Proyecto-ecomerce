<?php
session_start();

// Inicializar el carrito
if (isset($_GET['nombre']) && !empty($_GET['nombre'])) {
    $cart = [];
    foreach ($_GET['nombre'] as $key => $value) {
        $cart[] = [
            'nombre' => htmlspecialchars($value),
            'precio' => htmlspecialchars($_GET['precio'][$key]),
            'cantidad' => htmlspecialchars($_GET['cantidad'][$key]),
            'imagen' => isset($_GET['imagen'][$key]) ? htmlspecialchars($_GET['imagen'][$key]) : '' // Manejar el caso donde no se pasa la imagen
        ];
    }
    $_SESSION['cart'] = $cart; // Almacenar el carrito en la sesión
} else {
    $_SESSION['cart'] = [];
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>
    <link rel="stylesheet" href="../css/compra.css">
</head>
<body>
    <h1>Carrito de Compras</h1>
    <?php if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])): ?>
        <div class="product-list">
            <?php 
            $total = 0;
            foreach ($_SESSION['cart'] as $item): 
                $itemTotal = $item['precio'] * $item['cantidad'];
                $total += $itemTotal;

                // Verificar si la imagen existe
                $imagePath = "../bd/uploads/" . htmlspecialchars($item['imagen']);
            ?>
                <div class="product-item">
                    <?php if (file_exists($imagePath)): ?>
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo htmlspecialchars($item['nombre']); ?>" class="product-image">
                    <?php else: ?>
                        <p>La imagen no existe: <?php echo htmlspecialchars($item['imagen']); ?></p>
                    <?php endif; ?>
                    <div class="product-info">
                        <h3><?php echo htmlspecialchars($item['nombre']); ?></h3>
                        <p>Precio: $<?php echo htmlspecialchars($item['precio']); ?></p>
                        <p>Cantidad: <?php echo htmlspecialchars($item['cantidad']); ?></p>
                        <p>Total: $<?php echo htmlspecialchars($itemTotal); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <h2>Total Carrito: $<?php echo htmlspecialchars($total); ?></h2>
        <button class="btn btn-primary">Finalizar Compra</button>
    <?php else: ?>
        <p>Tu carrito está vacío.</p>
    <?php endif; ?>
</body>
</html>
