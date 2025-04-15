<?php
session_start();
if (!isset($_SESSION['authenticated'])) {
    header("Location: index.php");
    exit();
}

if (!isset($_POST['consulta']) || !isset($_POST['tabla']) || !isset($_POST['campos_where']) || !isset($_POST['tiempo_estimado'])) {
    echo "Faltan datos necesarios.";
    exit();
}

$consulta = $_POST['consulta'];
$tabla = $_POST['tabla'];
$campos_where = $_POST['campos_where'];
$tiempo_estimado = $_POST['tiempo_estimado'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>¿Crear índice?</title>
    <link rel="stylesheet" href="salida.css">
</head>
<body>
    <div class="container">
        <h2>Tiempo estimado de ejecución: <?php echo round($tiempo_estimado, 3); ?> segundos</h2>
        <p>¿Deseas crear un índice para optimizar la consulta?</p>
        <form method="POST" action="crear_indice.php">
            <input type="hidden" name="consulta" value="<?php echo htmlspecialchars($consulta); ?>">
            <input type="hidden" name="tabla" value="<?php echo htmlspecialchars($tabla); ?>">
            <input type="hidden" name="campos_where" value="<?php echo htmlspecialchars($campos_where); ?>">
            <button type="submit">Sí, crear índice</button>
        </form>
        <form method="POST" action="ejecutar_consulta.php">
            <input type="hidden" name="consulta" value="<?php echo htmlspecialchars($consulta); ?>">
            <button type="submit">No, ejecutar sin índice</button>
        </form>
    </div>
</body>
</html>
