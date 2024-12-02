<?php
// Inicia sesión para manejo de usuarios
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación simple del formulario
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if (empty($username) || empty($password)) {
        $error = "Por favor, complete todos los campos.";
    } else {
        // Guardar los datos en la sesión temporalmente (para efectos de demostración)
        $_SESSION['username'] = $username;
        header("Location: menu.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }

        form {
            max-width: 400px;
            margin: auto;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>
    <h1>Registro de Usuario</h1>
    <form method="post" action="">
        <label for="username">Usuario:</label><br>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Contraseña:</label><br>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit">Registrarse</button>
    </form>
    <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
</body>

</html>