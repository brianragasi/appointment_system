<?php
session_start();

// Check if appointment ID is set
if (!isset($_GET['id'])) {
    header("Location: appointment.php");
    exit;
}

// Import database connection
include("connection.php");

// Fetch appointment details
$appointment_id = $_GET['id'];
$sql = "SELECT * FROM appointments WHERE appoid = ?"; // Ensure 'appoid' is the correct column name
$stmt = $conn->prepare($sql); // Change $database to $conn

if ($stmt) {
    $stmt->bind_param("i", $appointment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $appointment = $result->fetch_assoc();

    if (!$appointment) {
        echo "<p>Appointment not found. Please check the ID.</p>";
        exit;
    }

    // Extract appointment details
    $name = $appointment['name'];
    $contact = $appointment['contact'];
    $keyType = $appointment['keyType'];
    $appointment_date = $appointment['appointment_date'];
    $appointment_time = $appointment['appointment_time'];
    $location = $appointment['location'];
} else {
    echo "Error preparing statement: " . $conn->error; // Change $database to $conn
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
    <title>Booking Complete</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .receipt-container {
            max-width: 600px;
            margin: 0 auto;
            background: #fff;
            padding: 30px; /* Increased padding */
            border-radius: 10px; /* Slightly larger radius */
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 28px; /* Increased font size */
            margin-bottom: 30px; /* Increased margin */
        }

        .appointment-details {
            margin: 20px 0;
        }

        .details-title {
            font-weight: bold;
            margin-bottom: 15px; /* Increased margin */
            color: #555;
            font-size: 20px; /* Increased font size */
        }

        .details-content {
            padding: 15px; /* Increased padding */
            background: #f9f9f9;
            border-radius: 5px;
            margin-bottom: 30px; /* Increased margin */
            font-size: 18px; /* Increased font size */
        }

        .nav-button {
            display: block;
            width: 100%;
            padding: 15px;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            text-decoration: none;
            font-size: 20px; /* Increased font size */
            margin-top: 15px; /* Increased margin */
            transition: background-color 0.3s; /* Added transition */
        }

        .back-button {
            background-color: #5cb85c;
        }

        .back-button:hover {
            background-color: #4cae4c;
        }

        .cancel-button {
            background-color: #d9534f;
        }

        .cancel-button:hover {
            background-color: #c9302c;
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
    <div class="receipt-container">
        <h1>PLEASE TAKE A SCREENSHOT
        </h1>
        <div class="appointment-details">
            <div class="details-title">Appointment Succesful</div>
            <div class="details-content">
                <strong>Name:</strong> <?php echo htmlspecialchars($name); ?><br>
                <p></p>
                <strong>Contact:</strong> <?php echo htmlspecialchars($contact); ?><br>
                <p></p>
                <strong>Service Type:</strong> <?php echo htmlspecialchars($keyType); ?><br>
                <p></p>
                <strong>Date:</strong> <?php echo htmlspecialchars($appointment_date); ?><br>
                <p></p>
                <strong>Time:</strong> <?php echo htmlspecialchars($appointment_time); ?><br>
                <p></p>
                <strong>Location:</strong> <?php echo htmlspecialchars($location); ?>
                
            </div>
        </div>
        <a href="appointment.php" class="nav-button back-button">Back to Appointments</a>
        <a href="delete-appointment.php?id=<?php echo urlencode($appointment_id); ?>" class="nav-button cancel-button">Cancel Appointment</a>
        <a href="index.php" class="nav-button home-button">Home</a>
    </div>
</body>
</html>
