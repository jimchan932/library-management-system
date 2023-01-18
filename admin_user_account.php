<?php
// include function files for this application
require_once('library_functions.php');
session_start();
	
//create short variable names
if (!isset($_POST['admin_username']))  {
  //if not isset -> set with dummy value 
  $_POST['admin_username'] = " "; 
}
$username = $_POST['admin_username'];
if (!isset($_POST['admin_passwd']))  {
  //if not isset -> set with dummy value 
  $_POST['admin_passwd'] = " "; 
}
$passwd = $_POST['admin_passwd'];

if ($username && $passwd) 
{
// they have just tried logging in
  try  {
    admin_login($username, $passwd);
    // if they are in the database register the user id
    $_SESSION['valid_admin_user'] = $username;

  }
  catch(Exception $e)  {
    // unsuccessful login
    do_html_header('Problem:');
    echo 'You could not be logged in.<br>
          You must be logged in to view this page.';
    do_html_url('index.php', 'Login');
    do_html_footer();
    exit;
  }
}

$_SESSION['location'] = get_admin_location($username);
do_html_header('<strong>'.$_SESSION['location'].' library administatror</strong><br/>Home');
$currentDate = date('Y-m-d');
$_SESSION['current date'] = $currentDate;
echo $currentDate.'<br/>';
check_valid_admin_user();

echo "<strong>Books moving to Shelf</strong>";
if($book_array = get_moving_books($_SESSION['location']))
{
    display_moving_books($book_array);
}
else
{
    echo '<br/>';
}
echo "<strong>Books to depart</strong>";
if($book_array = get_books_to_depart($_SESSION['location']))
{
    display_books_to_depart($book_array);
}
else
{
    echo '<br/>';
}

echo "<strong>Books to arrive</strong>";
if($book_array = get_books_to_arrive($_SESSION['location']))
{
    display_books_to_arrive($book_array);
}
else
{
    echo '<br/>';
}
display_borrow_book_form();
display_search_record_form();
do_html_footer();
?>