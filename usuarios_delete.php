<?php
require "config.php";

$id = intval($_GET['id']);

$res = $conn->query("SELECT rol FROM usuarios WHERE id = $id");
$u = $res->fetch_assoc();

// Bloquear eliminación del admin
if ($u && $u['rol'] === 'admin') {
    header("Location: usuarios.php");
    exit;
}

$conn->query("DELETE FROM usuarios WHERE id = $id");

header("Location: usuarios.php");
exit;
