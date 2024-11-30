<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'doctor') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

$user_id = $_SESSION['user_id'];

// جلب قائمة الأطباء
$sql = "SELECT id, name FROM users WHERE role = 'patient'";
$patients = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $patient_id = $_POST['patient_id'];
    $appointment_date = $_POST['appointment_date'];

    // إدخال بيانات الحجز في قاعدة البيانات
    $sql = "INSERT INTO appointments (patient_id, doctor_id, appointment_date) 
            VALUES ($patient_id, $user_id, '$appointment_date')";

    if ($conn->query($sql) === TRUE) {
        echo "Appointment booked successfully!";
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
    <title>Book Appointment</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Book an Appointment</h2>
    <form action="" method="POST">
        <label for="doctor">Choose Doctor:</label>
        <select name="patient_id" id="patient" required>
            <?php while ($row = $patients->fetch_assoc()): ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['name']; ?>
                </option>
            <?php endwhile; ?>
        </select><br>

        <label for="appointment_date">Appointment Date:</label>
        <input type="datetime-local" name="appointment_date" required><br>

        <button type="submit">Book Appointment</button>
    </form>
</body>
</html>
