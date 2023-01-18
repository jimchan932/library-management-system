<?php
require_once('library_functions.php');
session_start();
do_html_header('<strong>'.$_SESSION['location'].' library administatror</strong><br/>Home');
$currentDate = date('Y-m-d');
echo $currentDate."<br/>";
check_valid_admin_user();

// borrow book 
$book_list = $_POST['return_book'];
if(count($book_list) > 0)
{
    foreach($book_list as $book_item)
    {
    	$book_array = explode('#', $book_item, 2);
        $book_id = $book_array[0];
	$book_location = $book_array[1];
	return_book($book_id, $book_location);
	echo "Returned book with book id ".htmlspecialchars($book_id).".<br/>";
    }
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