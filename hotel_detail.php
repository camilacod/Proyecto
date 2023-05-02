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

if (isset($_GET["id"])) {
    $hotelId = $_GET["id"];
    $sql = "SELECT h.*, r.price FROM hotels h JOIN rooms r ON h.id = r.hotel_id WHERE h.id = ?";

    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "i", $hotelId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            "success" => true,
            "result" => $row
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "No hotel found with the given ID"
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "No hotel ID provided"
    ]);
}

// Close connection
mysqli_close($link);
?>