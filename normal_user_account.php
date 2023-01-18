<?php

// include function files for this application
require_once('library_functions.php');
session_start();

//create short variable names
if (!isset($_POST['username']))  {
  //if not isset -> set with dummy value 
  $_POST['username'] = " "; 
}
$username = $_POST['username'];
if (!isset($_POST['passwd']))  {
  //if not isset -> set with dummy value 
  $_POST['passwd'] = " "; 
}
$passwd = $_POST['passwd'];

if ($username && $passwd) 
{
// they have just tried logging in
  try  {
    normal_user_login($username, $passwd);
    // if they are in the database register the user id
    $_SESSION['valid_normal_user'] = $username;
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

do_html_header('Home');
$currentDate = date('Y-m-d');
echo $currentDate."<br/>";

check_valid_user();

$conn = normal_user_database_connect();
$result = $conn->query("update book set book.fine =  DATEDIFF('".$currentDate."',book.due_date)*0.1 where '".$currentDate."' > DATE(book.due_date)");

echo "<br/><strong>Borrowed books</strong>";
if ($book_array = get_borrowed_books($_SESSION['valid_normal_user'])) 
{
  display_books($book_array);
}
else
    echo "You have not borrowed any books currently.";
echo "<br/><strong>Reserved books </strong>";
if($reserved_book_array = get_reserved_books($_SESSION['valid_normal_user']))
	display_reserved_books($reserved_book_array);
else
	echo "You have not reserved any books currently.";
// give menu of options
display_user_menu();

do_html_footer();
?>
