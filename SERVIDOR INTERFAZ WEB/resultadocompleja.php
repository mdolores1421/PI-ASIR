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

$tabla1 = $_GET['tabla1'];
$tabla2 = $_GET['tabla2'];
$campos1 = $_GET["campos_$tabla1"];
$campos2 = $_GET["campos_$tabla2"];

// Medimos tiempo estimado
$campos_sql = [];
foreach ($campos1 as $campo) $campos_sql[] = "`$tabla1`.`$campo`";
foreach ($campos2 as $campo) $campos_sql[] = "`$tabla2`.`$campo`";
$select = implode(", ", $campos_sql);

// Obtener claves dinámicamente (PK y FK)
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
$pk1 = obtener_clave_primaria($conn, $tabla1);
$fk2 = obtener_clave_foranea($conn, $tabla2);

$query = "SELECT $select FROM `$tabla1` INNER JOIN `$tabla2` ON `$tabla1`.`$pk1` = `$tabla2`.`$fk2`";

// Filtros (opcional)
$condiciones = [];
if (isset($_GET["campo_$tabla1"])) {
    foreach ($_GET["campo_$tabla1"] as $i => $campo) {
        $valor = $conn->real_escape_string($_GET["valor_$tabla1"][$i]);
        $condiciones[] = "`$tabla1`.`$campo` = '$valor'";
    }
}
if (isset($_GET["campo_$tabla2"])) {
    foreach ($_GET["campo_$tabla2"] as $i => $campo) {
        $valor = $conn->real_escape_string($_GET["valor_$tabla2"][$i]);
        $condiciones[] = "`$tabla2`.`$campo` = '$valor'";
    }
}
if (!empty($condiciones)) {
    $query .= " WHERE " . implode(" AND ", $condiciones);
}

// Tiempo estimado
$inicio = microtime(true);
$conn->query($query);
$tiempo = microtime(true) - $inicio;

// Mostrar mensaje
echo "<link rel='stylesheet' href='salida.css'>";
echo "<h2>Tiempo estimado de ejecución: " . round($tiempo, 4) . " segundos</h2>";
echo "<form method='post' action='crear_indice_compl.php'>";
foreach ($_GET as $key => $val) {
    if (is_array($val)) {
        foreach ($val as $item) {
            echo "<input type='hidden' name='{$key}[]' value='$item'>";
        }
    } else {
        echo "<input type='hidden' name='$key' value='$val'>";
    }
}
echo "<button type='submit'>✅ Crear Índice</button>";
echo "</form>";

echo "<form method='post' action='ejecutar_consulta_compl.php'>";
foreach ($_GET as $key => $val) {
    if (is_array($val)) {
        foreach ($val as $item) {
            echo "<input type='hidden' name='{$key}[]' value='$item'>";
        }
    } else {
        echo "<input type='hidden' name='$key' value='$val'>";
    }
}
echo "<button type='submit'>❌ No crear Índice</button>";
echo "</form>";
?>
