<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Perfil</title>

    <link rel='stylesheet' href='public/css/profile/profile.css'>
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
                        <a class='nav-link profile-section' section='myData'>Datos personales</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link profile-section' section='security'>Seguridad</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link profile-section' href='#'>Link</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link profile-section' href='#'>Disabled</a>
                    </li>
                </ul>
            </nav>
        </aside>

        <section id="section">
            <p class='h4'>Datos personales</p>
            <form action='' method='POST'>
                <label for='username'>Nick</label>
                <input type='text' name='username' value='<?= $userData->username; ?>'>
                <label for='Nombre'>Nombre</label>
                <input type='text' name='firstname' value='<?= $userData->firstname; ?>'>
                <label for='Apellido'>Apellido</label>
                <input type='text' name='lastname' value='<?= $userData->lastname; ?>'>
                <label for='Email'>Email</label>
                <input type='text' name='email' value='<?= $userData->email; ?>'>
                <input type='submit' value='Guardar datos'>
            </form>
        </section>
    </div>

    <footer class='text-center footer'>
        <p class='container'>MVC Template</p>
        <p>Developed by Diego García</p>
    </footer>
</body>
</html>