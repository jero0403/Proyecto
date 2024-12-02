<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Conexión a la base de datos
require 'db.php';

// Recuperar todos los pedidos
try {
    $stmt = $conn->prepare("
        SELECT usuarios.nombre AS usuario, menu.nombre AS plato, pedido_platos.cantidad, pedidos.total, pedidos.fecha
        FROM pedidos
        JOIN usuarios ON pedidos.usuario_id = usuarios.id
        JOIN pedido_platos ON pedidos.id = pedido_platos.pedido_id
        JOIN menu ON pedido_platos.plato_id = menu.id
        ORDER BY pedidos.fecha DESC
    ");
    $stmt->execute();
    $pedidos = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Consulta de Pedidos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 50px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f4f4f4;
        }
    </style>
</head>

<body>
    <h1>Consulta de Pedidos</h1>
    <table>
        <tr>
            <th>Usuario</th>
            <th>Plato</th>
            <th>Cantidad</th>
            <th>Total Pedido</th>
            <th>Fecha</th>
        </tr>
        <?php foreach ($pedidos as $pedido): ?>
            <tr>
                <td><?php echo htmlspecialchars($pedido['usuario']); ?></td>
                <td><?php echo htmlspecialchars($pedido['plato']); ?></td>
                <td><?php echo $pedido['cantidad']; ?></td>
                <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                <td><?php echo $pedido['fecha']; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
    <a href="menu.php">Regresar al menú</a>
</body>

</html>