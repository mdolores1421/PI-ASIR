<?php
session_start();
$conn = new mysqli("192.168.100.10", "cliente_madet", "Cliente12345", "MADET");

$tabla1 = $_POST['tabla1'];
$tabla2 = $_POST['tabla2'];
$pk1 = obtener_clave_primaria($conn, $tabla1);
$fk2 = obtener_clave_foranea($conn, $tabla2);

// Intentar crear índices (si no existen)
$conn->query("CREATE INDEX IF NOT EXISTS idx_{$tabla1}_$pk1 ON `$tabla1`(`$pk1`)");
$conn->query("CREATE INDEX IF NOT EXISTS idx_{$tabla2}_$fk2 ON `$tabla2`(`$fk2`)");

// Redirigir a ejecutar consulta
echo "<form id='redirigir' method='post' action='ejecutar_consulta_compl.php'>";
foreach ($_POST as $key => $val) {
    if (is_array($val)) {
        foreach ($val as $item) {
            echo "<input type='hidden' name='{$key}[]' value='$item'>";
        }
    } else {
        echo "<input type='hidden' name='$key' value='$val'>";
    }
}
echo "</form>";
echo "<script>document.getElementById('redirigir').submit();</script>";

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
