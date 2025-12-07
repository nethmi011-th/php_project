<a href ="logout.php">Logout</a> 	 	
<?php
session_start();
require 'config.php';
$res = mysqli_query($conn, "SELECT * FROM books ORDER BY created_at DESC");
$books = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Books - Grid</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .card-img-top { height: 250px; object-fit: cover; }
  </style>
</head>
<body class="p-4">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h2>Books</h2>
      <div>
        <a class="btn btn-success me-2" href="add_book.php">Add Book</a>
        <a class="btn btn-secondary" href="view_books_table.php">Manage (Table)</a>
      </div>
    </div>

    <div class="row">
      <?php if (empty($books)): ?>
        <div class="col-12"><div class="alert alert-info">No books found. Add one.</div></div>
      <?php endif; ?>

      <?php foreach($books as $book): ?>
        <div class="col-md-3 mb-4">
          <div class="card h-100">
            <?php if (!empty($book['image']) && file_exists($book['image'])): ?>
              <img src="<?=htmlspecialchars($book['image'])?>" class="card-img-top" alt="">
            <?php else: ?>
              <img src="https://via.placeholder.com/300x250?text=No+Image" class="card-img-top" alt="">
            <?php endif; ?>

            <div class="card-body">
              <h5 class="card-title"><?=htmlspecialchars($book['title'])?></h5>
              <p class="card-text"><strong>Author:</strong> <?=htmlspecialchars($book['author'])?></p>
			  <p class="card-text"><small class="text-muted"><?=htmlspecialchars($book['category'])?> • <?=htmlspecialchars($book['status'])?></small></p>
			  <p class="card-text"><strong>Publisher:</strong> <?=htmlspecialchars($book['publisher'])?></p>
            </div>
			<!-- ✅ Show status -->
              <p class="card-text">
                <small class="text-muted">
                  <?=htmlspecialchars($book['category'])?> • 
                  <strong class="<?=($book['status']==='Available') ? 'text-success' : 'text-danger'?>">
                    <?=htmlspecialchars($book['status'])?>
                  </strong>
                </small>
              </p>
			  <!-- ✅ Show Book It button only if Available -->
              <?php if ($book['status'] === 'Available'): ?>
                <a href="book_book.php?book_id=<?=intval($book['book_id'])?>" 
                   class="btn btn-primary btn-sm">Book It</a>
              <?php else: ?>
                <button class="btn btn-secondary btn-sm" disabled>Not Available</button>
              <?php endif; ?>
			
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>