document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');

    loginForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Evita que el formulario se envíe de la manera tradicional

        // Obtén los valores del formulario
        const username = document.getElementById('loginUsername').value;
        const password = document.getElementById('loginPassword').value;

        // Asegúrate de que ambos campos estén llenos
        if (username && password) {
            // Crea un objeto URLSearchParams para enviar datos de formulario
            const formData = new URLSearchParams();
            formData.append('username', username);
            formData.append('password', password);

            // Envía los datos al servidor usando fetch
            fetch('/login', {
                method: 'POST',
                body: formData,
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                }
            })
            .then(response => {
                if (response.redirected) {
                    window.location.href = response.url; // Redirigir al tablero si el inicio de sesión es exitoso
                } else {
                    return response.text().then(text => { 
                        alert(text); // Mostrar un mensaje si la autenticación falla
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        } else {
            alert('Please fill in all fields.'); // Asegúrate de que los campos no estén vacíos
        }
    });
});
