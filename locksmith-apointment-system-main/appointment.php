<?php
session_start(); // Start the session here
include("connection.php");

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collecting form data
    $name = $_POST['name'];
    $contact = $_POST['contact'];
    $key_type = $_POST['key_type'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];

    // Prepare the SQL statement (ensure the column name matches the DB)
    $stmt = $conn->prepare("INSERT INTO appointments (name, contact, keyType, appointment_date, appointment_time, location) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $name, $contact, $key_type, $date, $time, $location);

    // Execute the statement and check for success
    if ($stmt->execute()) {
        // Store appointment details
        $_SESSION['appointment_details'] = [
            'name' => $name,
            'contact' => $contact,
            'key_type' => $key_type,
            'date' => $date,
            'time' => $time,
            'location' => $location,
            'appointment_id' => $stmt->insert_id // Correct variable name
        ];

        // Redirect to booking-complete.php
        header("Location: booking-complete.php?id=" . urlencode($stmt->insert_id)); // Ensure correct variable used
        exit();
    } else {
        echo "Error: " . $stmt->error; // Display error message if insert fails
    }
    // Close the statement
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Book Appointment - Arjay Key Master Shop</title>
    <style>
        /* Reset margin and padding */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #e0f7fa; /* Light cold blue */
            margin: 0;
            padding: 20px;
        }

        header {
            background-color: #006b5f; /* Colder dark teal */
            color: white;
            text-align: center;
            padding: 20px 0;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
            font-size: 36px;
        }

        nav {
            margin-top: 10px;
        }

        nav a {
            background-color: white; /* White background */
            color: black; /* Black text */
            text-decoration: none;
            padding: 10px 15px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        nav a:hover {
            background-color: #b2dfdb; /* Slightly lighter cold teal */
        }

        #appointment-form {
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
        }

        .form-title {
            background-color: #006b5f; /* Colder dark teal */
            color: white;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 10px 0 5px;
            font-size: 18px;
        }

        input, select {
            width: calc(100% - 20px);
            padding: 10px;
            font-size: 16px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .submit-button {
            background-color: #006b5f; /* Colder dark teal */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .submit-button:hover {
            background-color: #004d40; /* Even darker teal */
        }

        /* Time Slot Buttons */
        #time-slots {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; /* Spread out the buttons */
            margin-bottom: 15px;
        }

        #time-slots button {
            flex: 1 1 calc(33.333% - 10px); /* Responsive buttons, 3 per row */
            padding: 10px;
            margin: 5px;
            font-size: 16px;
            cursor: pointer;
            background-color: #006b5f;
            color: white;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        #time-slots button:hover,
        #time-slots button.selected {
            background-color: #004d40;
        }

        /* Custom styling for datepicker highlighting */
        .flatpickr-day.selected {
            background-color: #006b5f !important;
            color: white;
        }
    </style>
</head>
<body>
    <header>
        <h1>Book an Appointment</h1>
        <nav>
            <a href="index.php">Home</a>
        </nav>
    </header>

    <section id="appointment-form">
        <h2 class="form-title">Book an Appointment</h2>
        <form action="" method="post">
            <label for="key_type">Service Type:</label>
            <select name="key_type" id="service_type" required>
                <option value="">Select Service</option>
                <option value="Repair">Repair</option>
                <option value="Duplication">Duplication</option>
                <option value="Fabrication">Fabrication</option>
            </select>

            <label for="name">Name:</label>
            <input type="text" name="name" required>

            <label for="contact">Phone:</label>
            <input type="text" name="contact" required>

            <label for="date">Appointment Date:</label>
            <input type="text" id="appointment-date" name="date" required>

            <label for="time">Appointment Time:</label>
            <div id="time-slots">
                <button type="button" data-time="09:00">9:00 AM</button>
                <button type="button" data-time="10:00">10:00 AM</button>
                <button type="button" data-time="11:00">11:00 AM</button>
                <button type="button" data-time="13:00">1:00 PM</button>
                <button type="button" data-time="14:00">2:00 PM</button>
                <button type="button" data-time="15:00">3:00 PM</button>
                <button type="button" data-time="16:00">4:00 PM</button>
            </div>
            <input type="hidden" name="time" id="selected-time" required>

            <label for="location">Location:</label>
            <input type="text" name="location" required>

            <div class="button-container">
                <input type="submit" name="submit" value="Book" class="submit-button">
            </div>
        </form>
    </section>

    <script>
        // Initialize Flatpickr on the date input
        flatpickr("#appointment-date", {
            altInput: true,
            altFormat: "F j, Y",
            dateFormat: "Y-m-d",
            minDate: "today",  // disable past dates
        });

        // Time slot button selection logic
        const timeButtons = document.querySelectorAll('#time-slots button');
        const selectedTimeInput = document.getElementById('selected-time');

        timeButtons.forEach(button => {
            button.addEventListener('click', () => {
                // Remove 'selected' class from all buttons
                timeButtons.forEach(btn => btn.classList.remove('selected'));
                // Add 'selected' class to the clicked button
                button.classList.add('selected');
                // Set the hidden input's value to the selected time
                selectedTimeInput.value = button.getAttribute('data-time');
            });
        });
    </script>
</body>
</html>
