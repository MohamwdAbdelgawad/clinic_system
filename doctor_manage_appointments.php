<?php
session_start();
include('db_connect.php');

if ($_SESSION['role'] !== 'doctor') {
    header("Location: login.php");
    exit();
}

$doctor_id = $_SESSION['user_id'];

// Fetch appointments
$sql="SELECT 
    a.id,
    p.name AS patient_name,
    a.appointment_date
FROM 
    appointments a
JOIN 
    users p
ON 
    a.patient_id = p.id
WHERE 
    a.doctor_id = ?;
";
//$sql = "SELECT * FROM appointments WHERE doctor_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$result = $stmt->get_result();

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
    <style>
        /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
    line-height: 1.6;
}

h1 {
    text-align: center;
    margin-top: 20px;
    color: #5d5d8f;
}

/* Table Styles */
table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    background-color: #fff;
    border: 1px solid #ddd;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

th, td {
    padding: 12px 15px;
    text-align: center;
    border-bottom: 1px solid #ddd;
}

th {
    background-color: #5d5d8f;
    color: #fff;
    font-weight: bold;
}

tr:hover {
    background-color: #f1f1f1;
}

td form {
    margin: 0;
}

/* Buttons */
button {
    background-color: #5d5d8f;
    color: white;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    border-radius: 5px;
    font-size: 14px;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #45457b;
}

a {
    text-decoration: none;
    color: #5d5d8f;
    font-weight: bold;
}

a:hover {
    text-decoration: underline;
}

/* Popup Styling */
#popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: #fff;
    border: 2px solid #5d5d8f;
    padding: 20px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    z-index: 1000;
    border-radius: 10px;
    width: 300px;
    text-align: center;
}

#popup label {
    font-weight: bold;
    margin-bottom: 10px;
    display: block;
}

#popup input {
    width: 100%;
    padding: 8px;
    margin: 10px 0;
    border: 1px solid #ddd;
    border-radius: 5px;
}

#popup button {
    width: 100%;
}

/* Overlay (to dim background during popup) */
#popupOverlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 999;
}

    </style>
</head>
<body>
    <h1>Manage Appointments</h1>
    <a href="doctor_book_appointment.php">Book Appointment</a>
    <table>
        <tr>
            <th>Patient Name</th>
            <th>Date Time</th>
            <th colspan="2">Actions</th>
        </tr>
        <?php while ($appointment = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($appointment['patient_name']); ?></td>
            <td><?php echo htmlspecialchars($appointment['appointment_date']); ?></td>
            <td>
                    <form action="" method="POST">
                        <input type="hidden" name="cancel_id" value="<?php echo $appointment['id']; ?>">
                        <button type="submit">Cancel</button>
                    </form>

                    
            </td>
            <td>
                    <form action="" method="POST">
                        <input type="hidden" name="edit_id" value="<?php echo $appointment['id']; ?>">
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
