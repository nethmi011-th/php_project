<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // secure hash
    $role = $_POST['role']; // 'librarian' or 'student'

    $sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $password, $role);

    if ($stmt->execute()) {
        echo "User registered successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!-- Include Bootstrap CSS in your <head> -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Register form -->
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="mb-4 text-center">Register</h2>
    <form method="post">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="role" class="form-label">Role</label>
            <select class="form-select" id="role" name="role">
                <option value="student">Student</option>
                <option value="librarian">Librarian</option>
                <option value="admin">Admin</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>
</div>
  