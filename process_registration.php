<?php
$link = mysqli_connect("localhost", "root", "");
if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (!mysqli_select_db($link, "hotel_reservation")) {
    die("Error al seleccionar la base de datos: " . mysqli_error($link));
}

$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];

// Check if user with the given email already exists
$sql = "SELECT * FROM users WHERE email = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_fetch_assoc($result)) {
    echo "Error: User with this email already exists";
} else {
    // If user does not exist, create a new user
    $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($link, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $password);

    if (mysqli_stmt_execute($stmt)) {
        echo "success";
    } else {
        echo "Error: " . mysqli_error($link);
    }
}

mysqli_close($link);
?>

