<?php
require_once('database_functions.php');

function get_borrowed_books($username) {
  //extract from the database all the books this user has borrowed
  $conn = normal_user_database_connect();
  $result = $conn->query("select book.bookID, book.title, book.author, book.due_date, book.fine
                          from user, borrow, book
                          where user.username = borrow.username 
						        and borrow.bookID = book.bookID
								and user.username = 'jim314'"); 
  
  if (!$result) {
    return false;
  }

  $book_array = array();
  for ($count = 1; $row = $result->fetch_array(); ++$count)
  {
        $book_array[$count][0] = $row[0];
	$book_array[$count][1] = $row[1];
	$book_array[$count][2] = $row[2];
	$book_array[$count][3] = $row[3];
	$book_array[$count][4] = $row[4];
  }
  return $book_array;
}
function get_searched_books($keyword, $choice)
{
	$conn = normal_user_database_connect();
	$book_array = array();

	$query1 = "select book.bookID, book.title, book.author, book.status, book.due_date, book.available, book.library_location
		 	   		 from book where book.title like '%".$keyword."%'";
	$query2 = "select book.bookID, book.title, book.author, book.status, book.due_date, book.available, book.library_location
		 	   		 from book where book.author like '%".$keyword."%'";
	$query3= "select book.bookID, book.title, book.author, book.status, book.due_date, book.available, book.library_location
		 	   		 from book where book.publisher like '%".$keyword."%'";
	$query4 = "select  book.bookID, book.title, book.author, book.status, book.due_date, book.available, book.library_location		 	   		
               	from book where book.category like '%".$keyword."%'";
	if($choice == 1)
            $result = $conn->query($query1);
	if($choice == 2)
            $result = $conn->query($query2);	    
	if($choice == 3)
            $result = $conn->query($query3);	
	if($choice == 4)	
            $result = $conn->query($query4);
	if(!$result) return false;				 
	for ($count = 1; $row = $result->fetch_array(); ++$count) {
	      $book_array[$count][0] = $row[0];
	      $book_array[$count][1] = $row[1];
	      $book_array[$count][2] = $row[2];
	      $book_array[$count][3] = $row[3];
	      $book_array[$count][4] = $row[4];
	      $book_array[$count][5] = $row[5];
		  $book_array[$count][6] = $row[6];
		  
	}
	return $book_array;
}
function get_reserved_books($username)
{
	$conn = normal_user_database_connect();
	$book_array = array();
	
	$result = $conn->query("select reserve.bookID, book.title, book.author, book.library_location, reserve.departed, reserve.arrived, reserve.arrival_date
		  	        from reserve, book
	                        where reserve.username = '".$username."' and reserve.bookID = book.bookID and reserve.library_location = book.library_location");
	 
	$user_lib_loc = $conn->query("select user.location from user where user.username = '".$username."'")->fetch_array()[0];
	
	if(!$result) 
	{
		
		return false;
	}
	for($count = 1; $row = $result->fetch_array(); ++$count)
	{
	      $book_array[$count][0] = $row[0];
	      $book_array[$count][1] = $row[1];
	      $book_array[$count][2] = $row[2];
	      $book_array[$count][3] = $row[3];
	      $book_array[$count][4] = $row[4];
	      $book_array[$count][5] = $row[5];
	      $book_array[$count][6] = $row[6];	
	      $book_array[$count][7] = $user_lib_loc;	
	}
	
	return $book_array;
}
function get_books_to_depart($library_location)
{
	$conn = normal_user_database_connect();
	$book_array = array();
	
	$result = $conn->query("select reserve.bookID, book.title, book.author, user.location
		  	                from reserve, book, user
	                        where reserve.bookID = book.bookID and reserve.library_location = book.library_location and reserve.departed = 0 
							and reserve.library_location = '".$library_location."'and reserve.username = user.username order by user.location ");
	for($count = 1; $row = $result->fetch_array(); ++$count)
	{
	      $book_array[$count][0] = $row[0];
	      $book_array[$count][1] = $row[1];
	      $book_array[$count][2] = $row[2];
		  $book_array[$count][3] = $row[3];	  
	}
	return $book_array;
}
function get_books_to_arrive($library_location)
{
	$conn = normal_user_database_connect();
	$book_array = array();
	
	$result = $conn->query("select reserve.bookID, reserve.library_location, book.title, book.author
		  	                from reserve, book, user
	                        where reserve.bookID = book.bookID and reserve.departed = 1 and reserve.arrived = 0 
							and user.location = '".$library_location."' and reserve.username = user.username order by reserve.library_location");
	for($count = 1; $row = $result->fetch_array(); ++$count)
	{
	      $book_array[$count][0] = $row[0];
	      $book_array[$count][1] = $row[1];
	      $book_array[$count][2] = $row[2];
		  $book_array[$count][3] = $row[3];
	}
	return $book_array;
}
function add_reserve($bookID, $library_location, $user)
{
	$conn = normal_user_database_connect();

	// add reservation to table
	if($conn->query("insert into reserve values ('".$user."','".$bookID."','".$library_location."',0, 0, null)"))
	{
	    return true;
	}
	else return false;
}
function set_book_status($bookID, $available, $status)
{
	$conn = normal_user_database_connect();
	$conn->query("update book set available = '".$available."' where bookID = '".$bookID."'");
	$conn->query("update book set status = '".$status."' where bookID = '".$bookID."'");
}
function set_depart_book($bookID, $library_location)
{
	$conn = normal_user_database_connect();
	$conn->query("update reserve set departed = 1 where reserve.bookID = '".$bookID."' and reserve.library_location = '".$library_location."'");
}
function set_arrive_book($bookID, $library_location)
{
	$conn = normal_user_database_connect();
	$conn->query("update reserve set arrived = 1 where reserve.bookID = '".$bookID."' and reserve.library_location = '".$library_location."'");
}

function borrow_book($username, $bookID, $book_location, $currentDate)
{
	$conn = normal_user_database_connect();
	
	$result = $conn->query("select available from book where bookID = '".trim($bookID)."' and library_location = '".trim($book_location)."'")->fetch_array();
    if(!$result)
	{
	    echo "No book with book ID ".$bookID.".<br/>";
	    return false;
	}
	$is_available = $result[0];
	if(!$is_available)
	{
	    echo "Book with book ID ".$bookID." is not available.<br/>";
	    return false;
	}
    $conn->query("update book set due_date = DATE_ADD('".$currentDate."', INTERVAL 31 DAY) where book.bookID = '".$bookID."'");
	$conn->query("update book set status = 'Borrowed' where book.bookID = '".$bookID."'");
    $conn->query("update book set available = 0 where book.bookID = '".$bookID."'");
	$conn->query("insert into borrow values('".$bookID."','".$book_location."','".$username."')");
	return true;
}
function borrow_reserved_book($username, $bookID, $book_location, $currentDate)
{
  $conn = normal_user_database_connect();
  $conn->query("update book set due_date = DATE_ADD('".$currentDate."', INTERVAL 31 DAY) where book.bookID = '".$bookID."' and book.library_location = '".$book_location."'");
  $conn->query("update book set status = 'Borrowed' where book.bookID = '".$bookID."' and book.library_location = '".$book_location."'");
  $conn->query("update book set available = 0 where book.bookID = '".$bookID."' and book.library_location = '".$book_location."'");
  $conn->query("insert into borrow values('".$bookID."','".$book_location."','".$username."')");

  $conn->query("delete from reserve where bookID = '".$bookID."' and library_location = '".$book_location."'");
  return true;
}

function user_can_borrow_books($username)
{
	$conn = normal_user_database_connect();		
	$has_fines = $conn->query("select count(*) from borrow join book on borrow.bookID = book.bookID
										  where borrow.username = '".$username."'")->fetch_array()[0];
	if($has_fines > 0)
	{
		return false;
	}
	else
	{
		return true;
	}
}

function get_admin_location($username)
{
    $conn = normal_user_database_connect();
    return $conn->query("select admin_user.location from admin_user where username = '".$username."'")->fetch_array()[0];
}

function get_user_borrow_record_without_fines($username)
{
  //extract from the database all the books this user has borrowed
  $conn = normal_user_database_connect();
  $result = $conn->query("select book.bookID, book.library_location, book.title, book.author, book.due_date
                          from user, borrow, book
                          where user.username = borrow.username 
			    and borrow.bookID = book.bookID
		    	    and user.username = '".$username."' 
                            and book.fine = 0"); 
  if (!$result) {
    return false;
  }

  $book_array = array();
  for ($count = 1; $row = $result->fetch_array(); ++$count) {
        $book_array[$count][0] = $row[0];
	$book_array[$count][1] = $row[1];
	$book_array[$count][2] = $row[2];
	$book_array[$count][3] = $row[3];
	$book_array[$count][4] = $row[4];
  }
  return $book_array;
}

function get_user_borrow_record_with_fines($username)
{
  //extract from the database all the books this user has borrowed
  $conn = normal_user_database_connect();
  $result = $conn->query("select book.bookID, book.library_location, book.title, book.author, book.due_date, book.fine
                          from user, borrow, book
                          where user.username = borrow.username 
			    and borrow.bookID = book.bookID
		    	    and user.username = '".$username."' 
                            and book.fine > 0"); 
  
  if (!$result) {
    return false;
  }

  $book_array = array();
  for ($count = 1; $row = $result->fetch_array(); ++$count) {
        $book_array[$count][0] = $row[0];
	$book_array[$count][1] = $row[1];
	$book_array[$count][2] = $row[2];
	$book_array[$count][3] = $row[3];
	$book_array[$count][4] = $row[4];
	$book_array[$count][5] = $row[5];	
  }
  return $book_array;
}

function return_book($bookID, $book_location)
{
	$conn = normal_user_database_connect();
	$conn->query("delete from borrow where bookID = '".$bookID."' and library_location = '".$book_location."'");
	$conn->query("update book set available = 1, status = 'Moving to shelf', due_date = null where bookID = '".$bookID."' and library_location = '".$book_location."'");
}

function return_book_and_pay_fine($username, $bookID, $book_location)
{
	$conn = normal_user_database_connect();
	$conn->query("delete from borrow where bookID = '".$bookID."' and library_location = '".$book_location."'");
	$conn->query("update book set available = 1, status = 'Moving to shelf', fine = 0, due_date = null where bookID = '".$bookID."' and library_location = '".$book_location."'");
	$conn->query("update user set num_of_overdue_books = num_of_overdue_books - 1 where username = '".$username."'");
}
function get_moving_books($library_location)
{
	$book_array = array();
	$conn = normal_user_database_connect();	     
	$result = $conn->query("select book.bookID, book.title, book.author from book where book.library_location = '".$library_location."' and book.status = 'Moving to shelf'");
	if(!$result) return false;
	for($count = 1; $row = $result->fetch_array(); $count++)
	{
		
		$book_array[$count][0] = $row[0];
		$book_array[$count][1] = $row[1];
		$book_array[$count][2] = $row[2];
	}
	return $book_array;
}
function move_book_to_shelf($bookID, $library_location)
{
	$conn = normal_user_database_connect();
	$result = $conn->query("update book set status = 'On Shelf' where bookID = '".$bookID."' and library_location = '".$library_location."'");
}
?>
