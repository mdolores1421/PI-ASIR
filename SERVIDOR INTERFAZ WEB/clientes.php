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

// Obtener columnas de la tabla clientes
$columns = [];
$result = $conn->query("SHOW COLUMNS FROM clientes");
while ($row = $result->fetch_assoc()) {
    $columns[] = $row['Field'];
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Filtrar Clientes</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Filtrar Clientes</h2>
        <form action="resultado.php" method="GET">
            <input type="hidden" name="tabla" value="clientes">
            <div id="filtros">
                <div class="filtro">
                    <label>Campo:</label>
                    <select name="campo[]">
                        <?php foreach ($columns as $column): ?>
                            <option value="<?php echo $column; ?>"><?php echo $column; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <label>Valor:</label>
                    <input type="text" name="valor[]">
                    <button type="button" onclick="eliminarFiltro(this)">Eliminar</button>
                </div>
            </div>
            <button type="button" onclick="agregarFiltro()">Añadir Filtro</button>
            <button type="submit">Ejecutar Consulta</button>
        </form>
        <br>
        <button onclick="window.location.href='simple.php'">Volver</button>
        <button onclick="window.location.href='index.php'">Cerrar sesión</button>
    </div>

    <script>
        function agregarFiltro() {
            var div = document.createElement("div");
            div.classList.add("filtro");
            div.innerHTML = '<label>Campo:</label>' +
                            '<select name="campo[]">' +
                            <?php foreach ($columns as $column): ?>
                                '<option value="<?php echo $column; ?>"><?php echo $column; ?></option>' +
                            <?php endforeach; ?>
                            '</select>' +
                            '<label>Valor:</label>' +
                            '<input type="text" name="valor[]">' +
                            '<button type="button" onclick="eliminarFiltro(this)">Eliminar</button>';
            document.getElementById("filtros").appendChild(div);
        }

        function eliminarFiltro(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>
