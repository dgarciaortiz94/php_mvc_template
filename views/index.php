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

    <a href="?class=IndexController&function=prueba&id=1&nombre=diego">Ir a prueba</a>

    <?php View::require("general/footer") ?>
</body>
</html>