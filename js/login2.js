document.addEventListener('DOMContentLoaded', function() {
    const toggleButtons = document.querySelectorAll('.toggle-button');
    const welcomeMessage = document.querySelector('.welcome-message');
    const signUpForm = document.querySelector('.sign-up-form');
    const signInForm = document.querySelector('.sign-in-form');
  
    // Función para mostrar notificaciones
    const showNotification = (message, type) => {
      const notification = document.getElementById('notification');
      notification.innerText = message;
      notification.className = `notification ${type}`;
      notification.style.display = 'block';
  
      setTimeout(() => {
        notification.style.display = 'none';
      }, 5000);
    };
  
    toggleButtons.forEach(button => {
      button.addEventListener('click', function() {
        const target = document.querySelector(this.getAttribute('data-target'));
  
        if (target === signUpForm) {
          signInForm.style.display = 'none';
          signUpForm.style.display = 'block';
          welcomeMessage.style.display = 'none';
        } else if (target === signInForm) {
          signUpForm.style.display = 'none';
          signInForm.style.display = 'block';
          welcomeMessage.style.display = 'none';
        }
      });
    });
  
    // Manejar el envío del formulario de registro
    const signUpFormElement = document.querySelector('.sign-up-form form');
    if (signUpFormElement) {
      signUpFormElement.addEventListener('submit', function(event) {
        event.preventDefault();
        const nombre = document.querySelector('#name').value;
        const correo = document.querySelector('#email').value;
        const contra = document.querySelector('#password').value;
  
        fetch('/Practicas/bd/registro.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ nombre, correo, contra })
        })
        .then(response => response.json())
        .then(data => {
          showNotification(data.message, data.status);
          if (data.status === 'success') {
            window.location.reload(); 
            signUpFormElement.reset();
          }
        })
        .catch(error => {
          showNotification('Error de conexión. Por favor, inténtelo de nuevo.', 'error');
          console.error('Error:', error);
        });
      });
    }
  
    // Manejar el envío del formulario de inicio de sesión
    const signInFormElement = document.querySelector('.sign-in-form form');
    if (signInFormElement) {
      signInFormElement.addEventListener('submit', function(event) {
        event.preventDefault();
        const email = document.querySelector('#email-signin').value;
        const password = document.querySelector('#password-signin').value;
  
        fetch('/Practicas/bd/iniciar.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({ email, password })
        })
        .then(response => response.json())
        .then(data => {
          showNotification(data.message, data.status);
          if (data.status === 'success') {
            window.location.reload(); 
            signInFormElement.reset();
          }
        })
        .catch(error => {
          showNotification('Error de conexión. Por favor, inténtelo de nuevo.', 'error');
          console.error('Error:', error);
        });
      });
    }
  });
  