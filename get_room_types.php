<?php
header("Content-Type: application/json");

// Database connection
$link = mysqli_connect("localhost", "root", "");
if (!$link) {
    die(json_encode([
        "success" => false,
        "message" => "Error de conexión: " . mysqli_connect_error()
    ]));
}

if (!mysqli_select_db($link, "hotel_reservation")) {
    die(json_encode([
        "success" => false,
        "message" => "Error al seleccionar la base de datos: " . mysqli_error($link)
    ]));
}

if (isset($_GET["hotel_id"])) {
    $hotelId = $_GET["hotel_id"];
    $sql = "SELECT id, room_type, price FROM rooms WHERE hotel_id = ?";

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "i", $hotelId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $roomTypes = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $roomTypes[] = $row;
    }

    echo json_encode([
        "success" => true,
        "result" => $roomTypes
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "No hotel ID provided"
    ]);
}

// Close connection
mysqli_close($link);
?>