<?php
session_start();
$conn = new mysqli("192.168.100.10", "cliente_madet", "Cliente12345", "MADET");

$tabla1 = $_POST['tabla1'];
$tabla2 = $_POST['tabla2'];
$campos1 = $_POST["campos_$tabla1"];
$campos2 = $_POST["campos_$tabla2"];

$pk1 = obtener_clave_primaria($conn, $tabla1);
$fk2 = obtener_clave_foranea($conn, $tabla2);

// Construcción de la consulta
$select = [];
foreach ($campos1 as $campo) $select[] = "`$tabla1`.`$campo`";
foreach ($campos2 as $campo) $select[] = "`$tabla2`.`$campo`";
$query = "SELECT " . implode(", ", $select) . " FROM `$tabla1` INNER JOIN `$tabla2` ON `$tabla1`.`$pk1` = `$tabla2`.`$fk2`";

$condiciones = [];
if (isset($_POST["campo_$tabla1"])) {
    foreach ($_POST["campo_$tabla1"] as $i => $campo) {
        $valor = $conn->real_escape_string($_POST["valor_$tabla1"][$i]);
        $condiciones[] = "`$tabla1`.`$campo` = '$valor'";
    }
}
if (isset($_POST["campo_$tabla2"])) {
    foreach ($_POST["campo_$tabla2"] as $i => $campo) {
        $valor = $conn->real_escape_string($_POST["valor_$tabla2"][$i]);
        $condiciones[] = "`$tabla2`.`$campo` = '$valor'";
    }
}
if (!empty($condiciones)) {
    $query .= " WHERE " . implode(" AND ", $condiciones);
}

$inicio = microtime(true);
$result = $conn->query($query);
$tiempo = microtime(true) - $inicio;

// Guardar en log
$stmt = $conn->prepare("INSERT INTO log_consultas (consulta, tiempo_ejecucion) VALUES (?, ?)");
$stmt->bind_param("sd", $query, $tiempo);
$stmt->execute();
$stmt->close();

// Mostrar resultados
echo "<link rel='stylesheet' href='salida.css'>";
echo "<table border='1'><tr>";
foreach ($campos1 as $campo) echo "<th>$campo</th>";
foreach ($campos2 as $campo) echo "<th>$campo</th>";
echo "</tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    foreach ($campos1 as $campo) echo "<td>{$row[$campo]}</td>";
    foreach ($campos2 as $campo) echo "<td>{$row[$campo]}</td>";
    echo "</tr>";
}
echo "</table>";

function obtener_clave_primaria($conn, $tabla) {
    $sql = "SHOW KEYS FROM `$tabla` WHERE Key_name = 'PRIMARY'";
    $res = $conn->query($sql);
    return $res->fetch_assoc()['Column_name'] ?? 'id';
}
function obtener_clave_foranea($conn, $tabla) {
    $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.KEY_COLUMN_USAGE WHERE TABLE_NAME = '$tabla' AND REFERENCED_COLUMN_NAME IS NOT NULL";
    $res = $conn->query($sql);
    return $res->fetch_assoc()['COLUMN_NAME'] ?? '';
}
?>
