{% extends "templates/profile/profile.php" %}

{% block section %}
<p class='h4'>Datos personales</p>
<form action='/perfil/updateSecurity' method='POST' id='form'>
    <label for='lastPass'>Antigua contraseña</label>
    <input type='password' name='lastPass'>
    <label for='newPass'>Nueva contraseña</label>
    <input type='password' name='newPass'>
    <label for='repeatNewPass'>Repite la nueva contraseña</label>
    <input type='password' name='repeatNewPass'>
    <input type='submit' value='Guardar datos' id='send'>
</form>

<script src="{{root}}/public/js/profile/security.js"></script>
{% endblock %}