<?php
require "config.php";

// Si viene el formulario (POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $placa = strtoupper(trim($_POST['placa']));
    $tipo  = trim($_POST['tipo']);

    // Hora de entrada usando la zona horaria de PHP (America/Mexico_City)
    $horaEntrada = date('Y-m-d H:i:s');

    $sql = $conn->prepare("
        INSERT INTO estacionamientos (placa, tipo, hora_entrada)
        VALUES (?, ?, ?)
    ");
    $sql->bind_param("sss", $placa, $tipo, $horaEntrada);
    $sql->execute();

    header("Location: estacionamientos.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Registrar entrada</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2>Registrar entrada</h2>

    <a href="estacionamientos.php" class="btn btn-secondary mb-3">← Regresar</a>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Placa</label>
            <input type="text" name="placa" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-select">
                <option value="Automóvil">Automóvil</option>
                <option value="Motocicleta">Motocicleta</option>
            </select>
        </div>

        <button class="btn btn-primary">Guardar entrada</button>
    </form>
</div>
</body>
</html>

