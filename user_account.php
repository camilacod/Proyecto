<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

// Database connection
$link = mysqli_connect("localhost", "root", "");
if (!$link) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (!mysqli_select_db($link, "hotel_reservation")) {
    die("Error al seleccionar la base de datos: " . mysqli_error($link));
}

// Fetch user reservations
$sql = "SELECT r.id, h.name, r.check_in, r.check_out FROM reservations r JOIN rooms rm ON r.room_id = rm.id JOIN hotels h ON rm.hotel_id = h.id WHERE r.user_id = ?";
$stmt = mysqli_prepare($link, $sql);
mysqli_stmt_bind_param($stmt, "i", $_SESSION['user_id']);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

$reservations = [];
while ($row = mysqli_fetch_assoc($result)) {
    $reservations[] = $row;
}

// Close connection
mysqli_close($link);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Account</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?></h1>
    <h2>Your Reservations</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Hotel</th>
                <th>Check-in Date</th>
                <th>Check-out Date</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservations as $reservation) : ?>
                <tr>
                    <td><?php echo $reservation['id']; ?></td>
                    <td><?php echo $reservation['name']; ?></td>
                    <td><?php echo $reservation['check_in']; ?></td>
                    <td><?php echo $reservation['check_out']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
