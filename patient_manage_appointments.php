<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'patient') {
    header("Location: login.php");
    exit();
}

include('db_connect.php');

$user_id = $_SESSION['user_id'];

// جلب المواعيد
$sql = "SELECT appointments.id, users.name AS doctor_name, appointments.appointment_date 
        FROM appointments 
        JOIN users ON appointments.doctor_id = users.id 
        WHERE appointments.patient_id = $user_id";
$appointments = $conn->query($sql);

// إلغاء الموعد
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['cancel_id'])) {
    $cancel_id = $_POST['cancel_id'];
    $sql = "DELETE FROM appointments WHERE id = $cancel_id";
    if ($conn->query($sql) === TRUE) {
        echo "Appointment canceled successfully!";
        header("Refresh: 0");
    } else {
        echo "Error: " . $conn->error;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $date = $_POST['appointment_date'];
    $sql = "UPDATE  appointments set appointment_date = '$date' WHERE id = $edit_id";
    if ($conn->query($sql) === TRUE) {
        echo "Appointment canceled successfully!";
        header("Refresh: 0");
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
    <title>Manage Appointments</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <h2>Your Appointments</h2>
    <table>
        <tr>
            <th>Doctor</th>
            <th>Appointment Date</th>
            <th>Action</th>
        </tr>
        <?php while ($row = $appointments->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['doctor_name']; ?></td>
                <td><?php echo $row['appointment_date']; ?></td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="cancel_id" value="<?php echo $row['id']; ?>">
                        <button type="submit">Cancel</button>
                    </form>
                </td>
                <td>
                    <form action="" method="POST">
                        <input type="hidden" name="edit_id" value="<?php echo $row['id']; ?>">
                        <button onclick="showPopup()">edit</button>
                        <div id="popup">
                            <label for="appointment_date">Appointment Date:</label>
                            <input type="datetime-local" name="appointment_date" required><br>
                              <button type="submit" onclick="hidePopup()">Save</button>
                        </div>
                        <script> 
                        function showPopup() { document.getElementById("popup").style.display = "block"; }
                        function hidePopup() { document.getElementById("popup").style.display = "none"; }
                         </script>
                    </form>
            </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
