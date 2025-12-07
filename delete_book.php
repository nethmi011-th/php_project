<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = intval($_POST['book_id'] ?? 0);
    if ($book_id > 0) {
        // get image path
        $stmt = mysqli_prepare($conn, "SELECT image FROM books WHERE book_id = ?");
        mysqli_stmt_bind_param($stmt, 'i', $book_id);
        mysqli_stmt_execute($stmt);
        $res = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($res);
        if ($row && !empty($row['image']) && file_exists($row['image'])) {
            @unlink($row['image']);
        }

        $stmtDel = mysqli_prepare($conn, "DELETE FROM books WHERE book_id = ?");
        mysqli_stmt_bind_param($stmtDel, 'i', $book_id);
        mysqli_stmt_execute($stmtDel);
    }
}

header('Location: view_books_table.php');
exit;
?>