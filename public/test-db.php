<?php
$host = "127.0.0.1";
$db = "may17and_YachayBD";
$user = "may17and_yachay";
$pass = "Yachay12345.";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("❌ Falló la conexión: " . $conn->connect_error);
}
echo "✅ Conexión exitosa a la base de datos.";
?>
