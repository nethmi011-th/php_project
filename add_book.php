<?php

session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'librarian') {
    die("Access Denied! Librarian only.");
}

require 'config.php';
$errors = [];
$title = $author = $publisher = $category = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $publisher = trim($_POST['publisher'] ?? '');
    $category = trim($_POST['category'] ?? 'Uncategorized');
    $status = 'Available';

    if ($title === '') $errors[] = 'Title is required.';
    if ($author === '') $errors[] = 'Author is required.';


    if(!empty($_FILES['image']['name'])) {
    // Image upload handling
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
            $errors[] = 'Image upload error.';
        } else {
            $allowed = ['jpg','jpeg','png','gif'];
            $fileName = $_FILES['image']['name'];
            $fileTmp  = $_FILES['image']['tmp_name'];
            $fileExt  = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (!in_array($fileExt, $allowed)) {
                $errors[] = 'Only JPG, PNG, GIF are allowed for images.';
            } else {
                $targetDir = 'uploads/';
                if (!is_dir($targetDir)) mkdir($targetDir, 0755, true);
                $newName = uniqid('book_', true) . '.' . $fileExt;
                $dest = $targetDir . $newName;
                if (!move_uploaded_file($fileTmp, $dest)) {
                    $errors[] = 'Failed to move uploaded file.';
                } else {
                    $imagePath = $dest;
                }
            }
        }
    }
  }
    else {$imagePath = "uploads/default_book.jpg";
    }

    if (empty($errors)) {
        $stmt = mysqli_prepare($conn, "INSERT INTO books (title, author, publisher, category, status, image) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, 'ssssss', $title, $author, $publisher, $category, $status, $imagePath);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: view_books_table.php');
            exit;
        } else {
            $errors[] = 'Database error: ' . mysqli_error($conn);
        }
    }
}
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Add Book</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container alert alert-success">
    <h2>Add New Book</h2>

    <?php if (!empty($errors)): ?>
      <div class="alert alert-danger">
        <?php foreach($errors as $e) echo "<div>".htmlspecialchars($e)."</div>"; ?>
      </div>
    <?php endif; ?>

    <a href ="logout.php">Logout</a>

    <form method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label">Title *</label>
        <input class="form-control" name="title" value="<?=htmlspecialchars($title)?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Author *</label>
        <input class="form-control" name="author" value="<?=htmlspecialchars($author)?>" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Publisher</label>
        <input class="form-control" name="publisher" value="<?=htmlspecialchars($publisher)?>">
        <div class="form-text">e.g. Sathara, Wijaya, Ahasa</div>
      </div>

      <div class="mb-3">
        <label class="form-label">Category</label>
        <input class="form-control" name="category" value="<?=htmlspecialchars($category)?>">
        <div class="form-text">e.g. Novel, Bibliography, Science</div>
      </div>

      <div class="mb-3">
        <label class="form-label">Cover Image (optional)</label>
        <input class="form-control" type="file" name="image" accept="image/*">
      </div>

      <button class="btn btn-primary">Add Book</button>
      <a class="btn btn-secondary" href="view_books_grid.php">View Grid</a>
      <a class="btn btn-secondary" href="view_books_table.php">Manage (Table)</a>
    </form>
  </div>
</body>
</html>