<?php
// Aquí vamos a introducir las coordenadas de diferentes lugares de Perú
$listaCoordenadas = array();
$newCoord = array(-11.860986, -77.128289);
array_push($listaCoordenadas,$newCoord);
$newCoord = array(-11.860006, -77.034669);
array_push($listaCoordenadas,$newCoord);
$newCoord = array(-11.960014, -77.075296);
array_push($listaCoordenadas,$newCoord);
$newCoord = array(-11.990262, -76.878979);
array_push($listaCoordenadas,$newCoord);

/*
CREATE DATABASE dbp;

use dbp;

CREATE TABLE hotelsv2 (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  address VARCHAR(255) NOT NULL,
  city VARCHAR(100) NOT NULL,
  rating DECIMAL(3, 2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  latitud FLOAT NOT NULL,
  longitud FLOAT NOT NULL
);

Es importante agregar la restricción de coordenadas unicas para evitar e registro de valores repetidos
*/

// Conexión a la base de datos
$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'dbp';
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

// Obtener los datos de la API de Google Maps
$api_key = 'AIzaSyBEwnVmId5hohTwj2z0dtBjSK8OPOTuGa8';
$search_query = 'hotel';
$radius = 5000;

foreach ($listaCoordenadas as $coord) {
    $latitude = $coord[0];
    $longitude = $coord[1];
    $url = "https://maps.googleapis.com/maps/api/place/nearbysearch/json?key=$api_key&location=$latitude,$longitude&radius=$radius&keyword=$search_query";
    $data = file_get_contents($url);
    $results = json_decode($data);

    // Guardar los datos en la tabla "hotel"
    foreach ($results->results as $result) {
        $name = mysqli_real_escape_string($conn, $result->name);
        $address = mysqli_real_escape_string($conn, $result->vicinity);
        $lat = $result->geometry->location->lat;
        $lng = $result->geometry->location->lng;
        $rating = rand(0,100)/10;

        $sql = "INSERT INTO hotel (name, direccion_completa, latitud, longitud, puntuacion) VALUES ('$name', '$address', '$lat', '$lng', '$rating')";
        mysqli_query($conn, $sql);
    }
}

echo "Datos insertados con exito <br>";
mysqli_close($conn);

/*
Ventanilla: -11.860986, -77.128289
Carabayllo: -11.860006, -77.034669
Los Olivos: -11.960014, -77.075296
San Juan de Lurigancho: -11.990262, -76.878979
Ate: -12.017748, -76.921506
Santiago de Surco: -12.135665, -76.991841
Villa el Salvador: -12.246925, -76.916439
Villa María del Triunfo: -12.203921, -76.948880
San Borja: -12.100830, -76.999207
Callao: -12.024227, -77.113587
*/
?>
