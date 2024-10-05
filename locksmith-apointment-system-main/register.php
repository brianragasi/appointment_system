<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css"> 
    <title>Customer Registration - Arjay Key Master Shop</title>
    
</head>
<body>
    <header>
        <h1>Customer Registration</h1>
        <nav>
            <a href="index.php">Home</a> 
            <a href="login.php">Login</a> 
        </nav>
    </header>

    <section id="registration-form">
        <h2 class="form-title">Register</h2>
        <form action="register_process.php" method="post">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required><br><br>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required><br><br>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br>

            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone"><br><br>

            <input type="submit" value="Register" class="submit-button">
        </form>
    </section>
</body>
</html>