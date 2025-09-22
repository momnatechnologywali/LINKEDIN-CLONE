<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}
 
$user_id = $_SESSION['user_id'];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_title = $_POST['job_title'];
    $summary = $_POST['summary'];
    // Handle profile pic upload (simplified, no real upload here)
    $profile_pic = 'default.jpg'; // Placeholder
 
    $sql = "UPDATE users SET job_title='$job_title', summary='$summary', profile_pic='$profile_pic' WHERE id=$user_id";
    $conn->query($sql);
 
    // Add education (example, can add multiple via form)
    if (isset($_POST['school'])) {
        $school = $_POST['school'];
        $degree = $_POST['degree'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];
        $sql_edu = "INSERT INTO education (user_id, school, degree, start_date, end_date) VALUES ($user_id, '$school', '$degree', '$start_date', '$end_date')";
        $conn->query($sql_edu);
    }
 
    // Similar for experience and skills
 
    echo '<script>window.location.href = "profile.php";</script>';
}
 
$sql_user = "SELECT * FROM users WHERE id = $user_id";
$user = $conn->query($sql_user)->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit Profile - LinkedIn Clone</title>
    <style>
        /* Internal CSS - Form-focused, clean design */
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f3f2ef; margin: 0; padding: 0; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        form { display: flex; flex-direction: column; }
        label { margin-bottom: 5px; font-weight: bold; }
        input, textarea { margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; }
        button { background-color: #0073b1; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #005582; }
        @media (max-width: 600px) { .container { margin: 10px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit Profile</h2>
        <form method="post">
            <label>Job Title:</label>
            <input type="text" name="job_title" value="<?php echo $user['job_title']; ?>">
            <label>Summary:</label>
            <textarea name="summary"><?php echo $user['summary']; ?></textarea>
            <!-- Add sections for education, experience, skills -->
            <h3>Add Education</h3>
            <label>School:</label>
            <input type="text" name="school">
            <label>Degree:</label>
            <input type="text" name="degree">
            <label>Start Date:</label>
            <input type="date" name="start_date">
            <label>End Date:</label>
            <input type="date" name="end_date">
            <!-- Repeat for experience and skills as needed -->
            <button type="submit">Save</button>
        </form>
    </div>
</body>
</html>
