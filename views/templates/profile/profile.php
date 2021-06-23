<!DOCTYPE html>
<html lang='es'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Perfil</title>

    <link rel='stylesheet' href="{{css('profile/profile')}}">

    <style>
        
        #profile-photo{
            background-image: url({{ROOT}}/images/profiles/{{userData.profile_picture}});
        }
    </style>
</head>
<body>
    <header>
        <p class='display-4'>Mi perfil</p>
        <div id='profile-photo'></div>
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

    <div id='imageModal'>
        <div>
            <div id='toolsModal'>
                <div id='crudButtons'>
                    <form action="/profile/updatePhotoProfile" method="post" id='updateForm' enctype="multipart/form-data">
                        <span id='editImage'><i class='fas fa-edit fa-lg'></i></span>
                        <input id="file" type="file" name="photo" style="display: none;" />
                    </form>
                    <span id='deleteImage'><i class='fas fa-trash-alt fa-lg'></i></span>
                </div>
                <button id='savePhotoProfile' style="display: none;">Guardar</button>
                <span id='closeImage' style='margin-left:auto;'><i class='fas fa-times fa-2x'></i></span>
            </div>

            <div id='modal-profile-image'></div>
        </div>
    </div>

    <script src="{{js('profile/profile')}}"></script>
</body>
</html>