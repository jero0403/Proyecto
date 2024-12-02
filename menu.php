<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

// Conexión a la base de datos
require 'db.php';

// Recuperar los platos del menú desde la base de datos
try {
    $stmt = $conn->prepare("SELECT * FROM menu");
    $stmt->execute();
    $menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error en la consulta: " . $e->getMessage());
}

// Procesar pedido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pedido = $_POST['pedido'] ?? [];
    $total = 0;

    foreach ($pedido as $id => $cantidad) {
        foreach ($menu_items as $item) {
            if ($item['id'] == $id && $cantidad > 0) {
                $total += $item['precio'] * $cantidad;
            }
        }
    }

    // Guardar usuario en la base de datos
    $username = $_SESSION['username'];
    try {
        $stmt = $conn->prepare("INSERT INTO usuarios (nombre) VALUES (:nombre)");
        $stmt->bindParam(':nombre', $username);
        $stmt->execute();
        $usuario_id = $conn->lastInsertId();
    } catch (PDOException $e) {
        die("Error al registrar usuario: " . $e->getMessage());
    }

    // Registrar pedido
    try {
        $stmt = $conn->prepare("INSERT INTO pedidos (usuario_id, total) VALUES (:usuario_id, :total)");
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->bindParam(':total', $total);
        $stmt->execute();
        $pedido_id = $conn->lastInsertId();
    } catch (PDOException $e) {
        die("Error al registrar pedido: " . $e->getMessage());
    }

    // Registrar platos en el pedido
    foreach ($pedido as $id => $cantidad) {
        if ($cantidad > 0) {
            try {
                $stmt = $conn->prepare("INSERT INTO pedido_platos (pedido_id, plato_id, cantidad) VALUES (:pedido_id, :plato_id, :cantidad)");
                $stmt->bindParam(':pedido_id', $pedido_id);
                $stmt->bindParam(':plato_id', $id);
                $stmt->bindParam(':cantidad', $cantidad);
                $stmt->execute();
            } catch (PDOException $e) {
                die("Error al registrar plato: " . $e->getMessage());
            }
        }
    }

    header("Location: consulta.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Menú del Restaurante</title>
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
    <h1>Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
    <h2>Menú</h2>
    <form method="post" action="">
        <table>
            <tr>
                <th>Plato</th>
                <th>Precio</th>
                <th>Cantidad</th>
            </tr>
            <?php foreach ($menu_items as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['nombre']); ?></td>
                    <td>$<?php echo number_format($item['precio'], 2); ?></td>
                    <td><input type="number" name="pedido[<?php echo $item['id']; ?>]" min="0" value="0"></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit">Realizar Pedido</button>
    </form>
</body>

</html>