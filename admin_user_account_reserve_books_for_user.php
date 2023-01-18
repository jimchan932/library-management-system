<?php
require_once('library_functions.php');
session_start();
do_html_header('<strong>'.$_SESSION['location'].' library administatror</strong><br/>Home');
$currentDate = date('Y-m-d');
echo $currentDate."<br/>";
check_valid_admin_user();

// borrow reserved  book for user 
$book_list = $_POST['reserve_books'];
if(user_can_borrow_books($_SESSION['record_username']))
{
    if(count($book_list) > 0)
    {
	    foreach($book_list as $book_item)
	    {
		    $book_array = explode('#', $book_item, 2);
		    $bookID = $book_array[0];
		    $book_location = $book_array[1];
		    borrow_reserved_book($_SESSION['record_username'], $bookID, $book_location, $currentDate);		  
		    echo "Borrow reserved book success with book ID = ".$bookID."to user ".$_SESSION['record_username'].".<br/>";		

	    }
    }
}
else
{
    echo "User ".$_SESSION['record_username']." still has overdue fines, cannot borrow reserved books.";
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