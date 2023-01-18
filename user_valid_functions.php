<?php
require_once('database_functions.php');

function normal_user_login($username, $password) {
  // connect to db
  $conn = normal_user_database_connect();

  // check if username is unique
  $result = $conn->query("select * from user
                         where username='".$username."'
                         and passwd = '".$password."'");
  if (!$result) {
     throw new Exception('Could not log you in.');
  }

  if ($result->num_rows>0) {
     return true;
  } else {
     throw new Exception('Could not log you in.');
  }
}

function admin_login($username, $password) {
  // connect to db
  $conn = normal_user_database_connect();

  // check if username is unique
  $result = $conn->query("select * from admin_user
                         where username='".$username."'
                         and passwd = '".$password."'");
  if (!$result) {
     throw new Exception('Could not log you in.');
  }

  if ($result->num_rows>0) {
     return true;
  } else {
     throw new Exception('Could not log you in.');
  }
}

function check_valid_user() {
// see if somebody is logged in and notify them if not
  if (isset($_SESSION['valid_normal_user']))  {
      echo "Logged in as ".$_SESSION['valid_normal_user'].".<br>";
  } else {
     // they are not logged in
     do_html_header('Problem:');
     echo 'You are not logged in.<br>';
     do_html_url('index.php', 'Login');
     do_html_footer();
     exit;
  }
}
function check_valid_admin_user()
{
// see if somebody is logged in and notify them if not
  if (isset($_SESSION['valid_admin_user']))  {
      echo "Logged in as ".$_SESSION['valid_admin_user'].".<br>";
  } else {
     // they are not logged in
     do_html_header('Problem:');
     echo 'You are not logged in.<br>';
     do_html_url('index.php', 'Login');
     do_html_footer();
     exit;
  }
}
function filled_out($form_vars) {
  // test that each variable has a value
  foreach ($form_vars as $key => $value) {
     if ((!isset($key)) || ($value == '')) {
        return false;
     }
  }
  return true;
}
function change_password($username, $old_password, $new_password)
{
}
?>
