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

$tabla = isset($_GET['tabla']) ? $conn->real_escape_string($_GET['tabla']) : '';
$campos = isset($_GET['campo']) ? $_GET['campo'] : [];
$valores = isset($_GET['valor']) ? $_GET['valor'] : [];

if (!empty($tabla) && !empty($campos) && !empty($valores) && count($campos) == count($valores)) {
    $condiciones = [];
    for ($i = 0; $i < count($campos); $i++) {
        $campo = $conn->real_escape_string($campos[$i]);
        $valor = $conn->real_escape_string($valores[$i]);
        $condiciones[] = "`$campo` = '$valor'";
    }

    $where = implode(" AND ", $condiciones);
    $query = "SELECT * FROM `$tabla` WHERE $where";

    // Simular el tiempo estimado de ejecución
    $start = microtime(true);
    $conn->query($query);
    $tiempo_estimado = microtime(true) - $start;

    $campos_where = implode(",", $campos); // Para el índice
    ?>
    <form id="redirectForm" method="POST" action="preguntar_indice.php">
        <input type="hidden" name="consulta" value="<?php echo htmlspecialchars($query); ?>">
        <input type="hidden" name="tabla" value="<?php echo htmlspecialchars($tabla); ?>">
        <input type="hidden" name="campos_where" value="<?php echo htmlspecialchars($campos_where); ?>">
        <input type="hidden" name="tiempo_estimado" value="<?php echo $tiempo_estimado; ?>">
    </form>
    <script>
        document.getElementById('redirectForm').submit();
    </script>
    <?php
    exit();
} else {
    die("Faltan parámetros para generar la consulta.");
}
?>
