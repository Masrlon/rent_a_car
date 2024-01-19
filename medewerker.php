

<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_klant'])) {
    $naam = $_POST['naam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $telefoonnummer = $_POST['telefoonnummer'];

    try {
        $db = new DB();

    
        $emailExists = $db->run("SELECT COUNT(*) FROM klant WHERE email = ?", [$email])->fetchColumn();

        if ($emailExists) {
            echo 'Error: Dit e-mailadres is al geregistreerd.';
            exit();
        }

    
        $hashedPassword = password_hash($wachtwoord, PASSWORD_DEFAULT);

    
        $query = "INSERT INTO klant (naam, email, wachtwoord, telefoonnummer) VALUES (?, ?, ?, ?)";
        $db->run($query, [$naam, $email, $hashedPassword, $telefoonnummer]);

        header("Location: home.php?success_klant");
        exit();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_auto'])) {
    $merk = $_POST['merk'];
    $jaar = $_POST['jaar'];

    $photoName = $_FILES['auto_foto']['name'];
    $photoTmp = $_FILES['auto_foto']['tmp_name'];
    $photoPath = "uploads/" . $photoName;

    move_uploaded_file($photoTmp, $photoPath);

    try {
        $db = new DB();

        // Voeg auto toe
        $query = "INSERT INTO autos (merk, jaar, image) VALUES (?, ?, ?)";
        $db->run($query, [$merk, $jaar, $photoPath]);

        header("Location: home.php?success_auto");
        exit();
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="medewerker.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Customer and Car</title>
</head>
<body>
    <?php if(isset($_GET['success_klant'])): ?>
        <p>Klant succesvol toegevoegd!</p>
    <?php endif; ?>
    
    <div>
        <form method="POST" enctype="multipart/form-data">
            <h3>Voeg een klant</h3>
            Klant Naam: <input type="text" name="naam" required><br>
            Klant Email: <input type="text" name="email" required><br>
            Klant wachtwoord: <input type="password" name="wachtwoord" required><br>
            Klant telefoonnummer: <input type="text" name="telefoonnummer" required><br>
            <input type="submit" name="submit_klant" value="Voeg klant toe">
        </form>
    </div>

    <?php if(isset($_GET['success_auto'])): ?>
        <p>Auto succesvol toegevoegd!</p>
    <?php endif; ?>
    
    <div>
        <form method="POST" enctype="multipart/form-data">
            <h3>Voeg een auto</h3>
            Auto Merk: <input type="text" name="merk" required><br>
            Auto Bouwjaar: <input type="text" name="jaar" required><br>
            Auto Foto: <input type="file" name="auto_foto" accept="image/*" required><br>
            <input type="submit" name="submit_auto" value="Voeg auto toe">
        </form>
    </div>
</body>
</html>
