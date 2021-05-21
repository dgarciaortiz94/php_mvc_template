<?php

use Core\View;

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Index</title>
</head>
<body>
    <?php View::require("general/header") ?>

    <?php echo $users[0]->firstname . " " . $users[0]->lastname ?>

    <p>Hola, soy el Index principal</p>

    <form action="/?class=IndexController&function=login" method="POST" id="form">
        <label for="username">Username</label>
        <input type="text" name="username">
        <label for="pass">Pass</label>
        <input type="text" name="pass">
        <input type="submit" value="Enviar" id="send">
    </form>

    <?php View::require("general/footer") ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/public/js/index.js"></script>
</body>
</html>