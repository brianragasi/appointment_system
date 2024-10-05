<?php
include("connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];

    // Basic validation (you can add more validation checks here)
    if (empty($name) || empty($email) || empty($password)) {
        echo "Please fill in all required fields.";
        exit();
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email already exists. Please use a different email.";
        exit();
    }

    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new customer into the database
    $stmt = $conn->prepare("INSERT INTO customers (name, email, password, phone) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $phone);

    if ($stmt->execute()) {
        echo "Registration successful!";
        // Redirect to the login page
        header("Location: login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error; 
    }

    $stmt->close();
} 
?>