<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>Dashboard</title>
    <style>
        .dashbord-tables {
            animation: transitionIn-Y-over 0.5s;
        }
        .filter-container {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .sub-table {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .btn-primary-soft {
            background-color: #f0f0f0; /* Update the background color as needed */
            border: 1px solid #ccc; /* Add border if necessary */
        }
        .btn-primary {
            background-color: #007bff; /* Primary button color */
            color: white; /* Button text color */
        }
        .non-style-link {
            text-decoration: none; /* Remove underline */
            color: inherit; /* Inherit color */
        }
    </style>
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION["user"]) || empty($_SESSION["user"]) || $_SESSION['usertype'] != 'a') {
        header("location: ../login.php");
        exit();
    }

    // Import database connection
    include("../connection.php");

    // Get today's date
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d');

    // Query for upcoming appointments
    $appointmentQuery = "SELECT * FROM appointments WHERE appointment_date >= '$today';";
    $appointmentResult = $conn->query($appointmentQuery);
    ?>
    
    <div class="container">
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td colspan="2" style="padding:10px">
                        <table class="profile-container" border="0">
                            <tr>
                                <td width="30%" style="padding-left:20px">
                                    <img src="../img/user.png" alt="Profile Picture" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0;margin:0;">
                                    <p class="profile-title">Administrator</p>
                                    <p class="profile-subtitle">admin@edoc.com</p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="Log out" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment menu-active">
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active">
                            <div><p class="menu-text">Appointment</p></div>
                        </a>
                    </td>
                </tr>
            </table>
        </div>

        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;">
                <tr>
                    <td colspan="2" class="nav-bar">
                        <p style="font-size: 14px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: right;">
                            Today's Date: <?php echo $today; ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display: flex;justify-content: center;align-items: center;">
                            <img src="../img/calendar.svg" width="100%">
                        </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                            <table class="filter-container" style="border: none;" border="0">
                                <tr>
                                    <td colspan="4">
                                        <p style="font-size: 20px;font-weight:600;padding-left: 12px;">Status</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="width: 25%;">
                                        <div class="dashboard-items" style="padding:20px;margin:auto;width:95%;display: flex">
                                            <div>
                                                <div class="h1-dashboard">
                                                    <?php echo $appointmentResult->num_rows; ?>
                                                </div><br>
                                                <div class="h3-dashboard">
                                                    New Appointments
                                                </div>
                                            </div>
                                            <div class="btn-icon-back dashboard-icons" style="background-image: url('../img/icons/book-hover.svg');"></div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table width="100%" border="0" class="dashbord-tables">
                            <tr>
                                <td>
                                    <p style="padding:10px;padding-left:48px;padding-bottom:0;font-size:23px;font-weight:700;color:var(--primarycolor);">
                                        Upcoming Appointments
                                    </p>
                                    <p style="padding-bottom:19px;padding-left:50px;font-size:15px;font-weight:500;color:#212529e3;line-height: 20px;">
                                        Here's Quick access to Upcoming Appointments
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="100%">
                                    <center>
                                        <div class="abc scroll" style="height: 200px;">
                                            <table width="85%" class="sub-table scrolldown" border="0">
                                                <thead>
                                                    <tr>    
                                                        <th class="table-headin" style="font-size: 12px;">Appointment ID</th>
                                                        <th class="table-headin">Customer's Name</th>
                                                        <th class="table-headin">Appointment Date</th>
                                                        <th class="table-headin">Appointment Time</th> <!-- New column for Appointment Time -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    // Query for upcoming appointments within the next week
                                                    $nextWeek = date("Y-m-d", strtotime("+1 week"));
                                                    $sqlmain = "SELECT appoid, name, appointment_date, appointment_time FROM appointments ORDER BY appointment_date ASC";

                                                    $result = $conn->query($sqlmain);

                                                    if ($result->num_rows == 0) {
                                                        echo '<tr>
                                                                <td colspan="4"> <!-- Updated colspan to 4 -->
                                                                    <br><br><br><br>
                                                                    <center>
                                                                        <p class="heading-main12" style="margin-left: 45px;font-size:20px;color:rgb(49, 49, 49)">No upcoming appointments found!</p>
                                                                    </center>
                                                                    <br><br><br><br>
                                                                </td>
                                                            </tr>';
                                                    } else {
                                                        while ($row = $result->fetch_assoc()) {
                                                            $apponum = $row["appoid"];
                                                            $pname = $row["name"];
                                                            $appointment_date = $row["appointment_date"];
                                                            $appointment_time = $row["appointment_time"]; // Fetch appointment time
                                                            
                                                            echo '<tr>
                                                                    <td style="text-align:center;font-size:23px;font-weight:500;color: var(--btnnicetext);padding:20px;">'.$apponum.'</td>
                                                                    <td style="font-weight:600;">&nbsp;'.substr($pname, 0, 25).'</td>
                                                                    <td style="font-weight:600;">'.$appointment_date.'</td>
                                                                    <td style="font-weight:600;">'.$appointment_time.'</td> <!-- Display appointment time -->
                                                                </tr>';
                                                        }
                                                    }                                                    
                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>
