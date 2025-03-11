document.addEventListener('DOMContentLoaded', () => {
    const cartItemsContainer = document.getElementById('cart-items');
    const cartTotal = document.getElementById('cart-total');
    const searchResults = document.getElementById('search-results');
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    updateCart();

    // Delegación de eventos para detectar botones dinámicos
    document.body.addEventListener('click', event => {
        if (event.target.classList.contains('add-to-cart')) {
            const productElement = event.target.closest('.group');
            const productName = productElement.querySelector('h3').textContent;
            const productPrice = parseFloat(productElement.querySelector('h4').textContent.replace('$', ''));
            const productImage = productElement.querySelector('img').src;

            addToCart(productName, productPrice, productImage);
        }
    });

    function addToCart(name, price, image) {
        const existingProductIndex = cart.findIndex(item => item.name === name);
        if (existingProductIndex > -1) {
            cart[existingProductIndex].quantity += 1;
        } else {
            cart.push({ name, price, quantity: 1, image });
        }
        localStorage.setItem('cart', JSON.stringify(cart));
        updateCart();
    }

    function updateCart() {
        cartItemsContainer.innerHTML = '';
        let total = 0;
        cart.forEach((product, index) => {
            const listItem = document.createElement('li');
            listItem.classList.add('cart-item');

            listItem.innerHTML = `
                <div class='flex items-center justify-between'>
                    <img src="${product.image}" alt="${product.name}" class="w-16 h-16 mr-4">
                    <div>${product.name} - $${product.price.toFixed(2)} x ${product.quantity} = $${(product.price * product.quantity).toFixed(2)}</div>
                    <button class='remove-item btn btn-danger btn-sm' data-index='${index}'>Eliminar</button>
                </div>
            `;
            cartItemsContainer.appendChild(listItem);
            total += product.price * product.quantity;
        });
        cartTotal.textContent = total.toFixed(2);
    }

    // Eliminar productos del carrito
    cartItemsContainer.addEventListener('click', event => {
        if (event.target.classList.contains('remove-item')) {
            const index = event.target.getAttribute('data-index');
            cart.splice(index, 1);
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCart();
        }
    });

    // Comprar
    document.getElementById('btn-comprar').addEventListener('click', () => {
        if (cart.length > 0) {
            const queryString = cart.map(item =>
                `nombre[]=${encodeURIComponent(item.name)}&precio[]=${encodeURIComponent(item.price)}&cantidad[]=${encodeURIComponent(item.quantity)}&imagen[]=${encodeURIComponent(item.image || '')}`
            ).join('&');
            window.location.href = `./bd/compra.php?${queryString}`;
        } else {
            alert('Tu carrito está vacío. Agrega productos antes de comprar.');
        }
    });
});
