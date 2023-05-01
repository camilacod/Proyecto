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

// Get form data
$email = $_POST['email'];
$password = $_POST['password'];

// Check if user exists and password is correct
$sql = "SELECT id, username, password FROM users WHERE email = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($row = mysqli_fetch_assoc($result)) {
    if ($password === $row['password']) {
        echo "success";
        $_SESSION["user_id"] = $row['id'];
    } else {
        echo "Invalid email or password";
    }
} else {
    echo "Invalid email or password";
}

// Close connection
mysqli_close($link);
?>
