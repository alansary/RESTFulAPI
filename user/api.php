<?php

  // includes
  require_once '../inc/headers.php';
  require_once '../config/database.php';
  require_once '../classes/user.php';
  require_once '../inc/test_input.php';

  // instantiate database
  $database = new Database();

  // GET METHOD
  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['key'])) {
      // key is set

      // Database configuration
      $key = test_input($_GET['key']);
      $db = $database->getConnection($key);
      $user = new User($db);

      // GET user by id
      if (isset($_GET['id'])) {
        // query with user id
        $stmt = $user->readUserById(filter_var(test_input($_GET['id']), FILTER_VALIDATE_INT));
        // check if a record found
        if ($stmt->rowCount()) {
          $data = "";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            extract($row);

            $data .= '{';
            $data .= '"id":'.$id.', ';
            $data .= '"username":"'.$username.'", ';
            $data .= '"password":"'.$password.'", ';
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
      // GET user by username
      else if (isset($_GET['username'])) {
        // query with username
        $stmt = $user->readUserByUsername(test_input($_GET['username']));
        // check if a record found
        if ($stmt->rowCount()) {
          $data = "";
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // extract row
            extract($row);

            $data .= '{';
            $data .= '"id":'.$id.', ';
            $data .= '"username":"'.$username.'", ';
            $data .= '"password":"'.$password.'", ';
            $data .= '"created":"'.$created.'", ';
            $data .= '"modified":"'.$modified.'"';
            $data .= '}';
          }
          // json format output
          echo "[$data]";
        } else {
          echo '[{}]';
        }
      } // end get with username
      // GET all
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
            $data .= '"username":"'.$username.'", ';
            $data .= '"password":"'.$password.'", ';
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
      die('ERROR: YOU MUST PROVIDE A KEY');
    } // end key doesn't exist
  } // end method get
  // POST data
  else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['key'])) {
      // KEY exists
      if (!isset($_POST['method'])) {
        // POST data
        $key = test_input($_POST['key']);
        $db = $database->getConnection($key);
        $user = new User($db);

        // getting the posted data and validating
        if (isset($_POST['id']) && isset($_POST['username']) && isset($_POST['password']) && isset($_POST['created']) && isset($_POST['modified'])) {
          $dataArray = array();
          $id = test_input($_POST['id']);
          $id = filter_var($id, FILTER_VALIDATE_INT);
          $username = test_input($_POST['username']);
          $password = test_input($_POST['password']);
          $created = test_input($_POST['created']);
          $modified = test_input($_POST['modified']);
          $dataArray['id'] = $id;
          $dataArray['username'] = $username;
          $dataArray['password'] = $password;
          $dataArray['created'] = $created;
          $dataArray['modified'] = $modified;
          $user->insertUser($dataArray);
        } // end POST
        else {
          die('ERROR: MISSING PARAMETERS');
        }
      } // end POST
      else {
        // DELETE request
        if (test_input($_POST['method']) == 'DELETE') {
          if (isset($_POST['key'])) {
            // Database configuration
            $key = test_input($_POST['key']);
            $db = $database->getConnection($key);
            $user = new User($db);

            // getting the data from $_DELETE and validating the data
            if (isset($_POST['id'])) {
              $user->deleteUserById(filter_var(test_input($_POST['id']), FILTER_VALIDATE_INT));
            } // id exists
            else if (isset($_POST['username'])) {
              $user->deleteUserByUsername(test_input($_POST['username']));
            } // username exists
            else {
              die('ERROR: YOU MUST PROVIDE THE ID OR THE USERNAME');
            } // id and username don't exist
          } // end key exists
          else {
            die('ERROR: KEY IS REQUIRED');
          } // end no key
        } // end DELETE Request
        // PUT REQUEST
        else if (test_input($_POST['method']) == 'PUT') {
          if (isset($_POST['key'])) {
            // KEY is provided
            $key = test_input($_POST['key']);
            $db = $database->getConnection($key);
            $user = new User($db);

            if (isset($_POST['id'])) {
              $id = filter_var(test_input($_POST['id']));
              if (isset($_POST['username'])) {
                $user->updateUsername($id, test_input($_POST['username']));
              } // end UPDATE user username
              else if (isset($_POST['password'])) {
                $user->updatePassword($id, test_input($_POST['password']));
              } // end UPDATE user password
              else if (isset($_POST['created'])) {
                $user->updateCreated($id, test_input($_POST['created']));
              } // end UPDATE user created
              else if (isset($_POST['modified'])) {
                $user->updateModified($id, test_input($_POST['modified']));
              } // end UPDATE user modified
              else if (isset($_POST['new_id'])) {
                $user->updateId($id, filter_var(test_input($_POST['new_id']), FILTER_VALIDATE_INT));
              } // end UPDATE user id
              else {
                die('ERROR: MISSING PARAMETERS');
              } // end missing parameters
            } // end UPDATE
            else {
              die('ERROR: ID IS NOT PROVIDED');
            } // other
          } // end KEY is provided
          else {
            die('ERROR: YOU MUST PROVIDE THE KEY');
          } // end KEY is not provided
        } // end PUT REQUEST
        else {
          die('ERROR: ONLY DELETE AND PUT METHODS ARE ALLOWED');
        } // end other request
      } // end DELETE and PUT
    } // end KEY exist
    else {
      die('ERROR: YOU MUST PROVIDE A KEY');
    } // end key doesn't exist
  } // end METHOD POST
  else {
    die('ERROR: ONLY PUT AND GET REQUESTS ALLOWED');
  } // end other request
?>
