<?php
require_once('library_functions.php');
session_start();
do_html_header('<strong>'.$_SESSION['location'].' library administatror</strong><br/>Home');
$currentDate = date('Y-m-d');
echo $currentDate."<br/>";
check_valid_admin_user();

// borrow book 
$username = $_POST['borrower_username'];
$bookID = $_POST['borrower_book_id'];

if(user_can_borrow_books($username))
{
    $can_borrow = borrow_book($username, $bookID, $_SESSION['location'], $currentDate); // location is the current library's location

    if(!$can_borrow)
    {
	    echo "Cannot borrow book with book ID = ".$bookID.".<br/>";
    }
    else
    {
	    echo "Borrow book success with book ID = ".$bookID."to user ".$username.".<br/>";		
    }
}
else
{
    echo "User ".$username." has overdue fines, cannot borrow books.<br/>";
}


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