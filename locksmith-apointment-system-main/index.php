<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <link rel="stylesheet" href="css/index.css">
    <title>Locksmith</title>
    <style>
        table {
            animation: transitionIn-Y-bottom 0.5s;
        }
    </style>
</head>
<body>
    <div class="full-height">
        <center>
        <table border="0">
            <tr>
                <td width="90%">
                    <font class="edoc-logo">Arjay </font>
                    <font class="edoc-logo-sub">| Key Master Shop</font>
                </td>
                <td width="10%">
                    <?php
                    session_start(); 
                    if (isset($_SESSION["user"])) {
                        echo '<a href="logout.php" class="non-style-link"><p class="nav-item" style="padding-right: 0px;">LOGOUT</p></a>';
                    } else {
                        echo '<a href="login.php" class="non-style-link"><p class="nav-item" style="padding-right: 0px;">LOGIN</p></a>';
                        echo ' | '; // Add a separator 
                        echo '<a href="register.php" class="non-style-link"><p class="nav-item" style="padding-right: 0px;">REGISTER</p></a>'; // Add the register link
                    }
                    ?>
                </td>
            </tr>
            
            <tr>
                <td colspan="2">
                    <p class="heading-text">Avoid the Hassle & Get Help Fast.</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <p class="sub-text2">Locked out or need a key fixed?<br>No problem! Book your locksmith service with Arjay Key Master Shop online. <br>
                        We provide quick & reliable assistance, schedule your appointment now and get back to your day stress-free!</p>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <center>
                    <?php 
                        if (isset($_SESSION["user"]) && $_SESSION["usertype"] == 'c') { 
                            echo '<a href="appointment.php">
                                    <input type="button" value="Make Appointment" class="login-btn btn-primary btn" style="padding-left: 25px; padding-right: 25px; padding-top: 10px; padding-bottom: 10px;">
                                  </a>';
                        } else {
                            echo '<p class="sub-text2">Please <a href="login.php" class="hover-link1 non-style-link">Login</a> or <a href="register.php" class="hover-link1 non-style-link">Register</a> to book an appointment.</p>';
                        }
                    ?>
                    </center>
                </td>
            </tr>
        </table>
        <p class="sub-text2 footer-hashen">Arjay Key Master Shop</p>
        </center>
    </div>
</body>
</html>