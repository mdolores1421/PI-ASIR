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

$tabla1 = isset($_GET['tabla1']) ? $conn->real_escape_string($_GET['tabla1']) : '';
$tabla2 = isset($_GET['tabla2']) ? $conn->real_escape_string($_GET['tabla2']) : '';

$query1 = "SHOW COLUMNS FROM `$tabla1`";
$query2 = "SHOW COLUMNS FROM `$tabla2`";

$result1 = $conn->query($query1);
$result2 = $conn->query($query2);

$campos1 = [];
$campos2 = [];
if ($result1) {
    while ($row = $result1->fetch_assoc()) {
        $campos1[] = $row['Field'];
    }
}
if ($result2) {
    while ($row = $result2->fetch_assoc()) {
        $campos2[] = $row['Field'];
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seleccionar Campos</title>
    <link rel="stylesheet" type="text/css" href="seleccion_campos.css">
</head>
<body>
    <h2>Selecciona los campos a mostrar</h2>
    <form action="filtroscompleja.php" method="GET">
        <input type="hidden" name="tabla1" value="<?php echo htmlspecialchars($tabla1); ?>">
        <input type="hidden" name="tabla2" value="<?php echo htmlspecialchars($tabla2); ?>">

        <div class="contenedor">
            <div class="tabla">
                <h3><?php echo htmlspecialchars($tabla1); ?></h3>
                <?php foreach ($campos1 as $campo) : ?>
                    <label>
                        <input type="checkbox" name="campos_<?php echo $tabla1; ?>[]" value="<?php echo $campo; ?>">
                        <?php echo $campo; ?>
                    </label><br>
                <?php endforeach; ?>
            </div>

            <div class="tabla">
                <h3><?php echo htmlspecialchars($tabla2); ?></h3>
                <?php foreach ($campos2 as $campo) : ?>
                    <label>
                        <input type="checkbox" name="campos_<?php echo $tabla2; ?>[]" value="<?php echo $campo; ?>">
                        <?php echo $campo; ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
        </div>

        <button type="submit">Continuar con Filtros</button>
    </form>
</body>
</html>
