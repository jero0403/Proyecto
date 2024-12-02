<?php
// Datos de conexión
$host = 'localhost';
$dbname = 'restaurante';
$username = 'root'; // Cambiar según tu configuración
$password = ''; // Cambiar según tu configuración

// Conectar a la base de datos
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error en la conexión: " . $e->getMessage());
}
?>
