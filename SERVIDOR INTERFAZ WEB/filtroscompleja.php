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

$campos1 = isset($_GET["campos_$tabla1"]) ? $_GET["campos_$tabla1"] : [];
$campos2 = isset($_GET["campos_$tabla2"]) ? $_GET["campos_$tabla2"] : [];

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Filtros Consulta Compleja</title>
    <link rel="stylesheet" type="text/css" href="filtroscompleja.css">
</head>
<body>
    <h2>Filtros para la consulta</h2>
    <form id="consultaForm" action="resultadocompleja.php" method="GET">
        <input type="hidden" name="tabla1" value="<?php echo htmlspecialchars($tabla1); ?>">
        <input type="hidden" name="tabla2" value="<?php echo htmlspecialchars($tabla2); ?>">

        <?php foreach ($campos1 as $campo) : ?>
            <input type="hidden" name="campos_<?php echo $tabla1; ?>[]" value="<?php echo htmlspecialchars($campo); ?>">
        <?php endforeach; ?>

        <?php foreach ($campos2 as $campo) : ?>
            <input type="hidden" name="campos_<?php echo $tabla2; ?>[]" value="<?php echo htmlspecialchars($campo); ?>">
        <?php endforeach; ?>

        <div class="contenedor">
            <div class="filtros">
                <h3><?php echo htmlspecialchars($tabla1); ?></h3>
                <div id="filtros_<?php echo htmlspecialchars($tabla1); ?>">
                    <button type="button" onclick="agregarFiltro('<?php echo $tabla1; ?>')">Agregar Filtro</button>
                </div>
            </div>

            <div class="filtros">
                <h3><?php echo htmlspecialchars($tabla2); ?></h3>
                <div id="filtros_<?php echo htmlspecialchars($tabla2); ?>">
                    <button type="button" onclick="agregarFiltro('<?php echo $tabla2; ?>')">Agregar Filtro</button>
                </div>
            </div>
        </div>

        <button type="submit">Ejecutar Consulta</button>
    </form>

    <script>
        let camposPorTabla = {
            "<?php echo $tabla1; ?>": <?php echo json_encode($campos1); ?>,
            "<?php echo $tabla2; ?>": <?php echo json_encode($campos2); ?>
        };

        function agregarFiltro(tabla) {
            let divFiltros = document.getElementById("filtros_" + tabla);
            let div = document.createElement("div");

            let selectHTML = `<select name="campo_` + tabla + `[]">`;
            camposPorTabla[tabla].forEach(campo => {
                selectHTML += `<option value="` + campo + `">` + campo + `</option>`;
            });
            selectHTML += `</select>`;

            div.innerHTML = selectHTML + `
                <input type="text" name="valor_` + tabla + `[]" placeholder="Valor">
                <button type="button" onclick="this.parentNode.remove()">Eliminar</button>
            `;

            divFiltros.appendChild(div);
        }
    </script>
</body>
</html>
