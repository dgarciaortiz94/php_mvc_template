{% extends "templates/profile/profile.php" %}

{% block section %}
<div class='profileInfo'>
<p>Nombre de usuario:</p>
<p>{{userData.username}}</p>
</div>
<div class='profileInfo'>
<p>Nombre:</p>
<p>{{userData.firstname}}</p>
</div>
<div class='profileInfo'>
<p>Apellido:</p>
<p>{{userData.lastname}}</p>
</div>
<div class='profileInfo'>
<p>Email:</p>
<p>{{userData.email}}</p>
</div>
<div class='profileInfo'>
<p>Role:</p>
<p>{{userData.role}}</p>
</div>
<div class='profileInfo'>
<p>Fecha de registro:</p>
<p>{{userData.date_register}}</p>
</div>
{% endblock %}