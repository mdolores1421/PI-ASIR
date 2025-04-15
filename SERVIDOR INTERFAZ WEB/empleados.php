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

$fields = ["id", "nombre", "apellido", "puesto", "salario"];
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Filtrar Empleados</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Filtrar Empleados</h2>
        <form action="resultado.php" method="GET">
            <input type="hidden" name="tabla" value="empleados">
            
            <div id="filtros">
                <div class="filtro">
                    <label for="campo">Campo:</label>
                    <select name="campo[]">
                        <?php foreach ($fields as $field) { ?>
                            <option value="<?php echo $field; ?>"><?php echo ucfirst($field); ?></option>
                        <?php } ?>
                    </select>
                    <input type="text" name="valor[]" placeholder="Ingrese valor">
                    <button type="button" onclick="eliminarFiltro(this)">Eliminar</button>
                </div>
            </div>
            
            <button type="button" onclick="agregarFiltro()">Añadir Filtro</button>
            <button type="submit">Ejecutar Consulta</button>
        </form>
        <br>
        <button onclick="window.location.href='simple.php'">Volver</button>
    </div>

    <script>
        function agregarFiltro() {
            var div = document.createElement("div");
            div.classList.add("filtro");
            div.innerHTML = '<label for="campo">Campo:</label>' +
                            '<select name="campo[]">' +
                            <?php foreach ($fields as $field) { ?>
                                '<option value="<?php echo $field; ?>"><?php echo ucfirst($field); ?></option>' +
                            <?php } ?>
                            '</select>' +
                            '<input type="text" name="valor[]" placeholder="Ingrese valor">' +
                            '<button type="button" onclick="eliminarFiltro(this)">Eliminar</button>';
            document.getElementById("filtros").appendChild(div);
        }

        function eliminarFiltro(button) {
            button.parentElement.remove();
        }
    </script>
</body>
</html>
