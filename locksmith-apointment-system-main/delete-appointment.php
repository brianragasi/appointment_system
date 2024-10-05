<?php
// Import database
include("connection.php"); // Ensure this path is correct

if ($_GET) {
    $id = $_GET["id"];

    // Delete the appointment from the database
    $sql = "DELETE FROM appointments WHERE appoid = ?"; // Ensure 'appoid' is the correct column name
    $stmt = $conn->prepare($sql); // Use $conn if that's how you've defined it in connection.php
    $stmt->bind_param("i", $id);
    $stmt->execute();

    // Check if the appointment was successfully deleted
    if ($stmt->affected_rows > 0) {
        $deleted = true;
    } else {
        $deleted = false; // Handle case where deletion fails
    }

    $stmt->close(); // Close the statement after executing
} else {
    header("location: appointment.php"); // Redirect if no ID is provided
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/admin.css">
    <title>Appointment Deletion</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .confirmation-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px; /* Increased padding */
            border-radius: 10px; /* Slightly larger radius */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center; /* Center text */
        }

        h1 {
            color: #333;
            font-size: 28px; /* Increased font size */
            margin-bottom: 20px;
        }

        p {
            font-size: 20px; /* Increased font size */
            margin-bottom: 30px;
        }

        .nav-button {
            display: inline-block;
            padding: 15px 25px;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 20px; /* Increased font size */
            margin: 10px; /* Added margin for spacing */
            transition: background-color 0.3s; /* Added transition */
        }

        .back-button {
            background-color: #5cb85c;
        }

        .back-button:hover {
            background-color: #4cae4c;
        }

        .home-button {
            background-color: #007bff;
        }

        .home-button:hover {
            background-color: #0069d9;
        }
    </style>
</head>
<body>
    <div class="confirmation-container">
        <?php if (isset($deleted) && $deleted): ?>
            <h1>Appointment Deleted Successfully</h1>
            <p>Your appointment has been successfully deleted.</p>
        <?php else: ?>
            <h1>Error Deleting Appointment</h1>
            <p>There was an issue deleting your appointment. Please try again.</p>
        <?php endif; ?>
        
        <a href="appointment.php" class="nav-button back-button">Go Back to Appointments</a>
        <a href="appointment.php" class="nav-button home-button">Book Another Appointment</a>
    </div>
</body>
</html>
