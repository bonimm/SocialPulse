<?php 
$host = getenv('DB_HOST');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error){
    die("Error de conexión: " . $conn->connect_error);
} else {
    echo "¡Conexión a MySQL exitosa!";
}
?>