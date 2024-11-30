<?php
session_start();
include('db_connect.php');

if ($_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['user_id'];

// Fetch alarms
$sql = "SELECT alarms.*, users.name AS sender_name
        FROM alarms
        JOIN users ON alarms.sender_id = users.id
        WHERE alarms.doctor_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Alarms</title>
</head>
<body>
    <h1>Alarms</h1>
    <ul>
        <?php while ($alarm = $result->fetch_assoc()): ?>
        <li>
            <p><?php echo htmlspecialchars($alarm['message']); ?></p>
            <p>at: <?php echo htmlspecialchars($alarm['sent_at']); ?></p>
            <p>from: <?php echo htmlspecialchars($alarm['sender_name']); ?></p>
        </li>
        <?php endwhile; ?>
    </ul>
</body>
</html>

