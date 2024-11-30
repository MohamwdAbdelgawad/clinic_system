<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'doctor') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

$user_id = $_SESSION['user_id'];

// جلب بيانات الطبيب
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome, Dr. <?php echo $user['name']; ?></h1>
    <p>Last Login: <span id="last_login"><?php echo $user['last_login']; ?></span></p>

    <div>
        <a href="doctor_profile.php">View Profile</a>
        <a href="doctor_manage_appointments.php">Manage Appointments</a>
        <a href="view_alarms.php">show alarms</a>
    </div>
</body>
</html>
