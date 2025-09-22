<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $location = $_POST['location'];
    $industry = $_POST['industry'];
    $experience_level = $_POST['experience_level'];
    $user_id = $_SESSION['user_id'];
    $sql = "INSERT INTO jobs (user_id, title, description, location, industry, experience_level) VALUES ($user_id, '$title', '$description', '$location', '$industry', '$experience_level')";
    $conn->query($sql);
    echo '<script>window.location.href = "index.php";</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Post Job - LinkedIn Clone</title>
    <style>
        /* Internal CSS - Job form design */
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f3f2ef; margin: 0; padding: 0; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        form { display: flex; flex-direction: column; }
        label { margin-bottom: 5px; font-weight: bold; }
        input, textarea, select { margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; }
        button { background-color: #0073b1; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #005582; }
        @media (max-width: 600px) { .container { margin: 10px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Post a Job</h2>
        <form method="post">
            <label>Title:</label>
            <input type="text" name="title" required>
            <label>Description:</label>
            <textarea name="description" required></textarea>
            <label>Location:</label>
            <input type="text" name="location">
            <label>Industry:</label>
            <input type="text" name="industry">
            <label>Experience Level:</label>
            <select name="experience_level">
                <option value="entry">Entry</option>
                <option value="mid">Mid</option>
                <option value="senior">Senior</option>
            </select>
            <button type="submit">Post Job</button>
        </form>
    </div>
</body>
</html>
