<?php 
class Db{
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbName = "firefly";
    private $charset = 'utf8mb4';

    public function connection(){
        try {
            $dsn = 'mysql:host=' .$this->host.';dbname='. $this->dbName.';charset='.$this->charset;
            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];
            $pdo = new PDO($dsn, $this->user, $this->pass,$options);
            // $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_ASSOC);
            return $pdo;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }

    
}

?>