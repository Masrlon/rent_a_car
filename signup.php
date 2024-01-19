
<?php
require 'db.php';
$db = new DB();

$klant = new klant($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    try {
        $result = $klant->signup($email, $wachtwoord);
        header("location: login.php?process=$result");
    } catch (\Exception $e) {
        echo "Niet gelukt" . $e->getMessage();
        die();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="login.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup Page</title>
</head>
<body>
    <form action="signup.php" method="POST"> 
        <div class="box">
            <div class="container">
                <div class="top-header">
                    <header>Signup</header>
                </div>
                <div class="input-field">
                    <input type="text" class="input" name="email" placeholder="email" required> 
                    <i class="bx bx-user"></i>
                </div>
                <div class="input-field">
                    <input type="password" class="input" name="wachtwoord" placeholder="Password" required> 
                    <i class="bx bx-lock-alt"></i>
                </div>
                <div class="input-field">
                    <input type="submit" class="submit" value="Signup">
                </div>
                <div class="bottom">
                    <div class="left">
                        <input type="checkbox"  id="check">
                        <label for="check"> Remember Me</label>
                    </div>
                </div>
            </div>
        </div>
    </form> 
</body>
</html>
