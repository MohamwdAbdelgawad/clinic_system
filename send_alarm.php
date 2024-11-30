<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'nurse') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');
$user_id = $_SESSION['user_id'];
// جلب قائمة الأطباء
$sql = "SELECT id, name FROM users WHERE role = 'doctor'";
$doctors = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $doctor_id = $_POST['doctor_id'];
    $message = $_POST['message'];

    // إدخال التنبيه
    $sql = "INSERT INTO alarms (doctor_id, message, sent_at , sender_id) 
            VALUES ($doctor_id, '$message', NOW() ,$user_id )";

    if ($conn->query($sql) === TRUE) {
        echo "Alarm sent successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Alarm</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Send Alarm to Doctor</h2>
    <form action="" method="POST">
        <label for="doctor">Choose Doctor:</label>
        <select name="doctor_id" id="doctor" required>
            <?php while ($row = $doctors->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="message">Message:</label>
        <textarea name="message" id="message" required></textarea><br>

        <button type="submit">Send Alarm</button>
    </form>
</body>
</html>
