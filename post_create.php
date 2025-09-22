<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO posts (user_id, content) VALUES ($user_id, '$content')";
    $conn->query($sql);
    echo '<script>window.location.href = "index.php";</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Create Post - LinkedIn Clone</title>
    <style>
        /* Internal CSS - Simple post form */
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f3f2ef; margin: 0; padding: 0; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        textarea { width: 100%; height: 150px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; }
        button { background-color: #0073b1; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; margin-top: 10px; }
        button:hover { background-color: #005582; }
        @media (max-width: 600px) { .container { margin: 10px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Create Post</h2>
        <form method="post">
            <textarea name="content" placeholder="Share your thoughts..." required></textarea>
            <button type="submit">Post</button>
        </form>
    </div>
</body>
</html>
