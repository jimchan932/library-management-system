<?php
	require_once("library_functions.php");
	session_start();
	$choice = $_POST['choice'];
	$keyword = $_POST['keyword'];
	$book_array = get_searched_books($keyword, $choice);
	display_searched_books($book_array);
	display_user_menu();
?>