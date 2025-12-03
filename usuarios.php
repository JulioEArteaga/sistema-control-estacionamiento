<?php
session_start();
if ($_SESSION['rol'] !== 'admin') {
    header("Location: dashboard.php");
    exit;
}

require "config.php";

$usuarios = $conn->query("SELECT * FROM usuarios");
?>

<!DOCTYPE html>
<html>
<head>
<title>Usuarios</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">
    <h2>Usuarios</h2>

    <a href="dashboard.php" class="btn btn-secondary mb-3">← Regresar</a>
    <a href="usuarios_add.php" class="btn btn-success mb-3">+ Agregar Usuario</a>

    <table class="table table-bordered table-striped text-center">
        <tr>
            <th>ID</th>
            <th>Usuario</th>
            <th>Fecha</th>
            <th>Acciones</th>
        </tr>

        <?php while ($row = $usuarios->fetch_assoc()) : ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td>
                <?= $row['usuario'] ?>
                <?php if ($row['usuario'] === 'admin'): ?>
                    <span class="badge bg-primary ms-2">ADMIN</span>
                <?php endif; ?>
            </td>

            <td><?= $row['fecha_registro'] ?></td>

            <!-- NUEVO BLOQUE DE ACCIONES -->
            <td>
                <?php if ($row['rol'] === 'admin'): ?>
                    <span class="badge bg-secondary">
                        🔒 Protegido
                    </span>
                <?php else: ?>
                    <a href="usuarios_edit.php?id=<?= $row['id'] ?>" 
                       class="btn btn-warning btn-sm">
                       Editar
                    </a>

                    <a href="usuarios_delete.php?id=<?= $row['id'] ?>" 
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('¿Eliminar este usuario?')">
                       Eliminar
                    </a>
                <?php endif; ?>
            </td>
            <!-- FIN BLOQUE NUEVO -->
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>
