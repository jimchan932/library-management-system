<?php

function do_html_header($title) {
  // print an HTML header
?>
<!doctype html>
  <html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $title;?></title>
    <style>
      body { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      li, td { font-family: Arial, Helvetica, sans-serif; font-size: 13px }
      hr { color: #3333cc;}
      a { color: #000 }
      div.formblock
         { background: #ccc; width: 300px; padding: 6px; border: 1px solid #000;}
    </style>
  </head>
  <body>
  <div>
    <img src="sysu_library_logo.png" alt="SYSU library logo" height="55" width="57" style="float: left; padding-right: 6px;" />
      <h1>中山大学图书馆</h1>
  </div>
  <hr />
<?php
  if($title) {
    do_html_heading($title);
  }
}

function do_html_footer() {
  // print an HTML footer
?>
  </body>
  </html>
<?php
}

function do_html_heading($heading) {
  // print heading
?>
  <h2><?php echo $heading;?></h2>
<?php
}

function display_normal_user_login_form() {
?>
  <form method="post" action="normal_user_account.php">
  <div class="formblock">
    <h2>Members Log In Here</h2>

    <p><label for="username">Username:</label><br/>
    <input type="text" name="username" id="username" /></p>

    <p><label for="passwd">Password:</label><br/>
    <input type="password" name="passwd" id="passwd" /></p>

    <button type="submit">Log In</button>
  </div>
 </form>
<?php
}
function display_admin_user_login_form() 
{
?>
  <form method="post" action="admin_user_account.php">
  <div class="formblock">
    <h2>Administrator Log In Here</h2>

    <p><label for="username">Username:</label><br/>
    <input type="text" name="admin_username" id="admin_username" /></p>

    <p><label for="passwd">Password:</label><br/>
    <input type="password" name="admin_passwd" id="admin_passwd" /></p>

    <button type="submit">Log In</button>
  </div>
 </form>
<?php
}
function display_search_book_form()
{
?>    
    <form method="post" action="search_book_result.php">
    <div class="formblock">
    <h2>Book search</h2>
    <input type="text" name="keyword" id="keyword" /></p>    
    <select name="choice">
    <option value = "1">Title</option>
    <option value = "2">Author</option>
    <option value = "3">Publisher</option>
    <option value = "4">Category</option>
    </select>
    <button type="submit">Search</button>
    </div>
<?php
}
function display_books($book_array) {
?>
  <br>
  <form name="borrowed_books_table" method="post">
  <table width="300" cellpadding="2" cellspacing="0">
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor=\"".$color."\"><td><strong>Book ID</strong></td>";
    echo "<td><strong>Title</strong></td>";
  echo "<td><strong>Author</strong></td>";
  echo "<td><strong>Due Date</strong></td>";
  echo "<td><strong>Fines</strong></td>";
  echo "</tr>";
  if ((is_array($book_array)) && (count($book_array) > 0)) {
    foreach ($book_array as $book)  {
      if ($color == "#cccccc") {
        $color = "#ffffff";
      } else {
        $color = "#cccccc";
      }
	  $bookID = $book[0];
	  $title = $book[1];
	  $author = $book[2];
	  $due_date = $book[3];
	  $fines = $book[4];
	  //remember to call htmlspecialchars() when we are displaying user data
          echo "<tr bgcolor=\"".$color."\"><td><a href=\"".$bookID."\">".htmlspecialchars($bookID)."</a></td>";
	  echo "<td><a href=\"".$title."\">".htmlspecialchars($author)."</a></td>";	  
	  echo "<td><a href=\"".$author."\">".htmlspecialchars($author)."</a></td>";
	  echo "<td><a href=\"".$due_date."\">".htmlspecialchars($due_date)."</a></td>";
	  echo "<td><a href=\"".$fines."\">".htmlspecialchars($fines)."</a></td></tr>";		
    }
  } else {
    echo "<tr><td>Currently, you haven't borrowed any books.</td></tr>";
  }
?>
  </table>
  </form>
<?php
}
function display_searched_books($book_array) {
?>
  <br>
  <form name="borrowed_books_table" method="post" action="reserve_book.php">
  <div class="formblock"> 
  <table width="300" cellpadding="2" cellspacing="0">
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor=\"".$color."\"><td><strong>Book ID</strong></td>";
  echo "<td><strong>Title</strong></td>";
  echo "<td><strong>Author</strong></td>";
  echo "<td><strong>Status</strong></td>";
  echo "<td><strong>Library location</strong></td>";
  echo "</tr>";
  if ((is_array($book_array)) && (count($book_array) > 0)) {
    foreach ($book_array as $book)  {
      if ($color == "#cccccc") {
        $color = "#ffffff";
      } else {
        $color = "#cccccc";
      }
	  $bookID = $book[0];
	  $title = $book[1];
	  $author = $book[2];
	  $status = $book[3];
	  $due_date = $book[4];
	  $is_available = $book[5];
	  $library_location = $book[6];

      //remember to call htmlspecialchars() when we are displaying user data
      echo "<tr bgcolor=\"".$color."\"><td><a href=\"".$bookID."\">".htmlspecialchars($bookID)."</a></td>";
	  echo "<td><a href=\"".$title."\">".htmlspecialchars($title)."</a></td>";
	  echo "<td><a href=\"".$author."\">".htmlspecialchars($author)."</a></td>";
	  if(strcmp($status, 'Borrowed') == 0)
		echo "<td><a href=\"".$status."\">".htmlspecialchars($status." (".$due_date.")")."</a></td>";
	  else
		echo "<td><a href=\"".$status."\">".htmlspecialchars($status)."</a></td>";
      echo "<td><a href=\"".$library_location."\">".htmlspecialchars($library_location)."</a></td>";
	  if($is_available)	  
	  {
	       echo "<td><input type=\"checkbox\" name=\"reserve[]\"
			 value=\"".$bookID.'#'.$library_location."\"></td>";	
	  }
	  echo "</tr>";	  
    }
  } else {
    echo "<tr><td>Failed to search books with given keyword.</td></tr>";
  }
?>
  </table>
  <button type="submit">Reserve books</button>
  </div>
  </form>
<?php
}
function display_reserved_books($book_array)
{	
?>
  <br>
  <form name="borrowed_books_table" method="post">
  <table width="300" cellpadding="2" cellspacing="0">
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor=\"".$color."\"><td><strong>Book ID</strong></td>";
  echo "<td><strong>Title</strong></td>";
  echo "<td><strong>Author</strong></td>";
  echo "<td><strong>Library location</strong></td>";
  echo "<td><strong>Delivery status</strong></td>";
  echo "</tr>";
  if ((is_array($book_array)) && (count($book_array) > 0)) 
  {
   
    foreach ($book_array as $book)  {
      if ($color == "#cccccc") {
        $color = "#ffffff";
      } else {
        $color = "#cccccc";
      }
      $bookID = $book[0];
      $title = $book[1];
      $author = $book[2];
      $book_location = $book[3];
      $departed = $book[4];
      $arrived = $book[5];
      $arrival_date = $book[6];
      $arrival_location = $book[7];

      //remember to call htmlspecialchars() when we are displaying user data
      echo "<tr bgcolor=\"".$color."\"><td><a href=\"".$bookID."\">".htmlspecialchars($bookID)."</a></td>";
	  echo "<td><a href=\"".$title."\">".htmlspecialchars($title)."</a></td>";
	  echo "<td><a href=\"".$author."\">".htmlspecialchars($author)."</a></td>";
	  echo "<td><a href=\"".$book_location."\">".htmlspecialchars($book_location)."</a></td>";	  
	  if($departed && !$arrived)
		  echo "<td><a href=\"".$arrival_location."\">Departed to ".$arrival_location;
          else if($departed && $arrived)
	          echo "<td><a href=\"".$arrival_location."\">Arrived at ".$arrival_location." on ".$arrival_date."</a></td>";
	  else 
		  echo  "<td><a href=\"".$arrival_location."\">Not yet departed</a></td>";
		  
    }
  } else {
    echo "<tr><td>Currently, you haven't borrowed any books.</td></tr>";
  }
  ?>
  </table>
  </form>
<?php
}
function display_homepage_menu() {
  // display the menu options on this page
?>
<hr>
<a href="normal_user_login.php">Member login</a> &nbsp;|&nbsp;
<a href="admin_login.php">Administrator login</a> &nbsp;|&nbsp;
<hr>
<?php
}
function display_books_to_depart($book_array) {
?>
  <br>
  <form name="departure_books_table" method="post" action="admin_user_account_click_departed.php">
  <div class="formblock"> 
  <table width="300" cellpadding="2" cellspacing="0">
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor=\"".$color."\"><td><strong>Book ID</strong></td>";
  echo "<td><strong>Title</strong></td>";
  echo "<td><strong>Author</strong></td>";
  echo "<td><strong>Arrival location</strong></td>";
  echo "</tr>";
  if ((is_array($book_array)) && (count($book_array) > 0)) {
    foreach ($book_array as $book)  {
      if ($color == "#cccccc") {
        $color = "#ffffff";
      } else {
        $color = "#cccccc";
      }
	  $bookID = $book[0];
	  $title = $book[1];
	  $author = $book[2];
	  $arrival_location = $book[3];
      echo "<tr bgcolor=\"".$color."\"><td><a href=\"".$bookID."\">".htmlspecialchars($bookID)."</a></td>";
	  echo "<td><a href=\"".$title."\">".htmlspecialchars($title)."</a></td>";
	  echo "<td><a href=\"".$author."\">".htmlspecialchars($author)."</a></td>";
	  echo "<td><a href=\"".$arrival_location."\">".htmlspecialchars($arrival_location)."</a></td>";	  
	  
	  echo "<td><input type=\"checkbox\" name=\"depart[]\"
			 value=\"".$bookID."\"></td>";	
	
	  echo "</tr>";	  
    }
  } else {
    echo "<tr><td>No books to depart.</td></tr>";
  }
?>
  </table>
  <button type="submit">Depart books</button>
  </div>
  </form>
<?php
}
function display_books_to_arrive($book_array) {
?>
  <br>
  <form name="departure_books_table" method="post" action="admin_user_account_click_arrived.php">
  <div class="formblock"> 
  <table width="300" cellpadding="2" cellspacing="0">
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor=\"".$color."\"><td><strong>Book ID</strong></td>";
  echo "<td><strong>Title</strong></td>";
  echo "<td><strong>Author</strong></td>";
  echo "<td><strong>Arrival location</strong></td>";
  echo "</tr>";
  if ((is_array($book_array)) && (count($book_array) > 0)) {
    foreach ($book_array as $book)  {
      if ($color == "#cccccc") {
        $color = "#ffffff";
      } else {
        $color = "#cccccc";
      }
	  $bookID = $book[0];
	  $library_location = $book[1];
	  $title = $book[2];
	  $author = $book[3];	  
      //remember to call htmlspecialchars() when we are displaying user data
      echo "<tr bgcolor=\"".$color."\"><td><a href=\"".$bookID."\">".htmlspecialchars($bookID)."</a></td>";
	  echo "<td><a href=\"".$title."\">".htmlspecialchars($title)."</a></td>";
	  echo "<td><a href=\"".$author."\">".htmlspecialchars($author)."</a></td>";
	  
	  echo "<td><input type=\"checkbox\" name=\"arrival[]\"
			 value=\"".$bookID.'#'.$library_location."\"></td>";		
	  echo "</tr>";	  
    }
  } else {
    echo "<tr><td>No books to arrive.</td></tr>";
  }
?>
  </table>
  <button type="submit">Set books as arrived</button>
  </div>
  </form>
<?php
}
function display_user_menu()
{
  // display the menu options on this page
?>
<hr>
<a href="search_book_page.php">Search books</a> &nbsp;|&nbsp;
<a href="change_passwd_form.php">Change password</a><br>
<a href="logout.php">Logout</a>
<hr>

<?php
}
function display_borrow_book_form() 
{
?>
  <form method="post" action="admin_user_account_borrow_book.php">
  <div class="formblock">
    <h2>Borrow book for user:</h2>

    <p><label for="username">Username:</label><br/>
    <input type="text" name="borrower_username" id="borrower_username" /></p>

    <p><label for="passwd">Book ID:</label><br/>
    <input type="text" name="borrower_book_id" id="borrower_book_id" /></p>

    <button type="submit">Borrow book</button>
  </div>
 </form>
<?php
}
function display_user_reservations_form() {
?>
  <form method="post" action="admin_user_account_click_reservation.php">
  <div class="formblock">
    <h2>Get reservations for user:</h2>

    <p><label for="username">Username:</label><br/>
    <input type="text" name="username_for_reservation" id="username_for_reservation" /></p>

    <button type="submit">Get</button>
  </div>
 </form>
<?php
}
function display_user_reservations($book_array)
{
?>
  <br>
  <form name="user_reservation_books_table" method="post" action = "admin_user_account_reserve_books_for_user.php">
  <div>
  <table width="300" cellpadding="2" cellspacing="0">
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor=\"".$color."\"><td><strong>Book ID</strong></td>";
  echo "<td><strong>Title</strong></td>";
  echo "<td><strong>Author</strong></td>";
  echo "<td><strong>Library location</strong></td>";
  echo "<td><strong>Delivery status</strong></td>";
  echo "</tr>";
  if ((is_array($book_array)) && (count($book_array) > 0)) 
  {
   
    foreach ($book_array as $book)  {
      if ($color == "#cccccc") {
        $color = "#ffffff";
      } else {
        $color = "#cccccc";
      }
      $bookID = $book[0];
      $title = $book[1];
      $author = $book[2];
      $book_location = $book[3];
      $departed = $book[4];
      $arrived = $book[5];
      $arrival_date = $book[6];
      $arrival_location = $book[7];

      //remember to call htmlspecialchars() when we are displaying user data
      echo "<tr bgcolor=\"".$color."\"><td><a href=\"".$bookID."\">".htmlspecialchars($bookID)."</a></td>";
	  echo "<td><a href=\"".$title."\">".htmlspecialchars($title)."</a></td>";
	  echo "<td><a href=\"".$author."\">".htmlspecialchars($author)."</a></td>";
	  echo "<td><a href=\"".$book_location."\">".htmlspecialchars($book_location)."</a></td>";	  
	  if($departed && !$arrived)
		  echo "<td><a href=\"".$arrival_location."\">Departed to ".$arrival_location." libary</a></td>";
      else if($departed && $arrived)
	  {
		  echo "<td><a href=\"".$arrival_location."\">Arrived at ".$arrival_location." library</a></td>";
	      echo "<td><input type=\"checkbox\" name=\"reserve_books[]\";
			 value=\"".$bookID.'#'.$book_location."\"></td>";	
	  }
	  else 
		  echo  "<td><a href=\"".$arrival_location."\">Not yet departed</a></td>";
		  
    }
  } else {
    echo "<tr><td>Currently, you haven't borrowed any books.</td></tr>";
  }
  ?>
  </table>
  <button type="submit">Borrow reserved books</button>
  </div>
  </form>
<?php	
}
function display_search_record_form() 
{
?>
  <form method="post" action="admin_user_account_user_record.php">
  <div class="formblock">
    <h2>Search User Borrow Record:</h2>

    <p><label for="username">Username:</label><br/>
    <input type="text" name="record_username" id="record_username" /></p>
    <button type="submit">Search</button>
  </div>
 </form>
<?php
}
function display_borrow_record_with_fines($book_array)
{
?>
  <br>
  <form name="borrow_record_with_fines_table" method="post" action="admin_account_return_and_pay.php">
  <div class="formblock"> 
  <table width="300" cellpadding="2" cellspacing="0">
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor=\"".$color."\"><td><strong>Book ID</strong></td>";
  echo "<td><strong>Title</strong></td>";
  echo "<td><strong>Author</strong></td>";
  echo "<td><strong>Library location</strong></td>";
  echo "<td><strong>Due date</strong></td>";
  echo "<td><strong>Fine</strong></td>";
  echo "</tr>";
  if ((is_array($book_array)) && (count($book_array) > 0)) {
    foreach ($book_array as $book)  {
      if ($color == "#cccccc") {
        $color = "#ffffff";
      } else {
        $color = "#cccccc";
      }
	  $bookID = $book[0];
	  $library_location = $book[1];	  
	  $title = $book[2];
	  $author = $book[3];
	  $due_date = $book[4];
	  $fine = $book[5];
      //remember to call htmlspecialchars() when we are displaying user data
      echo "<tr bgcolor=\"".$color."\"><td><a href=\"".$bookID."\">".htmlspecialchars($bookID)."</a></td>";
      echo "<td><a href=\"".$title."\">".htmlspecialchars($title)."</a></td>";
      echo "<td><a href=\"".$author."\">".htmlspecialchars($author)."</a></td>";
      echo "<td><a href=\"".$library_location."\">".htmlspecialchars($library_location)."</a></td>";
      echo "<td><a href=\"".$due_date."\">".htmlspecialchars($due_date)."</a></td>";      
      echo "<td><a href=\"".$fine."\">".htmlspecialchars($fine)."</a></td>";    
      echo "<td><input type=\"checkbox\" name=\"pay_fine_and_return_book[]\"
		value=\"".$bookID.'#'.$library_location."\"></td>";	

      echo "</tr>";	  
    }
  } else {
    echo "<tr><td>No overdue books!</td></tr>";
  }
?>
  </table>
  <button type="submit">Return book and pay fines</button>
  </div>
  </form>
<?php
}
function display_borrow_record_without_fines($book_array)
{
?>
  <br>
  <form name="borrow_record_table" method="post" action="admin_account_return.php">
  <div class="formblock"> 
  <table width="300" cellpadding="2" cellspacing="0">
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor=\"".$color."\"><td><strong>Book ID</strong></td>";
  echo "<td><strong>Title</strong></td>";
  echo "<td><strong>Author</strong></td>";
  echo "<td><strong>Library location</strong></td>";
  echo "<td><strong>Due date</strong></td>";
  echo "</tr>";
  if ((is_array($book_array)) && (count($book_array) > 0)) {
    foreach ($book_array as $book)  {
      if ($color == "#cccccc") {
        $color = "#ffffff";
      } else {
        $color = "#cccccc";
      }
      $bookID = $book[0];
      $library_location = $book[1];	  
      $title = $book[2];
      $author = $book[3];
      $due_date = $book[4];
  //remember to call htmlspecialchars() when we are displaying user data
  echo "<tr bgcolor=\"".$color."\"><td><a href=\"".$bookID."\">".htmlspecialchars($bookID)."</a></td>";
      echo "<td><a href=\"".$title."\">".htmlspecialchars($title)."</a></td>";
      echo "<td><a href=\"".$author."\">".htmlspecialchars($author)."</a></td>";
      echo "<td><a href=\"".$library_location."\">".htmlspecialchars($library_location)."</a></td>";  
      echo "<td><a href=\"".$library_location."\">".htmlspecialchars($due_date)."</a></td>";  
      echo "<td><input type=\"checkbox\" name=\"return_book[]\"
		value=\"".$bookID.'#'.$library_location."\"></td>";	

      echo "</tr>";	  
    }
  } else {
    echo "<tr><td>No books to return without fines.</td></tr>";
  }
?>
  </table>
  <button type="submit">Return books</button>
  </div>
  </form>
<?php
}
function display_moving_books($book_array)
{
?>
  <br>
  <form name="moving_books_table" method="post" action = "admin_account_move_books_to_shelf.php">
  <div>
  <table width="300" cellpadding="2" cellspacing="0">
  <?php
  $color = "#cccccc";
  echo "<tr bgcolor=\"".$color."\"><td><strong>Book ID</strong></td>";
  echo "<td><strong>Title</strong></td>";
  echo "<td><strong>Author</strong></td>";
  echo "</tr>";
  if ((is_array($book_array)) && (count($book_array) > 0)) 
  {
   
    foreach ($book_array as $book)  {
      if ($color == "#cccccc") {
        $color = "#ffffff";
      } else {
        $color = "#cccccc";
      }
      $bookID = $book[0];
      $title = $book[1];
      $author = $book[2];
      //remember to call htmlspecialchars() when we are displaying user data
      echo "<tr bgcolor=\"".$color."\"><td><a href=\"".$bookID."\">".htmlspecialchars($bookID)."</a></td>";
      echo "<td><a href=\"".$title."\">".htmlspecialchars($title)."</a></td>";
      echo "<td><a href=\"".$author."\">".htmlspecialchars($author)."</a></td>";
      echo "<td><input type=\"checkbox\" name=\"move_book_to_shelf[]\";
		 value=\"".$bookID."\"></td>";	

		  
    }
  } else {
    echo "<tr><td>Currently, you haven't borrowed any books.</td></tr>";
  }
  ?>
  </table>
  <button type="submit">Tick books moved to shelf</button>
  </div>
  </form>
<?php
}
?>