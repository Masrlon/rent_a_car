<?php

class DB 
{
    public $dbh; 

    public function __construct($db="rent_a_car", $host="127.0.0.1:3307", $user="root", $pass="")
    {
        try {
            $this->dbh = new PDO("mysql:host=$host;dbname=$db;", $user, $pass);
            $this->dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection error: " . $e->getMessage());
        }
    }   
    public function hash($wachtwoord): string
    {
        return password_hash($wachtwoord, PASSWORD_DEFAULT);
    }
    public function run($query, $args = null): PDOStatement | false 
    {
        $stmt = $this->dbh->prepare($query);
        $stmt->execute($args);
        return $stmt;
    }

    public function lastId(): int
    {
        return $this->dbh->lastInsertId();
    }
}

class klant
{
    private $dbh;
    private $table = 'klant';

    public function __construct(DB $dbh)
    {
        $this->dbh = $dbh->dbh;
        session_start();
    }

    public function signup($email, $wachtwoord): bool
    {
        
        if (empty($email) || empty($wachtwoord)) {
            throw new InvalidArgumentException("Email and password are required.");
        }

        $hash = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $stmt = $this->dbh->prepare("INSERT INTO $this->table (email, wachtwoord) VALUES (?, ?)");

        try {
            $stmt->execute([$email, $hash]);
            return true;  
        } catch (PDOException $e) {
            
            throw new RuntimeException("Error adding user: " . $e->getMessage());
        }
    }
    public function login($email, $wachtwoord): bool
    {
        if (empty($email) || empty($wachtwoord)) {
            throw new InvalidArgumentException("Email and password are required.");
        }

        $stmt = $this->dbh->prepare("SELECT * FROM $this->table WHERE email = ?");
        $stmt->execute([$email]);
        $klant = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($klant && password_verify($wachtwoord, $klant['wachtwoord'])) {
            $_SESSION['klant_id'] = $klant['id'];
            $_SESSION['email'] = $klant['email'];
            $this->regenerateSession(); 

            return true;
        }

        return false;
    }
    private function regenerateSession(){
      session_regenerate_id(true);
    }
}

class medewerker {
  private $dbh;
  private $table = 'medewerker';
  public function __construct(DB $dbh)
    {
        $this->dbh = $dbh->dbh;
        session_start();
    }
    public function login($email, $wachtwoord): bool
    {
      
        if (empty($email) || empty($wachtwoord)) {
            throw new InvalidArgumentException("Email and password are required.");
        }

        
        $stmt = $this->dbh->prepare("SELECT * FROM $this->table WHERE email = ?");
        $stmt->execute([$email]);
        $medewerker = $stmt->fetch(PDO::FETCH_ASSOC);

        
        if ($medewerker && password_verify($wachtwoord, $medewerker['wachtwoord'])) {
            
            
                $_SESSION['medewerker_id'] = $medewerker['id'];
                $_SESSION['medewerker_email'] = $medewerker['email'];
                $this->regenerateSession(); 

                return true;
            }
        

        return false;
    }

    

    private function regenerateSession(): void
    {
        session_regenerate_id(true);
    }
}

?>
