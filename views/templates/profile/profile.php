<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Perfil</title>

    <link rel='stylesheet' href='{{root}}/public/css/profile/profile.css'>
</head>
<body>
    <header>
        <p class='display-4'>Mi perfil</p>
        <div class='profile-photo'></div>
    </header>

    <div class='container center-container'>
        <aside>
            <nav>
                <ul class='nav flex-column'>
                    <li class='nav-item'>
                        <a href="/perfil" class='nav-link profile-section'>Datos personales</a>
                    </li>
                    <li class='nav-item'>
                        <a href="/perfil/seguridad" class='nav-link profile-section'>Seguridad</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link profile-section' href='/perfil/logoff'>Cerrar sesión</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <section id="section">
            {% block section %}
            {% endblock %}
        </section>
    </div>

    <footer class='text-center footer'>
        <p class='container'>MyFramework Template</p>
        <p>Developed by Diego García</p>
    </footer>
</body>
</html>