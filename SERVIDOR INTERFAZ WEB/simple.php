<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.php");
    exit();
}

$conn = new mysqli("192.168.100.10", "cliente_madet", "Cliente12345", "MADET");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener lista de tablas
$tables = [];

$result = $conn->query("SHOW TABLES FROM MADET");
while ($row = $result->fetch_array()) {
    if ($row[0] !== 'log_consultas' && $row[0] !== "log_features") { // Ocultamos esta tabla
       $tables[] = $row[0];
    }
}

$conn->close();


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['tabla'])) {
    $tabla = $_POST['tabla'];
    switch ($tabla) {
        case 'clientes':
            header("Location: clientes.php");
            break;
        case 'productos':
            header("Location: productos.php");
            break;
        case 'ventas':
            header("Location: ventas.php");
            break;
        case 'empleados':
            header("Location: empleados.php");
            break;
        default:
            header("Location: simple.php");
            break;
    }
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consulta Simple</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Seleccione una Tabla</h2>
        <form method="POST" action="simple.php">
            <select name="tabla" required>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table; ?>"><?php echo ucfirst($table); ?></option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <button type="submit">Continuar</button>
        </form>
        <br>
        <button onclick="window.location.href='consultas.php'">Volver</button>
    </div>
</body>
</html>
