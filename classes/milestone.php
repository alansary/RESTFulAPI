<?php
  class MileStone {
    // database connection and table name
    private $conn;
    private $tableName = 'milestones';

    // constructor with $db as database connection
    public function __construct($db) {
      $this->conn = $db;
    }

    // read all milestones
    public function readAll() {
      $query = "SELECT * FROM $this->tableName";
      $stmt = $this->conn->prepare($query);
      $stmt->execute();
      return $stmt;
    }

    // read work milestone by id
    public function readMilestoneById($id) {
      $query = "SELECT * FROM $this->tableName WHERE id = :id";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':id', $id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt;
    }

    // read work milestones by work_id
    public function readWorkMilestones($work_id) {
      $query = "SELECT * FROM $this->tableName WHERE work_id = :work_id ORDER BY :work_id DESC";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':work_id', $work_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt;
    }

    // read user milestones by user_id
    public function readUserMilestones($user_id) {
      $query = "SELECT $this->tableName.id AS id, $this->tableName.work_id AS work_id, $this->tableName.deliverables AS deliverables, $this->tableName.payment AS payment, $this->tableName.deadline AS deadline, $this->tableName.image AS image, $this->tableName.created AS created, $this->tableName.modified AS modified FROM $this->tableName INNER JOIN works ON $this->tableName.work_id = works.id WHERE works.user_id = :user_id ORDER BY id DESC";
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
      $stmt->execute();
      return $stmt;
    }

    // insert milestone
    public function insertMilestone($dataArray) {
      try {
        $query = "INSERT INTO milestones VALUES (:id, :work_id, :deliverables, :payment, :deadline, :image, :created, :modified)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $dataArray['id'], PDO::PARAM_INT);
        $stmt->bindParam(':work_id', $dataArray['work_id'], PDO::PARAM_INT);
        $stmt->bindParam(':deliverables', $dataArray['deliverables'], PDO::PARAM_STR);
        $stmt->bindParam(':payment', $dataArray['payment']);
        $stmt->bindParam(':deadline', $dataArray['deadline']);
        $stmt->bindParam(':image', base64_decode($dataArray['image']), PDO::PARAM_LOB);
        $stmt->bindParam(':created', $dataArray['created']);
        $stmt->bindParam(':modified', $dataArray['modified']);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      } // end catch
    } // end inserMilestone

    // delete milestone by id
    public function deleteMilestoneById($id) {
      try {
        $query = "DELETE FROM milestones WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end delete milestone by id

    // delete milestones by work id
    public function deleteMilestonesByWorkId($work_id) {
      try {
        $query = "DELETE FROM milestones WHERE work_id = :work_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end delete milestone by work id

    // delete milestones by user id
    public function deleteMilestonesByUserId($user_id) {
      try {
        $query = "DELETE FROM milestones WHERE work_id IN (SELECT id FROM works WHERE user_id = :user_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end delete milestones by user id

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

    // update work_id
    public function updateWorkId($id, $work_id) {
      try {
        $query = "UPDATE $this->tableName SET work_id = :work_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':work_id', $work_id, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update work_id

    // update deliverables
    public function updateDeliverables($id, $deliverables) {
      try {
        $query = "UPDATE $this->tableName SET deliverables = :deliverables WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':deliverables', $deliverables, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update deliverables

    // update payment
    public function updatePayment($id, $payment) {
      try {
        $query = "UPDATE $this->tableName SET payment = :payment WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':payment', $payment);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update payment

    // update deadline
    public function updateDeadline($id, $deadline) {
      try {
        $query = "UPDATE $this->tableName SET deadline = :deadline WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':deadline', $deadline);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update deadline

    // update image
    public function updateImage($id, $image) {
      try {
        $query = "UPDATE $this->tableName SET image = :image WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':image', base64_decode($image));
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
      } catch(PDOException $e) {
        die($e->getMessage());
      }
    } // end update image

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
