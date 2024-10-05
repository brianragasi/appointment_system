<?php
session_start();

// Reset session variables
$_SESSION["user"] = "";
$_SESSION["usertype"] = "";

date_default_timezone_set('Asia/Kolkata');
$date = date('Y-m-d');
$_SESSION["date"] = $date;

include("connection.php"); 

$error = '<label for="promter" class="form-label"></label>';

if ($_POST) {
    $email = $_POST['useremail'];
    $password = $_POST['userpassword'];

    // Check if admin user exists
    $stmt = $conn->prepare("SELECT * FROM admin WHERE aemail = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $admin = $result->fetch_assoc();
        if ($password === $admin['apassword']) { 
            $_SESSION['user'] = $email;
            $_SESSION['usertype'] = 'a';
            header('Location: admin/index.php'); 
            exit;
        } else {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
        } 
    } 
    // Check if customer user exists ONLY if admin is not found
    elseif ($result->num_rows == 0) { 
        $stmt = $conn->prepare("SELECT * FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            $customer = $result->fetch_assoc();
            if (password_verify($password, $customer['password'])) { 
                $_SESSION['user'] = $email;
                $_SESSION['usertype'] = 'c';
                header('Location: index.php'); 
                exit;
            } else {
                $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">Wrong credentials: Invalid email or password</label>';
            }
        } else {
            $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cannot find any account with this email.</label>';
        }
    } 
    else { 
        $error = '<label for="promter" class="form-label" style="color:rgb(255, 62, 62);text-align:center;">We cannot find any account with this email.</label>';
    }

    $stmt->close(); 
} else {
    $error = '<label for="promter" class="form-label"> </label>';
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
    <link rel="stylesheet" href="css/login.css">
    <title>Login</title>
</head>
<body>
    <center>
        <div class="container">
            <table border="0" style="margin: 0; padding: 0; width: 60%;">
                <tr>
                    <td>
                        <p class="header-text">Welcome Back!</p>
                    </td>
                </tr>
                <tr>
                    <td> 
                        <div class="form-body"> 
                            <form action="" method="POST">
                                <tr>
                                    <td>
                                        <p class="sub-text">Login with your details to continue</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td">
                                        <label for="useremail" class="form-label">Email: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td">
                                        <input type="email" name="useremail" class="input-text" placeholder="Email Address" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td">
                                        <label for="userpassword" class="form-label">Password: </label>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="label-td">
                                        <input type="password" name="userpassword" class="input-text" placeholder="Password" required>
                                    </td>
                                </tr>
                                <tr>
                                    <td><br>
                                        <?php echo $error ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="submit" value="Login" class="login-btn btn-primary btn">
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <br>
                                        <p class="sub-text" style="font-weight: 280;">Don't have an account? <a href="register.php" class="hover-link1 non-style-link">Register here</a></p> 
                                        <br><br>
                                    </td>
                                </tr>
                            </form>
                        </div> 
                    </td>
                </tr>
            </table>
        </div>
    </center>
</body>
</html>