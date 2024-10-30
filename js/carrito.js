document.addEventListener('DOMContentLoaded', () => {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');

    // Recuperar carrito del local storage
    let cart = JSON.parse(localStorage.getItem('cart')) || [];

    // Cargar carrito al iniciar la página
    updateCart();

    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    addToCartButtons.forEach(button => {
        button.addEventListener('click', event => {
            const productElement = event.target.closest('.group');
            const productName = productElement.querySelector('h3').textContent;
            const productPrice = parseFloat(productElement.querySelector('h4').textContent.replace('$', ''));
            const productImage = productElement.querySelector('img').src;

            // Verificar si el producto ya está en el carrito
            const existingProductIndex = cart.findIndex(item => item.name === productName);
            if (existingProductIndex > -1) {
                // Incrementar la cantidad si ya existe
                cart[existingProductIndex].quantity += 1;
            } else {
                // Agregar nuevo producto al carrito
                cart.push({ name: productName, price: productPrice, quantity: 1, image: productImage });
            }

            // Guardar el carrito en el local storage
            localStorage.setItem('cart', JSON.stringify(cart));

            updateCart();
        });
    });

    function updateCart() {
        cartItemsContainer.innerHTML = '';
        let total = 0;
        cart.forEach((product, index) => {
            const listItem = document.createElement('li');
            const productContainer = document.createElement('div');
            productContainer.classList.add('flex', 'items-center', 'justify-between');

            const img = document.createElement('img');
            img.src = product.image;
            img.alt = product.name;
            img.classList.add('w-16', 'h-16', 'mr-4');

            const productInfo = document.createElement('div');
            productInfo.textContent = `${product.name} - $${product.price.toFixed(2)} x ${product.quantity} = $${(product.price * product.quantity).toFixed(2)}`;

            const removeButton = document.createElement('button');
            removeButton.textContent = 'Eliminar';
            removeButton.classList.add('btn', 'btn-danger', 'btn-sm', 'ml-2');
            removeButton.addEventListener('click', () => {
                cart.splice(index, 1); // Eliminar el producto del carrito
                localStorage.setItem('cart', JSON.stringify(cart)); // Actualizar el local storage
                updateCart(); // Actualizar el carrito
            });

            productContainer.appendChild(img);
            productContainer.appendChild(productInfo);
            productContainer.appendChild(removeButton);

            listItem.appendChild(productContainer);
            cartItemsContainer.appendChild(listItem);
            total += product.price * product.quantity;
        });
        cartTotal.textContent = total.toFixed(2);
    }

    // Suponiendo que tienes un array `cart` con objetos que tienen `name`, `price`, y `quantity`
    document.getElementById('btn-comprar').addEventListener('click', () => {
        if (cart.length > 0) {
            // Crear un string de parámetros de consulta
            const queryString = cart.map(item =>
                `nombre[]=${encodeURIComponent(item.name)}&precio[]=${encodeURIComponent(item.price)}&cantidad[]=${encodeURIComponent(item.quantity)}&imagen[]=${encodeURIComponent(item.image || '')}`
            ).join('&');

            // Redirigir a la página de compra con los datos del carrito
            window.location.href = `./bd/compra.php?${queryString}`;
        } else {
            alert('Tu carrito está vacío. Agrega productos antes de comprar.');
        }
    });



})
