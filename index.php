<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}
 
// Fetch posts
$sql_posts = "SELECT p.*, u.name FROM posts p JOIN users u ON p.user_id = u.id ORDER BY p.created_at DESC LIMIT 10";
$result_posts = $conn->query($sql_posts);
 
// Fetch jobs
$sql_jobs = "SELECT j.*, u.name FROM jobs j JOIN users u ON j.user_id = u.id ORDER BY j.created_at DESC LIMIT 10";
$result_jobs = $conn->query($sql_jobs);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Homepage - LinkedIn Clone</title>
    <style>
        /* Internal CSS - Real LinkedIn-like, professional, engaging */
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f3f2ef; margin: 0; padding: 0; color: #333; }
        header { background: #0073b1; color: white; padding: 10px; text-align: center; }
        .nav { display: flex; justify-content: space-around; max-width: 800px; margin: auto; }
        .nav a { color: white; text-decoration: none; }
        .section { max-width: 800px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .post, .job { border-bottom: 1px solid #ccc; padding: 10px; margin-bottom: 10px; }
        .post:last-child, .job:last-child { border-bottom: none; }
        h3 { color: #0073b1; }
        .like-btn, .comment-btn { background: #e7e7e7; border: none; padding: 5px 10px; cursor: pointer; margin-right: 5px; }
        .like-btn:hover, .comment-btn:hover { background: #d0d0d0; }
        @media (max-width: 600px) { .section { margin: 10px; padding: 15px; } .nav { flex-direction: column; } }
    </style>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo $_SESSION['name']; ?></h1>
        <div class="nav">
            <a href="profile.php">Profile</a>
            <a href="connections.php">Connections</a>
            <a href="post_create.php">Create Post</a>
            <a href="job_create.php">Post Job</a>
            <a href="messages.php">Messages</a>
            <a href="logout.php">Logout</a>
        </div>
    </header>
    <div class="section">
        <h3>Recent Posts</h3>
        <?php while($row = $result_posts->fetch_assoc()) { ?>
            <div class="post">
                <p><strong><?php echo $row['name']; ?>:</strong> <?php echo $row['content']; ?></p>
                <button class="like-btn" onclick="likePost(<?php echo $row['id']; ?>)">Like</button>
                <button class="comment-btn" onclick="commentPost(<?php echo $row['id']; ?>)">Comment</button>
            </div>
        <?php } ?>
    </div>
    <div class="section">
        <h3>Job Postings</h3>
        <?php while($row = $result_jobs->fetch_assoc()) { ?>
            <div class="job">
                <p><strong><?php echo $row['title']; ?></strong> by <?php echo $row['name']; ?></p>
                <p><?php echo $row['description']; ?></p>
                <button onclick="applyJob(<?php echo $row['id']; ?>)">Apply</button>
            </div>
        <?php } ?>
    </div>
    <script>
        // JS for interactions and redirection (no PHP redirect here)
        function likePost(postId) {
            alert('Liked post ' + postId);
            // AJAX can be added for real like, but simplified
        }
        function commentPost(postId) {
            let comment = prompt('Enter comment:');
            if (comment) alert('Commented on post ' + postId);
        }
        function applyJob(jobId) {
            alert('Applied to job ' + jobId);
            // Redirect example
            // window.location.href = 'apply.php?job=' + jobId;
        }
    </script>
</body>
</html>
