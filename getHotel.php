<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_reservation";

$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Consulta a la base de datos
$sql = "SELECT id, nombre, direccion, latitud, longitud FROM hotel";
$result = $conn->query($sql);
$conn->close();

$datos = array();
foreach ($result as $fila) {
    $datos[] = array(
        'id' => $fila['id'],
        'nombre' => $fila['nombre'],
        'direccion' => $fila['direccion'],
        'latitud' => $fila['latitud'],
        'longitud' => $fila['longitud']
    );
}

// Convertir el array a formato JSON y enviarlo como respuesta
header('Content-Type: application/json');
echo json_encode($datos);
?>