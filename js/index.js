document.getElementById('logout-btn').addEventListener('click', function (e) {
    e.preventDefault(); // Evita que el enlace se ejecute inmediatamente

    // Mostrar un cuadro de confirmación
    let confirmLogout = confirm("¿Estás seguro de que deseas cerrar sesión?");

    if (confirmLogout) {
        // Si confirma, redirigir al PHP que destruye la sesión
        window.location.href = './bd/logout.php';
    }
});

document.getElementById('search-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Evitar que el formulario recargue la página

    let query = document.getElementById('search-input').value;

    // Enviar la búsqueda con fetch
    fetch('./bd/buscar.php?query=' + query)
        .then(response => response.text())
        .then(data => {
            // Mostrar los resultados dentro del div
            document.getElementById('search-results').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
});