<?php
  class Work {
    // database connection and table name
    private $conn;
    private $tableName = 'works';

    // constructor with $db as database connection
    public function __construct($db) {
      $this->conn = $db;
    }

    // read all works
    public function readAll() {
      $query = "SELECT * FROM $this->tableName";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    // read user works by user_id
    public function readUserWorks($user_id) {
      $query = "SELECT * FROM $this->tableName WHERE user_id = :user_id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt;
    }

    // read work by id
    public function readWork($id) {
      $query = "SELECT * FROM $this->tableName WHERE id = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt;
    }
    // insert work
    public function insertWork($dataArray) {
      try {
        $query = "INSERT INTO works VALUES (:id, :user_id, :description, :created, :modified)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $dataArray['id'], PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $dataArray['user_id'], PDO::PARAM_INT);
        $stmt->bindParam(':description', $dataArray['description'], PDO::PARAM_STR);
        $stmt->bindParam(':created', $dataArray['created']);
        $stmt->bindParam(':modified', $dataArray['modified']);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      } // end catch
    } // end insertWork

    // delete work by id
    public function deleteWorkById($id) {
      try {
        $query = "DELETE FROM $this->tableName WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessaage());
      }
    } // end delete work by id

    // delete work by user_id
    public function deleteWorkByUserId($user_id) {
      try {
        $query = "DELETE FROM $this->tableName WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end delete work by user id

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

    // update user_id
    public function updateUserId($id, $user_id) {
      try {
        $query = "UPDATE $this->tableName SET user_id = :user_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update user_id

    // update description
    public function updateDescription($id, $desc) {
      try {
        $query = "UPDATE $this->tableName SET description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':description', $desc, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update description

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
        $stmt->bindParam(':id', $id);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update modified
  }

?>
