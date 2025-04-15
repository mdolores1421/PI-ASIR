<?php
session_start();

// Datos de conexión
$servername = "localhost";
$username = "cliente_madet";
$password = "Cliente12345";
$database = "MADET";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_password = $_POST['password'];

    if ($input_password === $password) {
        $_SESSION['authenticated'] = true;
        header("Location: consultas.php");
        exit();
    } else {
        $error = "Contraseña incorrecta";
    }
}

// Si ya está autenticado, redirigir directamente a consultas.php
if (isset($_SESSION['authenticated']) && $_SESSION['authenticated'] === true) {
    header("Location: consultas.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Acceso a MADET</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Acceso a MADET</h2>
        <form method="POST" action="index.php">
            <label>Usuario</label>
            <input type="text" value="cliente_madet" disabled>
            <label>Contraseña</label>
            <input type="password" name="password" required>
            <button type="submit">Conectar</button>
            <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        </form>
    </div>
</body>
</html>
