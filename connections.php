<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}
 
$user_id = $_SESSION['user_id'];
 
// Fetch suggested connections (simple: all users except self and connected)
$sql_suggested = "SELECT u.id, u.name FROM users u WHERE u.id != $user_id AND u.id NOT IN (SELECT connected_user_id FROM connections WHERE user_id = $user_id AND status = 'accepted')";
$result_suggested = $conn->query($sql_suggested);
 
// Fetch pending requests
$sql_pending = "SELECT u.id, u.name FROM connections c JOIN users u ON c.user_id = u.id WHERE c.connected_user_id = $user_id AND c.status = 'pending'";
$result_pending = $conn->query($sql_pending);
 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['connect'])) {
        $connect_id = $_POST['connect'];
        $sql = "INSERT INTO connections (user_id, connected_user_id) VALUES ($user_id, $connect_id)";
        $conn->query($sql);
    } elseif (isset($_POST['accept'])) {
        $accept_id = $_POST['accept'];
        $sql = "UPDATE connections SET status = 'accepted' WHERE user_id = $accept_id AND connected_user_id = $user_id";
        $conn->query($sql);
    }
    echo '<script>window.location.href = "connections.php";</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Connections - LinkedIn Clone</title>
    <style>
        /* Internal CSS - List-based networking UI */
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f3f2ef; margin: 0; padding: 0; color: #333; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        ul { list-style-type: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #ccc; display: flex; justify-content: space-between; align-items: center; }
        button { background-color: #0073b1; color: white; padding: 5px 10px; border: none; border-radius: 4px; cursor: pointer; }
        button:hover { background-color: #005582; }
        @media (max-width: 600px) { .container { margin: 10px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Suggested Connections</h2>
        <ul>
            <?php while($row = $result_suggested->fetch_assoc()) { ?>
                <li><?php echo $row['name']; ?> <form method="post" style="display:inline;"><input type="hidden" name="connect" value="<?php echo $row['id']; ?>"><button type="submit">Connect</button></form></li>
            <?php } ?>
        </ul>
        <h2>Pending Requests</h2>
        <ul>
            <?php while($row = $result_pending->fetch_assoc()) { ?>
                <li><?php echo $row['name']; ?> <form method="post" style="display:inline;"><input type="hidden" name="accept" value="<?php echo $row['id']; ?>"><button type="submit">Accept</button></form></li>
            <?php } ?>
        </ul>
    </div>
</body>
</html>
