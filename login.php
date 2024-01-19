    <?php

    require 'db.php';
    $db = new DB();
    $klant = new klant($db);
    



    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // prevent xss
        $email = htmlspecialchars($_POST['email']);  
        $wachtwoord = $_POST['password'];  

        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo("$email is a valid email address");
        } else {
            echo("$email is not a valid email address");
        }

        try {
            
            $userExist = $klant->login($email, $wachtwoord);

            if ($userExist) {
                header("Location: home.php?logged_in");
                exit(); 
            } else {
                echo "Incorrect username or password";
            }
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            exit();  
        }
    }

    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Systeem</title>
</head>
<body>
    <form action="login.php" method="POST">
        <div class="box">
            <div class="container">
                <div class="top-header">
                    <header>Login</header>
                </div>
                <div class="input-field">
                    <input type="text" class="input" name="email" placeholder="email" required>
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-field">
                    <input type="password" class="input" name="password" placeholder="Password" required>
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-field">
                    <input type="submit" class="submit" value="Login">
                </div>
                <div class="bottom">
                    <div class="left">
                        <input type="checkbox" id="check">
                        <label for="check"> Remember Me</label>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>
</html>
