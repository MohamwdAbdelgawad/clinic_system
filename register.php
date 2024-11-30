<?php include('db_connect.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Register New Account</h2>
    <form action="register_process.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" required><br>

        <label for="age">Age:</label>
        <input type="number" name="age" id="age" required><br>

        <label for="mobile">Mobile Number:</label>
        <input type="text" name="mobile" id="mobile" required><br>

        <label for="role">Role:</label>
        <select name="role" id="role" required>
            <option value="doctor">Doctor</option>
            <option value="patient">Patient</option>
            <option value="nurse">Nurse</option>
            <option value="admin">Admin</option>
        </select><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
