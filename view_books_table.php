<?php


require 'config.php';
$res = mysqli_query($conn, "SELECT * FROM books ORDER BY created_at DESC");
$books = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Manage Books</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"> 
  <style> img.thumb { width: 60px; height: 80px; object-fit: cover; } </style>
</head>
<body class="p-4">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Manage Books</h2>
      <div>
        <a class="btn btn-success me-2" href="add_book.php">Add Book</a>
        <a class="btn btn-secondary" href="view_books_grid.php">View Grid</a>
      </div>
    </div>

    <table class="table table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Cover</th>
          <th>Title</th>
          <th>Author</th>
          <th>Category</th>
		  <th>Publisher</th>
          <th>Status</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($books as $b): ?>
        <tr>
          <td><?=htmlspecialchars($b['book_id'])?></td>
          <td>
            <?php if (!empty($b['image']) && file_exists($b['image'])): ?>
              <img src="<?=htmlspecialchars($b['image'])?>" class="thumb" alt="">
            <?php else: ?>
              <img src="https://via.placeholder.com/60x80?text=no" class="thumb" alt="">
            <?php endif; ?>
          </td>
          <td><?=htmlspecialchars($b['title'])?></td>
          <td><?=htmlspecialchars($b['author'])?></td>
          <td><?=htmlspecialchars($b['category'])?></td>
		  <td><?=htmlspecialchars($b['publisher'])?></td>
          <td><?=htmlspecialchars($b['status'])?></td>
          <td>
           <a class="btn btn-sm btn-primary" href="update_book.php?book_id=<?=intval($b['book_id'])?>"><i class="bi bi-pencil-square"></i> </a>

            <form method="post" action="delete_book.php" style="display:inline-block" onsubmit="return confirm('Delete this book?');">
              <input type="hidden" name="book_id" value="<?=intval($b['book_id'])?>">
              <button class="btn btn-sm btn-danger"><i class="bi bi-trash"></i> </button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</body>
</html>