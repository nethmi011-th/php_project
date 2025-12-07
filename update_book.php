<?php
session_start();
require 'config.php';
$errors = [];

// --- 1️⃣ Role-based access control ---
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'librarian') {
    die('Access denied. Only librarians can update book status.');
}

// --- Fetch book for GET request ---
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (!isset($_GET['book_id'])) die('No book id.');
    $book_id = intval($_GET['book_id']);
    $stmt = mysqli_prepare($conn, "SELECT * FROM books WHERE book_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $book_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $book = mysqli_fetch_assoc($res);
    if (!$book) die('Book not found.');
} else {
    // --- POST - perform update ---
    $book_id = intval($_POST['book_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $publisher = trim($_POST['publisher'] ?? '');
    $category = trim($_POST['category'] ?? 'Uncategorized');
    $status = in_array($_POST['status'] ?? 'Available', ['Available','Borrowed','Reserved']) ? $_POST['status'] : 'Available';

    if ($title === '') $errors[] = 'Title required.';
    if ($author === '') $errors[] = 'Author required.';

    // --- fetch old image ---
    $stmt = mysqli_prepare($conn, "SELECT image FROM books WHERE book_id = ?");
    mysqli_stmt_bind_param($stmt, 'i', $book_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($res);
    $oldImage = $row['image'] ?? null;
    $imagePath = $oldImage;

    // --- image upload (optional) ---
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Image upload error.';
        } else {
            $allowed = ['jpg','jpeg','png','gif'];
            $fileName = $_FILES['image']['name'];
            $fileTmp  = $_FILES['image']['tmp_name'];
            $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExt, $allowed)) {
                $errors[] = 'Only JPG, PNG, GIF allowed.';
            } else {
                $targetDir = 'uploads/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
                $newName = uniqid('book_', true) . '.' . $fileExt;
                $dest = $targetDir . $newName;
                if (!move_uploaded_file($fileTmp, $dest)) {
                    $errors[] = 'Failed to move uploaded file.';
                } else {
                    if ($oldImage && file_exists($oldImage)) @unlink($oldImage);
                    $imagePath = $dest;
                }
            }
        }
    }

    // --- 2️⃣ Handle reserved book return ---
    if (isset($_POST['return_book']) && $_POST['return_book'] == '1') {
        $status = 'Available';
    }

    // --- update database ---
    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "UPDATE books SET title=?, author=?, publisher=?, category=?, status=?, image=? WHERE book_id=?");
        mysqli_stmt_bind_param($stmt, 'ssssssi', $title, $author, $publisher, $category, $status, $imagePath, $book_id);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: view_books_table.php');
            exit;
        } else {
            $errors[] = 'DB update error: ' . mysqli_error($conn);
        }
    }

    // --- re-fetch for showing values ---
    $book = ['book_id'=>$book_id, 'title'=>$title,'author'=>$author,'publisher'=>$publisher,'category'=>$category,'status'=>$status,'image'=>$imagePath];
}
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Update Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2>Update Book</h2>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <?php foreach($errors as $e) echo "<div>".htmlspecialchars($e)."</div>"; ?>
      </div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">
      <input type="hidden" name="book_id" value="<?=intval($book['book_id'])?>">

      <div class="mb-3">
        <label class="form-label">Title *</label>
        <input class="form-control" name="title" value="<?=htmlspecialchars($book['title'])?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Author *</label>
        <input class="form-control" name="author" value="<?=htmlspecialchars($book['author'])?>" required>
      </div>

      <div class="mb-3"> 
        <label class="form-label">Publisher</label> 
        <input type="text" class="form-control" name="publisher" value="<?=htmlspecialchars($book['publisher'])?>" required> 
      </div> 

      <div class="mb-3">
        <label class="form-label">Category</label>
        <input class="form-control" name="category" value="<?=htmlspecialchars($book['category'])?>">
      </div>

      <div class="mb-3">
        <label class="form-label">Status</label>
        <select class="form-select" name="status">
          <option value="Available" <?=($book['status']=='Available')?'selected':''?>>Available</option>
          <option value="Borrowed" <?=($book['status']=='Borrowed')?'selected':''?>>Borrowed</option>
          <option value="Reserved" <?=($book['status']=='Reserved')?'selected':''?>>Reserved</option>
        </select>
      </div>

      <!-- ✅ Reserved book return checkbox -->
      <div class="mb-3 form-check">
        <input type="checkbox" class="form-check-input" name="return_book" value="1" id="returnBook">
        <label class="form-check-label" for="returnBook">Mark as returned (make Available)</label>
      </div>

      <div class="mb-3">
        <label class="form-label">Cover Image (leave empty to keep current)</label>
        <input class="form-control" type="file" name="image" accept="image/*">
        <?php if (!empty($book['image']) && file_exists($book['image'])): ?>
          <div class="mt-2">
            <img src="<?=htmlspecialchars($book['image'])?>" style="width:120px;height:auto;object-fit:cover;">
          </div>
        <?php endif; ?>
      </div>

      <button class="btn btn-primary">Update Book</button>
      <a class="btn btn-secondary" href="view_books_table.php">Back</a>
    </form>
  </div>
</body>
</html>
