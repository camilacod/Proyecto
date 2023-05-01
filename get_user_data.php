<?php
session_start();

// Database connection
$link = mysqli_connect("localhost", "root", "");
if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (!mysqli_select_db($link, "hotel_reservation")) {
    die("Error al seleccionar la base de datos: " . mysqli_error($link));
}

if (isset($_SESSION["user_id"])) {
    $user_id = $_SESSION["user_id"];

    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $user_email = $row["email"];

    // Fetch reservations data
    $sql_reservations = "SELECT * FROM reservations WHERE user_id = ?";
    $stmt_reservations = mysqli_prepare($link, $sql_reservations);
    mysqli_stmt_bind_param($stmt_reservations, "i", $user_id);
    mysqli_stmt_execute($stmt_reservations);
    $result_reservations = mysqli_stmt_get_result($stmt_reservations);

    $reservations = [];
    while ($row_reservation = mysqli_fetch_assoc($result_reservations)) {
        $reservations[] = $row_reservation;
    }

    $response = [
        "success" => true,
        "email" => $user_email,
        "reservations" => $reservations,
    ];
    } else {
        $response = [
            "success" => false,
            "message" => "User not found",
        ];
    }
} else {
    $response = [
        "success" => false,
        "message" => "User not logged in",
    ];
}

mysqli_close($link);

header("Content-Type: application/json");
echo json_encode($response);
?>
