<?php
require 'db.php';

$db = new DB(); 


$stmt = $db->run("SELECT naam, wachtwoord FROM medewerker");
$medewerkers = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($medewerkers as $medewerker) {
   
    $hashedPassword = password_hash($medewerker['wachtwoord'], PASSWORD_DEFAULT);

    
    $db->run("UPDATE medewerker SET wachtwoord = ? WHERE naam = ?", [$hashedPassword, $medewerker['naam']]);
}

echo "Wachtwoorden zijn gehasht.";
?>
