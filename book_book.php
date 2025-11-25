<?php
require 'config.php';
session_start();

// Placeholder for logged-in member
$student = $_SESSION['username'];

if (isset($_GET['book_id'])) {
    $book_id = intval($_GET['book_id']);

    // 1. Count how many books the member has already reserved
    $count_stmt = mysqli_prepare($conn, "SELECT COUNT(*) as total FROM books WHERE booked_by=? AND status='Not Available'");
    mysqli_stmt_bind_param($count_stmt, 's', $student);
    mysqli_stmt_execute($count_stmt);
    $count_result = mysqli_stmt_get_result($count_stmt);
    $count_row = mysqli_fetch_assoc($count_result);

    if ($count_row['total'] >= 2) {
        // Member already has 2 books reserved
        echo "<script>alert('You cannot reserve more than 2 books at a time.'); window.location.href='view_books_grid.php';</script>";
        exit;
    }

    // 2. Check if the selected book is still available
    $check = mysqli_prepare($conn, "SELECT status FROM books WHERE book_id=?");
    mysqli_stmt_bind_param($check, 'i', $book_id);
    mysqli_stmt_execute($check);
    $result = mysqli_stmt_get_result($check);
    $book = mysqli_fetch_assoc($result);

    if ($book && $book['status'] === 'Available') {
        // Update to Not Available and record booked_by
        $stmt = mysqli_prepare($conn, "UPDATE books SET status='Not Available', booked_by=? WHERE book_id=?");
        mysqli_stmt_bind_param($stmt, 'si', $student, $book_id);
        mysqli_stmt_execute($stmt);
    } else {
        echo "<script>alert('Sorry, this book is not available.'); window.location.href='view_books_grid.php';</script>";
        exit;
    }
}

header("Location: view_books_grid.php");
exit;
?>
