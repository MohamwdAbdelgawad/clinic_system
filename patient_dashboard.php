<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

$user_id = $_SESSION['user_id'];

// جلب بيانات المريض
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome, <?php echo $user['name']; ?></h1>
    <p>Last Login: <span id="last_login"><?php echo $user['last_login']; ?></span></p>

    <div>
        <a href="patient_profile.php">View Profile</a>
        <a href="book_appointment.php">Book Appointment</a>
        <a href="patient_manage_appointments.php">Manage Appointment</a>
        <a href="medical_report.php">View Medical Reports</a>
    </div>
</body>
</html>
