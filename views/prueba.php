<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba</title>
</head>
<body>
    <p>Hola, soy la página de prueba</p>

    <?php
        foreach ($users as $user) {
            echo $user->username . " = " . $user->firstname . " " . $user->lastname . "<br>";
        }
    ?>

</body>
</html>