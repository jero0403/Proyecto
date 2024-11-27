<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexion MySQL</title>
</head>

<body>
    <?php
    // Establecer la conexión a la base de datos MySQL
    // mysqli_connect("servidor", "usuario", "clave", "base de datos")
    // Reemplaza estos parámetros con tus propios datos de conexión
    $enlace = mysqli_connect("servidor", "usuario", "clave", "base de datos");

    // Verificar si la conexión fue exitosa
    if (!$enlace) {
        // Si la conexión falla, se termina el script y se muestra un mensaje de error
        die("No pudo conectarse a la base de datos " . mysqli_connect_error());
    }

    // Si la conexión fue exitosa, se muestra un mensaje de éxito
    echo "Conexion exitosa";

    // Cerrar la conexión a la base de datos
    mysqli_close($enlace);
    ?>
</body>

</html>