<nav class="navbar">
  <div class="navbar-right">
        <button class="navbar-toggle" onclick="toggleNavbarMenu()">&#9776;</button>
        <div class="navbar-menu" id="navbarMenu">
            <a href="/app/views/alumno/registrar-alumno.php" class="navbar-link">
                <i class="fas fa-user-graduate"></i> Registro de alumno
            </a>
            <a href="/app/views/alumno/lista-alumno.php" class="navbar-link">
                <i class="fas fa-list"></i> Lista de alumnos
            </a>
            <a href="/app/views/generar-poliza.php" class="navbar-link">
                <i class="fas fa-file-contract"></i> Generar Póliza
            </a>
            <a href="/app/views/registrar-usuario.php" class="navbar-link">
                <i class="fas fa-user-plus"></i> Registro de usuarios
            </a>
            <a href="logout.php" class="navbar-link logout">
                <i class="fas fa-sign-out-alt"></i> Cerrar sesión
            </a>
        </div>
    </div>
</nav>

<script>
function toggleNavbarMenu() {
    const menu = document.getElementById('navbarMenu');
    menu.classList.toggle('active');
}
</script>