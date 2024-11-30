<?php
include('db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $age = $_POST['age'];
    $mobile = $_POST['mobile'];
    $role = $_POST['role'];

    if ($password !== $confirm_password) {
        die("Passwords do not match!");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (name, email, password, age, mobile_number, role) 
            VALUES ('$name', '$email', '$hashed_password', $age, '$mobile', '$role')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
