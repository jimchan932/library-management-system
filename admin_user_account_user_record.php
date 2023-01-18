<?php
	require_once('library_functions.php');
	session_start();
	$_SESSION['record_username'] = $_POST['record_username'];
	do_html_header('<strong>'.$_SESSION['location'].' library administatror</strong><br/>Home');
	$currentDate = date('Y-m-d');
	echo $currentDate."<br/>";
	check_valid_admin_user();
	$book_array = get_reserved_books($_POST['record_username']);

        display_user_reservations($book_array);
	echo "<br/><strong>Borrow book record</strong>";
	$book_array_without_fines = get_user_borrow_record_without_fines($_POST['record_username']);
	display_borrow_record_without_fines($book_array_without_fines);

	echo "<br/><strong>Overdue borrow book record</strong>";
	$book_array_with_fines = get_user_borrow_record_with_fines($_POST['record_username']);	
	display_borrow_record_with_fines($book_array_with_fines);
?>