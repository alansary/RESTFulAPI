<?php

  // includes
  require_once '../inc/headers.php';
  require_once '../config/database.php';
  require_once '../classes/milestone.php';
  require_once '../inc/test_input.php';

  // instantiate database
  $database = new Database();

  // GET METHOD
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['key'])) {
      // Key is provided
      // Database Connection
      $key = test_input($_GET['key']);
      $db = $database->getConnection($key);
      $user = new Milestone($db);

      // GET milestones by work id
      if (isset($_GET['work_id'])) {
        // query with work id
        $stmt = $user->readWorkMilestones(filter_var(test_input($_GET['work_id']), FILTER_VALIDATE_INT));
        // check if a record found
        $num = $stmt->rowCount();
        if ($num) {
          $data = "";
          $x = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            extract($row);
            $data .= '{';
            $data .= '"id":'.$id.', ';
            $data .= '"work_id":'.$work_id.', ';
            $data .= '"deliverables":"'.$deliverables.'", ';
            $data .= '"payment":'.$payment.', ';
            $data .= '"deadline":"'.$deadline.'", ';
            $data .= '"image":"'.base64_encode($image).'", ';
            $data .= '"created":"'.$created.'", ';
            $data .= '"modified":"'.$modified.'"';
            $data .= '}';
            $data .= $x<$num ? ',' : '';
            $x++;
          }
          // json format output
          echo "[$data]";
        } else {
          echo '[{}]';
        }
      } // end GET milestones by work id
      // GET milestones by user id
      else if (isset($_GET['user_id'])) {
        // query with user id
        $stmt = $user->readUserMilestones(filter_var(test_input($_GET['user_id'])));
        // check if a record found
        $num = $stmt->rowCount();
        $x = 1;
        if ($num) {
          $data = "";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            extract($row);
            $data .= '{';
            $data .= '"id":'.$id.', ';
            $data .= '"work_id":'.$work_id.', ';
            $data .= '"deliverables":"'.$deliverables.'", ';
            $data .= '"payment":'.$payment.', ';
            $data .= '"deadline":"'.$deadline.'", ';
            $data .= '"image":"'.base64_encode($image).'", ';
            $data .= '"created":"'.$created.'", ';
            $data .= '"modified":"'.$modified.'"';
            $data .= '}';
            $data .= $x<$num ? ',' : '';
            $x++;
          }
          // json format output
          echo "[$data]";
        } else {
          echo '[{}]';
        }
      } // end GET milestones by user id
      // GET milestone by id
      else if (isset($_GET['id'])) {
        // query with milestone id
        $stmt = $user->readMilestoneById(filter_var(test_input($_GET['id'])));
        // check if a record found
        if ($stmt->rowCount()) {
          $data = "";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            extract($row);
            $data .= '{';
            $data .= '"id":'.$id.', ';
            $data .= '"work_id":'.$work_id.', ';
            $data .= '"deliverables":"'.$deliverables.'", ';
            $data .= '"payment":'.$payment.', ';
            $data .= '"deadline":"'.$deadline.'", ';
            $data .= '"image":"'.base64_encode($image).'", ';
            $data .= '"created":"'.$created.'", ';
            $data .= '"modified":"'.$modified.'"';
            $data .= '}';
          }
          // json format output
          echo "[$data]";
        } else {
          echo '[{}]';
        }
      } // end GET milestone by id
      // GET all milestones
      else {
        // query all
        $stmt = $user->readAll();
        // check if a record found
        $num = $stmt->rowCount();
        if ($num) {
          $data = "";
          $x = 1;
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            extract($row);

            $data .= '{';
            $data .= '"id":'.$id.', ';
            $data .= '"work_id":'.$work_id.', ';
            $data .= '"deliverables":"'.$deliverables.'", ';
            $data .= '"payment":'.$payment.', ';
            $data .= '"deadline":"'.$deadline.'", ';
            $data .= '"image":"'.base64_encode($image).'", ';
            $data .= '"created":"'.$created.'", ';
            $data .= '"modified":"'.$modified.'"';
            $data .= '}';
            $data .= $x<$num ? ',' : '';
            $x++;
          }
          // json format output
          echo "[$data]";
        } else {
          echo '[{}]';
        }
      } // end GET all milestones
    } // end key exist
    else {
      // Key is not provided
      die('ERROR: YOU MUST PROVIDE A KEY');
    }
  } // end GET METHOD
  // POST METHOD
  else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // KEY exists
    if (isset($_POST['key'])) {
      // Database Configuration
      $key = test_input($_POST['key']);
      $db = $database->getConnection($key);
      $milestone = new Milestone($db);

      if (!isset($_POST['method'])) {
        // POST data
        // getting the posted data and validating
        if (isset($_POST['id']) && isset($_POST['work_id']) && isset($_POST['deliverables']) && isset($_POST['payment']) && isset($_POST['deadline']) && isset($_POST['image']) && isset($_POST['created']) && isset($_POST['modified'])) {
          $dataArray = array();
          $id = test_input($_POST['id']);
          $id = filter_var($id, FILTER_VALIDATE_INT);
          $work_id = test_input($_POST['work_id']);
          $work_id = filter_var($work_id, FILTER_VALIDATE_INT);
          $deliverables = test_input($_POST['deliverables']);
          $payment = filter_var(test_input($_POST['payment']), FILTER_VALIDATE_FLOAT);
          $deadline = test_input($_POST['deadline']);
          $image = $_POST['image'];
          $image = trim($image);
          $image = htmlspecialchars($image);
          $created = test_input($_POST['created']);
          $modified = test_input($_POST['modified']);
          $dataArray['id'] = $id;
          $dataArray['work_id'] = $work_id;
          $dataArray['deliverables'] = $deliverables;
          $dataArray['payment'] = $payment;
          $dataArray['deadline'] = $deadline;
          $dataArray['image'] = $image;
          $dataArray['created'] = $created;
          $dataArray['modified'] = $modified;
          $milestone->insertMilestone($dataArray);
        } // end POST
        else {
          die('ERROR: MISSING PARAMETERS');
        }
      } // end POST data
      else {
        // DELETE or PUT
        if (test_input($_POST['method']) == 'DELETE') {
          if (isset($_POST['id'])) {
            $milestone = new Milestone($db);
            $milestone->deleteMIlestoneById(test_input($_POST['id']));
          } // end deleting milestone with id
          else if (isset($_POST['work_id'])) {
            $milestone = new Milestone($db);
            $milestone->deleteMilestonesByWorkId(test_input($_POST['work_id']));
          }
          else if (isset($_POST['user_id'])) {
            $milestone = new Milestone($db);
            $milestone->deleteMilestonesByUserId(test_input($_POST['user_id']));
          }
          else {
            die('ERROR: MISSING PARAMETERS');
          }
        } // end DELETE data
        // PUT METHOD
        else if (test_input($_POST['method']) == 'PUT') {
          if (isset($_POST['id'])) {
            $id = filter_var(test_input($_POST['id']), FILTER_VALIDATE_INT);
            if (isset($_POST['new_id'])) {
              $milestone->updateId($id, filter_var(test_input($_POST['new_id']), FILTER_VALIDATE_INT));
            } // end update id
            else if (isset($_POST['work_id'])) {
              $milestone->updateWorkId($id, filter_var(test_input($_POST['work_id']), FILTER_VALIDATE_INT));
            } // end update work_id
            else if (isset($_POST['deliverables'])) {
              $milestone->updateDeliverables($id, test_input($_POST['deliverables']));
            } // end update deliverables
            else if (isset($_POST['payment'])) {
              $milestone->updatePayment($id, test_input($_POST['payment']));
            } // end update payment
            else if (isset($_POST['deadline'])) {
              $milestone->updateDeadline($id, test_input($_POST['deadline']));
            } // end update deadline
            else if (isset($_POST['image'])) {
              $image = trim($_POST['image']);
              $image = htmlspecialchars($image);
              $milestone->updateImage($id, $image);
            } // end update image
            else if (isset($_POST['created'])) {
              $milestone->updateCreated($id, test_input($_POST['created']));
            } // end update created
            else if (isset($_POST['modified'])) {
              $milestone->updateModified($id, test_input($_POST['modified']));
            } // end update modified
            else {
              die('ERROR: MISSING PARAMETERS');
            } // end missing parameter
          } // end id exists
          else {
            die('ERROR: ID IS NOT PROVIDED');
          } // end id doesn't exist
        } // end PUT data
        else {
          die('ERROR: ONLY DELETE METHOD IS ALLOWED');
        } // end other method
      } // end method is set
    } // end KEY exist
    else {
      die('ERROR: YOU MUST PROVIDE A KEY');
    } // end KEY doesn't exist
  } // end METHOD POST
  else {
    die('ERROR: ONLY POST AND GET REQUESTS ARE ALLOWED');
  }
?>
