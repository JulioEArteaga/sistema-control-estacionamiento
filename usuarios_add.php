<?php
require "config.php";

if ($_POST) {
    $usuario = $_POST['usuario'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = $conn->prepare("INSERT INTO usuarios (usuario, password) VALUES (?, ?)");
    $sql->bind_param("ss", $usuario, $password);
    $sql->execute();

    header("Location: usuarios.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Agregar Usuario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Agregar Usuario</h2>

    <form method="POST">
        <label>Usuario</label>
        <input type="text" name="usuario" class="form-control" required>

        <label class="mt-2">Contraseña</label>
        <input type="password" name="password" class="form-control" required>

        <button class="btn btn-success mt-3">Guardar</button>
        <a href="usuarios.php" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>

</body>
</html>
