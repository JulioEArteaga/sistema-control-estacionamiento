<?php
require "config.php";

$id = $_GET['id'];
$usuario = $conn->query("SELECT * FROM usuarios WHERE id=$id")->fetch_assoc();

if ($_POST) {
    $nuevo_usuario = $_POST['usuario'];

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $conn->query("UPDATE usuarios SET usuario='$nuevo_usuario', password='$password' WHERE id=$id");
    } else {
        $conn->query("UPDATE usuarios SET usuario='$nuevo_usuario' WHERE id=$id");
    }

    header("Location: usuarios.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Editar Usuario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<div class="container mt-4">
    <h2>Editar Usuario</h2>

    <form method="POST">
        <label>Usuario</label>
        <input type="text" name="usuario" class="form-control" value="<?= $usuario['usuario'] ?>" required>

        <label class="mt-2">Nueva Contraseña (opcional)</label>
        <input type="password" name="password" class="form-control">

        <button class="btn btn-primary mt-3">Actualizar</button>
        <a href="usuarios.php" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>

</body>
</html>
