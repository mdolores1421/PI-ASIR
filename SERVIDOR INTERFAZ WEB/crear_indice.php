<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['consulta']) || !isset($_POST['tabla']) || !isset($_POST['campos_where'])) {
    echo "Faltan datos necesarios.";
    print_r($_POST);
    exit();
}

$consulta = $_POST['consulta'];
$tabla = $_POST['tabla'];
$campos_where = $_POST['campos_where'];

$conn = new mysqli("192.168.100.10", "cliente_madet", "Cliente12345", "MADET");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Crear el índice automáticamente
$nombre_indice = "idx_" . $tabla . "_" . str_replace(",", "_", $campos_where);
$sql = "CREATE INDEX `$nombre_indice` ON `$tabla` ($campos_where)";

if ($conn->query($sql) === TRUE) {
    echo "<p>Índice creado correctamente: $nombre_indice</p>";
} else {
    echo "<p>Error al crear el índice: " . $conn->error . "</p>";
}

// Ejecutar la consulta original y mostrar los resultados
$result = $conn->query($consulta);

if ($result && $result->num_rows > 0) {
    echo "<h3>Resultados tras crear índice:</h3>";
    echo "<link rel='stylesheet' href='salida.css'>";
    echo "<table border='1'><tr>";
    while ($field = $result->fetch_field()) {
        echo "<th>" . htmlspecialchars($field->name) . "</th>";
    }
    echo "</tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $value) {
            echo "<td>" . htmlspecialchars($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay resultados o error en la consulta.</p>";
}

$conn->close();
?>
