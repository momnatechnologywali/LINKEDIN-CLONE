<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}
 
$user_id = $_SESSION['user_id'];
$sql_user = "SELECT * FROM users WHERE id = $user_id";
$result_user = $conn->query($sql_user);
$user = $result_user->fetch_assoc();
 
// Fetch education, experience, skills
$sql_edu = "SELECT * FROM education WHERE user_id = $user_id";
$result_edu = $conn->query($sql_edu);
 
$sql_exp = "SELECT * FROM experience WHERE user_id = $user_id";
$result_exp = $conn->query($sql_exp);
 
$sql_skills = "SELECT * FROM skills WHERE user_id = $user_id";
$result_skills = $conn->query($sql_skills);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Profile - LinkedIn Clone</title>
    <style>
        /* Internal CSS - Sleek, professional profile layout */
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f3f2ef; margin: 0; padding: 0; color: #333; }
        .profile-container { max-width: 800px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .header { background: #0073b1; color: white; padding: 20px; border-radius: 8px 8px 0 0; text-align: center; }
        .section { margin-top: 20px; }
        ul { list-style-type: none; padding: 0; }
        li { margin-bottom: 10px; }
        button { background-color: #0073b1; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #005582; }
        @media (max-width: 600px) { .profile-container { margin: 10px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="profile-container">
        <div class="header">
            <h1><?php echo $user['name']; ?></h1>
            <p><?php echo $user['job_title']; ?></p>
            <p><?php echo $user['summary']; ?></p>
            <img src="<?php echo $user['profile_pic']; ?>" alt="Profile Pic" style="width: 100px; height: 100px; border-radius: 50%;">
        </div>
        <div class="section">
            <h3>Education</h3>
            <ul>
                <?php while($row = $result_edu->fetch_assoc()) { ?>
                    <li><?php echo $row['degree']; ?> from <?php echo $row['school']; ?> (<?php echo $row['start_date']; ?> - <?php echo $row['end_date']; ?>)</li>
                <?php } ?>
            </ul>
        </div>
        <div class="section">
            <h3>Experience</h3>
            <ul>
                <?php while($row = $result_exp->fetch_assoc()) { ?>
                    <li><?php echo $row['position']; ?> at <?php echo $row['company']; ?> (<?php echo $row['start_date']; ?> - <?php echo $row['end_date']; ?>)</li>
                <?php } ?>
            </ul>
        </div>
        <div class="section">
            <h3>Skills</h3>
            <ul>
                <?php while($row = $result_skills->fetch_assoc()) { ?>
                    <li><?php echo $row['skill']; ?></li>
                <?php } ?>
            </ul>
        </div>
        <button onclick="editProfile()">Edit Profile</button>
    </div>
    <script>
        function editProfile() {
            window.location.href = "edit_profile.php";
        }
    </script>
</body>
</html>
