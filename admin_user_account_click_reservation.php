<?php
require_once('library_functions.php');
session_start();
do_html_header('<strong>'.$_SESSION['location'].' library administatror</strong><br/>Home');
$currentDate = date('Y-m-d');
echo $currentDate."<br/>";
check_valid_admin_user();

$_SESSION['reservation_user'] = $_POST['username_for_reservation'];
$book_array = get_reserved_books($_SESSION['reservation_user']);

display_user_reservations($book_array);
?>