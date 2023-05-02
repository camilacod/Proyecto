<?php
// Database connection
$link = mysqli_connect("localhost", "root", "");
if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (!mysqli_select_db($link, "hotel_reservation")) {
    die("Error al seleccionar la base de datos: " . mysqli_error($link));
}

// Get form data
$room_id = $_POST['room-id'];
$check_in_date = $_POST['check-in-date'];
$check_out_date = $_POST['check-out-date'];
$email = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

// Check if user exists, if not create user
$sql = "SELECT id FROM users WHERE email = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    $user_id = $row['id'];
} else {
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);
    mysqli_stmt_execute($stmt);
    $user_id = mysqli_insert_id($link);
}

// Create reservation
$sql = "INSERT INTO reservations (user_id, room_id, check_in, check_out) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "iiss", $user_id, $room_id, $check_in_date, $check_out_date);
mysqli_stmt_execute($stmt);

if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "<p>Ok, reservation made successfully.</p>";
} else {
    echo "<p>Error making the reservation: " . mysqli_error($link) . "</p>";
}

// Close connection
mysqli_close($link);
?>