<?php
session_start();

	include("connection.php");
	include("functions.php");
    $error = "";

	if($_SERVER['REQUEST_METHOD'] == "POST"){
	
		//something was posted
		$email =trim($_POST['email']);
		$password = trim($_POST['password']);

		if(!empty($email) && !empty($password) ){
		
        $stmt = $con->prepare("SELECT * FROM users WHERE email = ? LIMIT 1");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
			
        if ($result && $result->num_rows > 0) {
			

					$user_data =  $result->fetch_assoc();
					
                    if(password_verify($password, $user_data['password'])) {

					
						$_SESSION['id'] = $user_data['id'];
                        echo "<script>window.location.href = 'desidanglers.html';</script>";
						die;
					} else {
                        $error = "Wrong email or password!";                    }
                } else {
                    $error = "Wrong email or password!";                }
        
                $stmt->close();
            } else {
                $error=
                 "Please fill in all fields!";
            }
        }
        
        $con->close();
				
?>
<!DOCTYPE html>
<head>
    <title>Login - Jewelry </title>
    <link rel="stylesheet" href="style2.css">
    
</head>
<body>
    <div class="login-container">
        <h1>Login</h1>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form id="loginForm" action="" method="post" onsubmit="return validateForm()">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <button type="submit" onclick="return validateForm()">Login</button>
        </form>
        <p>Don't have an account? <a href="Signup.html">Sign up</a></p>
    </div><script>
        function validateForm() {
            var email = document.getElementById('email').value;
            var password = document.getElementById('password').value;

            if (email == "" || password == "") {
                alert("Please fill in all fields.");
                return false;
            }
          
            return true;
        }
    </script>
</body>
</html>
