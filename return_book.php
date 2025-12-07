<?php
session_start();
include('config.php');

// Check if user logged in
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_role = $_SESSION['role'];

// Only librarian allowed
if($user_role != 'librarian') {
    echo "<script>alert('Access denied! Only librarians can return books.'); window.location='view_books_table.php';</script>";
    exit();
}

if(isset($_GET['book_id'])) {
    $book_id = $_GET['book_id'];

    // Change status from reserved to available
    $query = "UPDATE books SET status='available' WHERE id='$book_id' AND status='reserved'";
    if(mysqli_query($conn, $query)) {
        echo "<script>alert('Book returned successfully and is now available.'); window.location='view_books_table.php';</script>";
    } else {
        echo "<script>alert('Error updating book status.'); window.location='view_books_table.php';</script>";
    }
}
?>
