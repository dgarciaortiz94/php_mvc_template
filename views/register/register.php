<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <link rel="stylesheet" href="{{css('login/login')}}">
</head>
<body>
    <header>
        <p class="display-4">MyFramework Template</p>
    </header>

    <section class="container d-flex align-items-center">
        <form action="" method="POST" class="d-flex flex-column align-items-center mx-auto" id='form'>
            <input type="text" name='username' placeholder="Usuario *">
            <input type="text" name='firstname' placeholder="Nombre *">
            <input type="text" name='lastname' placeholder="Apellido *">
            <input type="text" name='email' placeholder="Correo electrónico *">
            <input type="password" name="pass" placeholder="Contraseña *">
            <input type="password" name="repeatPass" placeholder="Repite la contraseña *">
            <input type="submit" value="Enviar" id="send">
        </form>
    </section>

    <footer class="text-center footer">
        <p class="container">MyFramework Template</p>
        <p>Developed by Diego García</p>
    </footer>

    <script src="{{js('register/register')}}"></script>
</body>
</html>