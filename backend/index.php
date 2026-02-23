<?php 
echo "<h1>SocialPulse - Diagnostico del sistema</h1>";

// Verificacion PHP
echo "<h2>PHP</h2>";
echo "✅ PHP " . phpversion() . " funcionando";

// Verificacion MySQL
echo "<h2>MySQL</h2>";
$conn = new mysqli(
    getenv('DB_HOST'),
    getenv('DB_USER'),
    getenv('DB_PASSWORD'),
    getenv('DB_NAME'),
);
if ($conn->connect_error) { 
    echo "❌ Error: " . $conn->connect_error;
} else {
    echo "✅ MySQL conectado correctamente";
    $conn->close();
}

// Verificar Redis
echo "<h2>Redis</h2>";
$redis = fsockopen("redis", 6379, $errno, $errstr, 3);
if ($redis) {
    echo "✅ Redis accesible";
    fclose($redis);
} else {
    echo "❌ Error: " . $errstr;
}
?>