<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'nurse') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

$user_id = $_SESSION['user_id'];

// جلب بيانات الممرضة
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$user = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nurse Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Welcome, Nurse <?php echo $user['name']; ?></h2>
    <p>Last Login: <?php echo $user['last_login']; ?></p>

    <div>
        <a href="update_lab_result.php">Add Lab Results</a>
        <a href="update_patient_record.php">create Patient Records</a>
        <a href="contact_doctor.php">Contact Doctor</a>
        <a href="send_alarm.php">Send Alarm to Doctor</a>
        <a href="nurse_profile.php"> profile</a>
    </div>
</body>
</html>
