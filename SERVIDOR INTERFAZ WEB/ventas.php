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

// Obtener columnas de la tabla ventas y sus tipos
$columns = [];
$result = $conn->query("SHOW COLUMNS FROM ventas");
while ($row = $result->fetch_assoc()) {
    $columns[$row['Field']] = $row['Type'];
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Consulta Ventas</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script>
        function actualizarTipoInput() {
            var campoSeleccionado = document.getElementById("campo").value;
            var inputValor = document.getElementById("valor");

            // Verificar si el campo seleccionado es fecha_venta
            if (campoSeleccionado === "fecha_venta") {
                inputValor.type = "date"; // Cambiar a selector de fecha
            } else {
                inputValor.type = "text"; // Por defecto, es texto
            }
        }

        // Función para añadir un nuevo filtro
        function agregarFiltro() {
            var div = document.createElement("div");
            div.classList.add("filtro");
            div.innerHTML = '<label>Campo:</label>' +
                            '<select name="campo[]">' +
                            <?php foreach ($columns as $column => $type): ?>
                                '<option value="<?php echo $column; ?>"><?php echo ucfirst($column); ?></option>' +
                            <?php endforeach; ?>
                            '</select>' +
                            '<label>Valor:</label>' +
                            '<input type="text" name="valor[]">' +
                            '<button type="button" onclick="eliminarFiltro(this)">Eliminar</button>';
            document.getElementById("filtros").appendChild(div);
        }

        // Función para eliminar un filtro
        function eliminarFiltro(button) {
            button.parentElement.remove();
        }
    </script>
</head>
<body>
    <div class="container">
        <h2>Consulta en Ventas</h2>
        <form action="resultado.php" method="GET">
            <input type="hidden" name="tabla" value="ventas">
            
            <div id="filtros">
                <div class="filtro">
                    <label for="campo">Selecciona el campo:</label>
                    <select name="campo[]" id="campo" onchange="actualizarTipoInput()" required>
                        <?php foreach ($columns as $col => $type): ?>
                            <option value="<?php echo $col; ?>"><?php echo ucfirst($col); ?></option>
                        <?php endforeach; ?>
                    </select>
                    
                    <label for="valor">Introduce el valor:</label>
                    <input type="text" id="valor" name="valor[]" required>
                    
                    <button type="button" onclick="eliminarFiltro(this)">Eliminar</button>
                </div>
            </div>
            
            <br><br>
            <button type="button" onclick="agregarFiltro()">Añadir Filtro</button>
            <button type="submit">Ejecutar Consulta</button>
            <button type="button" onclick="window.location.href='consultas.php'">Volver</button>
        </form>
    </div>
</body>
</html>
