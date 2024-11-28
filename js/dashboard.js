document.addEventListener('DOMContentLoaded', () => {
    const loggedInUser = sessionStorage.getItem('loggedin');

    // Aquí usamos el nombre de usuario de la sesión
    document.getElementById("username").textContent = loggedInUser; // Mostrar el nombre de usuario correctamente
    loadProjects();

    const addProjectForm = document.getElementById("addProjectForm");
    addProjectForm.addEventListener("submit", (e) => {
        e.preventDefault();
        addProject();
    });

    document.getElementById("logoutBtn").addEventListener("click", () => {
        sessionStorage.removeItem("loggedInUser"); // Cambiar de localStorage a sessionStorage
        window.location.href = 'login.php'; // Redirigir a la página de inicio de sesión
    });
});
