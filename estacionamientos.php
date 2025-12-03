<?php
require "config.php";

/* =============================
   TOTALES
============================= */

$totalLugares = $conn->query(
    "SELECT total_lugares FROM configuracion WHERE id = 1"
)->fetch_assoc()['total_lugares'];

$ocupados = $conn->query(
    "SELECT COUNT(*) AS total 
     FROM estacionamientos 
     WHERE hora_salida IS NULL"
)->fetch_assoc()['total'];

$disponibles = $totalLugares - $ocupados;

/* =============================
   REGISTROS (NUEVOS ARRIBA)
============================= */
$result = $conn->query(
    "SELECT * FROM estacionamientos ORDER BY id DESC"
);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Estacionamiento</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>🚗 Control de Estacionamiento</h2>

    <a href="dashboard.php" class="btn btn-secondary mb-2">← Regresar</a>
    <a href="estacionamiento_add.php" class="btn btn-success mb-2">+ Registrar Entrada</a>

    <div class="alert alert-info mt-3">
        <strong>Total lugares:</strong> <?= $totalLugares ?> |
        <strong>Ocupados:</strong> <?= $ocupados ?> |
        <strong>Disponibles:</strong> <?= $disponibles ?>
    </div>

    <table class="table table-bordered table-striped mt-3 text-center align-middle">
        <thead>
        <tr>
            <th>ID</th>
            <th>Placa</th>
            <th>Tipo</th>
            <th>Entrada</th>
            <th>Salida</th>
            <th>Tiempo cobrado</th>
            <th>Total ($)</th>
            <th>Acción</th>
        </tr>
        </thead>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['placa']) ?></td>
            <td><?= $row['tipo'] ?></td>
            <td><?= $row['hora_entrada'] ?></td>
            <td><?= $row['hora_salida'] ?: '—' ?></td>

            <!-- TIEMPO REAL (desde segundos) -->
            <td>
            <?php
            if ($row['hora_salida'] && $row['segundos'] !== NULL) {

                $seg = (int)$row['segundos'];

                $h = floor($seg / 3600);
                $m = floor(($seg % 3600) / 60);
                $s = $seg % 60;

                $txt = [];

                if ($h > 0) $txt[] = $h . ' hora' . ($h > 1 ? 's' : '');
                if ($m > 0) $txt[] = $m . ' min';
                if ($h == 0 && $m == 0) $txt[] = $s . ' seg';

                echo implode(' ', $txt);
            } else {
                echo '—';
            }
            ?>
            </td>

            <td>
                <?= $row['total'] !== NULL ? '$'.number_format($row['total'],2) : '—' ?>
            </td>

            <td>
                <?php if ($row['hora_salida'] === NULL): ?>
                    <a href="estacionamiento_salida.php?id=<?= $row['id'] ?>"
                       class="btn btn-danger btn-sm">
                        Registrar salida
                    </a>
                <?php else: ?>
                    ✅ Finalizado
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
