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
$result = $conn->query("SHOW TABLES");
while ($row = $result->fetch_array()) {
    $tables[] = $row[0];
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seleccionar Consulta</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Seleccionar Tipo de Consulta</h2>
        
        <button onclick="window.location.href='simple.php'">Consulta Simple (1 Tabla)</button>
        <button onclick="window.location.href='compleja.php'">Consulta Compleja (2 Tablas)</button>
        <br><br>
        <button onclick="window.location.href='index.php'" style="background-color: blueviolet">Cerrar sesión</button>
    </div>
</body>
</html>
