<?php
  class Database {
    // specify the database credentials
    private $host = 'HOST';
    private $port = 'PORT';
    private $dbname = 'DBNAME';
    private $username = 'USERNAME';
    private $password = 'PASSWORD';
    public $conn;

    // get the database connection
    public function getConnection($key) {
      $this->conn = null;
      try {
        $this->conn = new PDO('mysql:host='.$this->host.';port='.$this->port.';dbname='.$this->dbname, $this->username, $this->password);
        $this->conn->exec('set names utf8');
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $query = "SELECT * FROM api_keys WHERE api_key = \"$key\"";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() != 1) {
          die("ERROR: KEY IS NOT VALID");
        }
        return $this->conn;
      } catch (PDOException $e) {
        echo 'Connection Error: '.$e->getMessage();
      }
    }
  }
?>
