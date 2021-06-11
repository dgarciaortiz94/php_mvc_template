{% extends "templates/profile/profile.php" %}

{% block section %}
<p class='h4'>Datos personales</p>
<form action='/perfil/updatePersonalData' method='POST' id='form'>
    <label for='username'>Nick</label>
    <input type='text' name='username' value='{{userData.username}}'>
    <label for='firstname'>Nombre</label>
    <input type='text' name='firstname' value='{{userData.firstname}}'>
    <label for='lastname'>Apellido</label>
    <input type='text' name='lastname' value='{{userData.lastname}}'>
    <label for='email'>Email</label>
    <input type='text' name='email' value='{{userData.email}}'>
    <input type='submit' value='Guardar datos' id='send'>
</form>

<script src="{{js('profile/personalData')}}"></script>
{% endblock %}