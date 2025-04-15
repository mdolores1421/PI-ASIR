<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['consulta'])) {
    echo "Faltan datos para ejecutar la consulta.";
    exit();
}

$consulta = $_POST['consulta']; // Recibimos la consulta enviada

// Conectar a la base de datos
$conn = new mysqli("192.168.100.10", "cliente_madet", "Cliente12345", "MADET");
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Ejecutar la consulta sin índice
$result = $conn->query($consulta);

if ($result && $result->num_rows > 0) {
    // Crear la tabla HTML para mostrar los resultados
    echo "<link rel='stylesheet' href='salida.css'>";
    echo "<table class='result-table'>";
    echo "<tr>";

    // Mostrar los nombres de las columnas (encabezados de la tabla)
    $fields = $result->fetch_fields();
    foreach ($fields as $field) {
        echo "<th>" . ucfirst($field->name) . "</th>";
    }
    echo "</tr>";

    // Mostrar los resultados de las filas
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        foreach ($row as $data) {
            echo "<td>" . htmlspecialchars($data) . "</td>";
        }
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "No se encontraron resultados para la consulta.";
}

$conn->close();
?>
