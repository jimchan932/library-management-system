<?php
    require('library_functions.php');
    session_start();
    
    $username = $_SESSION['valid_normal_user'];
    check_valid_user();
    if(user_can_borrow_books($username))
    {
	if(!filled_out($_POST))
	{
	    echo '<p>You have not chosen any books to reserve, please try again<br>
		  Please try again.</p>';
	    display_user_menu();
	    do_html_footer();
	    exit;		
	}
	else
	{
	$booklist = $_POST['reserve'];
	    if(count($booklist) > 0)
	    {
		foreach($booklist as $book_item)
		{
		    $book_array = explode('#', $book_item, 2);
		    $bookID = $book_array[0];
		    $book_location = $book_array[1];
		    echo 'Yes';
		    add_reserve($bookID, $book_location, $username);
		    set_book_status($bookID, 0, 'Reserved');
		}
	    }
	}
    }
    else
    {
	echo "User ".$username." cannot reserve books.<br/>";
    }

    do_html_header('Home');
    display_user_menu();
    do_html_footer();
?>
