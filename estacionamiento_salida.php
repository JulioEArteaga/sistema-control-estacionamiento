<?php
require "config.php";

$id = intval($_GET['id']);

// Obtener registro
$res = $conn->query("SELECT * FROM estacionamientos WHERE id = $id");
if (!$res || $res->num_rows === 0) {
    die("Registro no encontrado");
}
$data = $res->fetch_assoc();

// ================= TIEMPOS =================

// Hora de entrada usando PHP
$entrada_ts = strtotime($data['hora_entrada']);

// Hora de salida actual
$salida_ts = time();

// Diferencia real en segundos
$segundos = $salida_ts - $entrada_ts;

// Fecha salida formateada
$horaSalida = date('Y-m-d H:i:s', $salida_ts);

/* ================= COBRO ================= */

if ($segundos <= TOLERANCIA_SEGUNDOS) {
    $bloques = 0;
    $total = 0;
} else {
    $segundos_cobrables = $segundos - TOLERANCIA_SEGUNDOS;
    $bloques = ceil($segundos_cobrables / SEGUNDOS_MEDIA_HORA);
    $total = $bloques * TARIFA_MEDIA_HORA;
    if ($total > MAX_DIA) {
        $total = MAX_DIA;
    }
}

/* ================= GUARDAR ================= */

$sql = $conn->prepare("
    UPDATE estacionamientos
    SET 
        hora_salida = ?,
        segundos = ?,
        horas = ?,
        total = ?
    WHERE id = ?
");

$sql->bind_param("siidi", $horaSalida, $segundos, $bloques, $total, $id);
$sql->execute();

header("Location: estacionamientos.php");
exit;

