<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

// جلب إحصائيات المستخدمين
$total_users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$total_patients = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'patient'")->fetch_assoc()['count'];
$total_doctors = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'doctor'")->fetch_assoc()['count'];
$total_nurses = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'nurse'")->fetch_assoc()['count'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Admin Dashboard</h2>
    <p>Welcome, Admin!</p>

    <div>
        <h3>Statistics:</h3>
        <ul>
            <li>Total Users: <?php echo $total_users; ?></li>
            <li>Total Patients: <?php echo $total_patients; ?></li>
            <li>Total Doctors: <?php echo $total_doctors; ?></li>
            <li>Total Nurses: <?php echo $total_nurses; ?></li>
        </ul>
    </div>

    <div>
        <h3>Management:</h3>
        <a href="manage_users.php">Manage Users</a>
        <a href="view_appointments.php">View Appointments</a>
        <a href="generate_reports.php">Generate Reports</a>
        <a href="admin_book_appointment.php">Book Appointment</a>
    </div>
</body>
</html>
