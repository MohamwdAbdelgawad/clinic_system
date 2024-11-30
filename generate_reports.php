<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

// جلب الإحصائيات
$total_users = $conn->query("SELECT COUNT(*) AS count FROM users")->fetch_assoc()['count'];
$total_patients = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'patient'")->fetch_assoc()['count'];
$total_doctors = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'doctor'")->fetch_assoc()['count'];
$total_nurses = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'nurse'")->fetch_assoc()['count'];
$total_appointments = $conn->query("SELECT COUNT(*) AS count FROM appointments")->fetch_assoc()['count'];

// جلب أكثر الأطباء زيارةً
$top_doctors = $conn->query("
    SELECT doctors.name AS doctor_name, COUNT(appointments.id) AS visit_count
    FROM appointments
    JOIN users AS doctors ON appointments.doctor_id = doctors.id
    GROUP BY doctors.name
    ORDER BY visit_count DESC
    LIMIT 5
");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Reports</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Reports</h2>
    <div>
        <h3>Summary:</h3>
        <ul>
            <li>Total Users: <?php echo $total_users; ?></li>
            <li>Total Patients: <?php echo $total_patients; ?></li>
            <li>Total Doctors: <?php echo $total_doctors; ?></li>
            <li>Total Nurses: <?php echo $total_nurses; ?></li>
            <li>Total Appointments: <?php echo $total_appointments; ?></li>
        </ul>
    </div>

    <div>
        <h3>Top 5 Doctors by Visits:</h3>
        <table>
            <tr>
                <th>Doctor Name</th>
                <th>Visit Count</th>
            </tr>
            <?php while ($row = $top_doctors->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['doctor_name']; ?></td>
                    <td><?php echo $row['visit_count']; ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    </div>
</body>
</html>
