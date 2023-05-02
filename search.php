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

// Handle search request
if ($_SERVER["REQUEST_METHOD"] == "POST" || isset($_GET["location"])) {
    $location = $_POST["location"] ?? $_GET["location"];
    $checkin = $_POST["checkin"] ?? $_GET["checkin"];
    $checkout = $_POST["checkout"] ?? $_GET["checkout"];
    $room_type = $_POST["room_type"] ?? $_GET["room_type"];

    $sql = "SELECT * FROM hotels WHERE city = ?";

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "s", $location);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $hotels = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $hotels[] = $row;
    }

    echo json_encode([
        "success" => true,
        "results" => $hotels
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method"
    ]);
}

// Close connection
mysqli_close($link);
?>