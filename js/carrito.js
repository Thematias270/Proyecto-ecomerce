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

            const product = {
                name: productName,
                price: productPrice
            };

            cart.push(product);
            updateCart();
        });
    });

    function updateCart() {
        cartItemsContainer.innerHTML = '';
        let total = 0;
        cart.forEach(product => {
            const listItem = document.createElement('li');
            listItem.textContent = `${product.name} - $${product.price.toFixed(2)}`;
            cartItemsContainer.appendChild(listItem);
            total += product.price;
        });
        cartTotal.textContent = total.toFixed(2);
    }
});
