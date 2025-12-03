<?php
session_start();

if (!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de Control</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">📊 Panel de Control</h2>

    <div class="row g-4">

        <!-- Estacionamiento (todos) -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>🚗 Estacionamiento</h5>
                    <a href="estacionamientos.php" class="btn btn-primary mt-2">Acceder</a>
                </div>
            </div>
        </div>

        <!-- Reporte diario (solo admin) -->
        <?php if ($_SESSION['rol'] === 'admin'): ?>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>📊 Reporte diario</h5>
                    <a href="reporte_diario.php" class="btn btn-success mt-2">Ver reporte</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Gestión de usuarios (SOLO ADMIN) -->
        <?php if ($_SESSION['rol'] === 'admin'): ?>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>👤 Gestión de usuarios</h5>
                    <a href="usuarios.php" class="btn btn-warning mt-2">Administrar</a>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Cerrar sesión -->
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <h5>🔒 Cerrar sesión</h5>
                    <a href="logout.php" class="btn btn-danger mt-2">Salir</a>
                </div>
            </div>
        </div>

    </div>
</div>

</body>
</html>

