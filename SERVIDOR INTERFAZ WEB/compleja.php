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
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consulta Compleja</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Seleccionar Tablas para Consulta Compleja</h2>
        <form action="seleccion_campos.php" method="GET">
            <label for="tabla1">Tabla 1:</label>
            <select name="tabla1" required>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <label for="tabla2">Tabla 2:</label>
            <select name="tabla2" required>
                <?php foreach ($tables as $table): ?>
                    <option value="<?php echo $table; ?>"><?php echo $table; ?></option>
                <?php endforeach; ?>
            </select>
            <br><br>
            <button type="submit">Siguiente</button>
        </form>
        <br>
        <button onclick="window.location.href='consultas.php'">Volver</button>
        <button onclick="window.location.href='index.php'">Cerrar sesión</button>
    </div>
</body>
</html>
