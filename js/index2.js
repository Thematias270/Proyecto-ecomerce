document.getElementById('search-input').addEventListener('input', function () {
    const query = this.value;

    // Verificar si hay algo que buscar
    if (query.length > 2) { // Comienza a buscar si hay más de 2 caracteres
        fetch(`./bd/buscar.php?query=${query}`)
            .then(response => response.text())
            .then(data => {
                const resultsDiv = document.getElementById('search-results');
                resultsDiv.style.display = 'block'; // Mostrar los resultados
                resultsDiv.innerHTML = data; // Mostrar el contenido devuelto por PHP
            })
            .catch(error => console.log('Error:', error));
    } else {
        document.getElementById('search-results').style.display = 'none'; // Ocultar resultados si no hay texto
    }
});
