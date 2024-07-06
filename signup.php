
<?php
session_start();

include("connection.php");
include("functions.php");


if($_SERVER['REQUEST_METHOD'] == "POST")
{
    //collect data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if(!empty($name) && !empty($email) && !empty($password))
    {
        // Hash the password before storing
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        // Use prepared statement to prevent SQL Injection
        $stmt = $con->prepare("INSERT INTO users (name,email,password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $passwordHash);

        if ($stmt->execute()) {
            // Redirect to login page
            header("Location: login.php");
            die;
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();  
    } else {
        echo "Please enter some valid information!";
    }
     
}

?>
<!DOCTYPE html>
<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="style3.css">
</head>
<body>
    <div class="container">
        <div class="sign-up-form">
            <h1>Sign Up</h1>
            <form action="" method="post">
                <div class="input-group">
                    <label for="name">Username</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn">Sign Up</button>
            </form>
            <p class="sign-in-link">Already have an account? <a href="login.php">Sign In</a></p>
        </div>
    </div>
</body>
</html>
