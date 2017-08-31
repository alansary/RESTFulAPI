<?php
  class User {
    // database connection and table name
    private $conn;
    private $tableName = 'users';

    // constructor with $db as database connection
    public function __construct($db) {
      $this->conn = $db;
    }

    // read all users
    public function readAll() {
      $query = "SELECT * FROM $this->tableName ORDER BY id DESC";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    // read user by id
    public function readUserById($id) {
      $query = "SELECT * FROM $this->tableName WHERE id = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt;
    }

    // read user by username
    public function readUserByUsername($username) {
      $query = "SELECT * FROM $this->tableName WHERE username = :username";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':username', $username, PDO::PARAM_STR);
      $stmt->execute();
      return $stmt;
    }

    // insert user
    public function insertUser($dataArray) {
      try {
        $query = "INSERT INTO $this->tableName VALUES (:id, :username, :password, :created, :modified)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $dataArray['id'], PDO::PARAM_INT);
        $stmt->bindParam(':username', $dataArray['username'], PDO::PARAM_STR);
        $stmt->bindParam(':password', $dataArray['password'], PDO::PARAM_STR);
        $stmt->bindParam(':created', $dataArray['created']);
        $stmt->bindParam(':modified', $dataArray['modified']);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      } // end catch
    } // end insertUser

    // delete user by id
    public function deleteUserById($id) {
      try {
        $query = "DELETE FROM $this->tableName WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end delete by id

    // delete by username
    public function deleteUserByUsername($username) {
      try {
        $query = "DELETE FROM $this->tableName WHERE username = :username";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end delete by username

    // update username
    public function updateUsername($id, $username) {
      try {
        $query = "UPDATE $this->tableName SET username = :username WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update username

    // update password
    public function updatePassword($id, $password) {
      try {
        $query = "UPDATE $this->tableName SET password = :password WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update password

    // update created
    public function updateCreated($id, $created) {
      try {
        $query = "UPDATE $this->tableName SET created = :created WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':created', $created);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update created

    // update modified
    public function updateModified($id, $modified) {
      try {
        $query = "UPDATE $this->tableName SET modified = :modified WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':modified', $modified);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update modified

    // update id
    public function updateId($id, $new_id) {
      try {
        $query = "UPDATE $this->tableName SET id = :new_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':new_id', $new_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update id
  }
?>
