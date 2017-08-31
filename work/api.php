<?php

  // includes
  require_once '../inc/headers.php';
  require_once '../config/database.php';
  require_once '../classes/work.php';
  require_once '../inc/test_input.php';

  // instantiate database
  $database = new Database();

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['key'])) {
      // KEY exists
      $key = test_input($_GET['key']);
      $db = $database->getConnection($key);
      $user = new Work($db);

      if (isset($_GET['id'])) {
        // query with work id
        $stmt = $user->readWork(filter_var(test_input($_GET['id']), FILTER_VALIDATE_INT));
        // check if a record found
        if ($stmt->rowCount()) {
          $data = "";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            extract($row);

            $data .= '{';
            $data .= '"id":'.$id.', ';
            $data .= '"user_id":'.$user_id.', ';
            $data .= '"description":"'.$description.'", ';
            $data .= '"created":"'.$created.'", ';
            $data .= '"modified":"'.$modified.'"';
            $data .= '}';
          }
          // json format output
          echo "[$data]";
        } else {
          echo '[{}]';
        }
      } // end get with id
      else if (isset($_GET['user_id'])) {
        // query with user id
        $stmt = $user->readUserWorks(filter_var(test_input($_GET['user_id']), FILTER_VALIDATE_INT));
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
            $data .= '"user_id":'.$user_id.', ';
            $data .= '"description":"'.$description.'", ';
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
      } // end get with user id
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
            $data .= '"user_id":'.$user_id.', ';
            $data .= '"description":"'.$description.'", ';
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
      } // end get readAll
    } // end key exist
    else {
      die('You must provide the key');
    }
  } // end method get
  // POST REQUEST
  else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['key'])) {
      // key exists
      $key = test_input($_POST['key']);
      $db = $database->getConnection($key);
      $work = new Work($db);

      if (!isset($_POST['method'])) {
        // getting the posted data and validating
        if (isset($_POST['id']) && isset($_POST['user_id']) && isset($_POST['description']) && isset($_POST['created']) && isset($_POST['modified'])) {
          $dataArray = array();
          $id = test_input($_POST['id']);
          $id = filter_var($id, FILTER_VALIDATE_INT);
          $user_id = test_input($_POST['user_id']);
          $user_id = filter_var($user_id, FILTER_VALIDATE_INT);
          $description = test_input($_POST['description']);
          $created = test_input($_POST['created']);
          $modified = test_input($_POST['modified']);
          $dataArray['id'] = $id;
          $dataArray['user_id'] = $user_id;
          $dataArray['description'] = $description;
          $dataArray['created'] = $created;
          $dataArray['modified'] = $modified;
          $work->insertWork($dataArray);
        } // end POST
        else {
          die('ERROR: MISSING PARAMETERS');
        }
      } // end POST data
      // DELETE REQUEST
      else {
         if (test_input($_POST['method'] == 'DELETE')) {
          if (isset($_POST['id'])) {
            $work = new Work($db);
            $work->deleteWorkById(test_input($_POST['id']));
          } // DELETE work by id
          else if (isset($_POST['user_id'])) {
            $work = new Work($db);
            $work->deleteWorkByUserId(test_input($_POST['user_id']));
          } // DELETE work by user id
          else {
            die('ERROR: MISSING PARAMETERS');
          } // end other
        } // end DELETE data
        // PUT REQUEST
        else if (test_input($_POST['method'] == 'PUT')) {
          if (isset($_POST['id'])) {
            $id = filter_var(test_input($_POST['id']), FILTER_VALIDATE_INT);
            if (isset($_POST['user_id'])) {
              $work->updateUserId($id, filter_var(test_input($_POST['user_id']), FILTER_VALIDATE_INT));
            } // end update user_id
            else if (isset($_POST['description'])) {
              $work->updateDescription($id, test_input($_POST['description']));
            } // end update description
            else if (isset($_POST['created'])) {
              $work->updateCreated($id, test_input($_POST['created']));
            } // end update created
            else if (isset($_POST['modified'])) {
              $work->updateModified($id, test_input($_POST['modified']));
            } // end update modified
            else if (isset($_POST['new_id'])) {
              $work->updateId($id, filter_var(test_input($_POST['new_id']), FILTER_VALIDATE_INT));
            } // end update id
            else {
              die('ERROR: MISSING PARAMETERS');
            } // parameters required
          } // end id exists
          else {
            die('ERROR: ID IS REQUIRED');
          } // id doesn't exist
        } // end PUT data
        else {
          die('ERROR: ONLY DELETE METHOD IS ALLOWED');
        }
      } // end method is set
    } // end KEY exist
    else {
      die('ERROR: YOU MUST PROVIDE A KEY');
    } // end key doesn't exist
  } // end METHOD POST
  else {
    die('ERROR: ONLY POST AND GET REQUESTS ARE ALLOWED');
  }
?>
