<?php
date_default_timezone_set("America/Mexico_City");

$conn = new mysqli(
    "HOST",
    "USER",
    "PASSWORD",
    "DATABASE"
);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// CONFIGURACIÓN
define("TARIFA_MEDIA_HORA", 18);     // $18 cada 30 min
define("TOLERANCIA_SEGUNDOS", 15);   // 15 segundos gratis
define("SEGUNDOS_MEDIA_HORA", 1800); // 30 min = 1800 seg
define("MAX_DIA", 300);              // Máximo a cobrar por día
