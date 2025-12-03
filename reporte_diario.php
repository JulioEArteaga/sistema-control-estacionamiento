<?php
session_start();

// SOLO ADMIN
if (!isset($_SESSION['usuario']) || $_SESSION['rol'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

require "config.php";

// Fecha seleccionada o hoy
$fecha = $_GET['fecha'] ?? date('Y-m-d');

// Registros del día
$registros = $conn->query("
    SELECT *
    FROM estacionamientos
    WHERE DATE(hora_entrada) = '$fecha'
    ORDER BY hora_entrada DESC
");

// Entradas del día
$entradas = $conn->query("
    SELECT COUNT(*) total
    FROM estacionamientos
    WHERE DATE(hora_entrada) = '$fecha'
")->fetch_assoc()['total'];

// Salidas del día
$salidas = $conn->query("
    SELECT COUNT(*) total
    FROM estacionamientos
    WHERE hora_salida IS NOT NULL
      AND DATE(hora_salida) = '$fecha'
")->fetch_assoc()['total'];

// Total recaudado
$total_dia = $conn->query("
    SELECT SUM(total) total
    FROM estacionamientos
    WHERE hora_salida IS NOT NULL
      AND DATE(hora_salida) = '$fecha'
")->fetch_assoc()['total'];

$total_dia = $total_dia ?? 0;

// Vehículos con tolerancia
$tolerancias = $conn->query("
    SELECT COUNT(*) total
    FROM estacionamientos
    WHERE hora_salida IS NOT NULL
      AND total = 0
      AND DATE(hora_salida) = '$fecha'
")->fetch_assoc()['total'];

// Boletos por monto
$boletosMonto = $conn->query("
    SELECT total, COUNT(*) cantidad
    FROM estacionamientos
    WHERE hora_salida IS NOT NULL
      AND DATE(hora_salida) = '$fecha'
    GROUP BY total
    ORDER BY total ASC
");
?>

<!DOCTYPE html>
<html>
<head>
<title>Reporte Diario</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>📊 Reporte Diario</h2>

    <!-- Selector de fecha -->
    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="date" name="fecha" class="form-control" value="<?= $fecha ?>">
        </div>
        <div class="col-auto">
            <button class="btn btn-primary">Ver reporte</button>
        </div>
        <div class="col-auto">
            <a href="dashboard.php" class="btn btn-secondary">← Regresar</a>
        </div>
    </form>

    <!-- Resumen -->
    <div class="row mb-3">
        <div class="col-md-4">
            <div class="alert alert-primary">
                <strong>Entradas:</strong> <?= $entradas ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="alert alert-success">
                <strong>Salidas:</strong> <?= $salidas ?>
            </div>
        </div>

        <div class="col-md-4">
            <div class="alert alert-warning">
                <strong>Total Recaudado:</strong>
                $<?= number_format($total_dia,2) ?>
            </div>
        </div>
    </div>

    <!-- Información operativa -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="alert alert-info">
                🚗 <strong>Vehículos ingresados:</strong><br>
                <?= $entradas ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-success">
                🕒 <strong>Salidas por tolerancia:</strong><br>
                <?= $tolerancias ?>
            </div>
        </div>
    </div>

    <!-- Boletos por monto -->
    <h4>🎟️ Boletos por monto</h4>
    <table class="table table-bordered text-center mb-4">
        <tr>
            <th>Monto</th>
            <th>Cantidad</th>
        </tr>
        <?php while ($b = $boletosMonto->fetch_assoc()): ?>
        <tr>
            <td>$<?= number_format($b['total'],2) ?></td>
            <td><?= $b['cantidad'] ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <!-- Detalle de transacciones -->
    <h4>📋 Detalle de Transacciones</h4>
    <table class="table table-bordered table-striped text-center">
        <tr>
            <th>ID</th>
            <th>Placa</th>
            <th>Tipo</th>
            <th>Entrada</th>
            <th>Salida</th>
            <th>Total</th>
        </tr>

        <?php while ($row = $registros->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['placa'] ?></td>
            <td><?= $row['tipo'] ?></td>
            <td><?= $row['hora_entrada'] ?></td>
            <td><?= $row['hora_salida'] ?? '—' ?></td>
            <td><?= $row['total'] !== NULL ? '$'.number_format($row['total'],2) : '—' ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

</div>

</body>
</html>

