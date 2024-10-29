document.addEventListener('DOMContentLoaded', () => {
    const cart = [];
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');

    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', event => {
            const productElement = event.target.closest('.group');
            const productName = productElement.querySelector('h3').textContent;
            const productPrice = parseFloat(productElement.querySelector('h4').textContent.replace('$', ''));
            const productImage = productElement.querySelector('img').src; // Obtener la imagen

            // Verificar si el producto ya está en el carrito
            const existingProductIndex = cart.findIndex(item => item.name === productName);
            if (existingProductIndex > -1) {
                // Incrementar la cantidad si ya existe
                cart[existingProductIndex].quantity += 1;
            } else {
                // Agregar nuevo producto al carrito
                cart.push({ name: productName, price: productPrice, quantity: 1, image: productImage }); // Incluir la imagen
            }

            updateCart();
        });
    });

    function updateCart() {
        cartItemsContainer.innerHTML = '';
        let total = 0;
        cart.forEach((product, index) => {
            const listItem = document.createElement('li');
            // Crear contenedor para el producto y su imagen
            const productContainer = document.createElement('div');
            productContainer.classList.add('flex', 'items-center', 'justify-between');

            // Crear etiqueta de imagen
            const img = document.createElement('img');
            img.src = product.image; // Usar la imagen del producto
            img.alt = product.name;
            img.classList.add('w-16', 'h-16', 'mr-4'); // Ajustar tamaño de la imagen

            // Mostrar la cantidad junto con el nombre y el precio
            const productInfo = document.createElement('div');
            productInfo.textContent = `${product.name} - $${product.price.toFixed(2)} x ${product.quantity} = $${(product.price * product.quantity).toFixed(2)}`;

            // Crear botón de eliminar
            const removeButton = document.createElement('button');
            removeButton.textContent = 'Eliminar';
            removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'ml-2');
            removeButton.addEventListener('click', () => {
                cart.splice(index, 1); // Eliminar el producto del carrito
                updateCart(); // Actualizar el carrito
            });

            productContainer.appendChild(img); // Añadir la imagen al contenedor
            productContainer.appendChild(productInfo); // Añadir la información del producto
            productContainer.appendChild(removeButton); // Añadir el botón de eliminar

            listItem.appendChild(productContainer); // Añadir el contenedor al ítem de la lista
            cartItemsContainer.appendChild(listItem);
            total += product.price * product.quantity;
        });
        cartTotal.textContent = total.toFixed(2);
    }
});
