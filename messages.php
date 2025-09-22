<?php
include 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}
 
$user_id = $_SESSION['user_id'];
 
// Fetch connections for messaging (only accepted)
$sql_connections = "SELECT u.id, u.name FROM connections c JOIN users u ON c.connected_user_id = u.id WHERE c.user_id = $user_id AND c.status = 'accepted'";
$result_connections = $conn->query($sql_connections);
 
// Fetch messages (example for a selected user)
$selected_user = isset($_GET['user']) ? $_GET['user'] : null;
$messages = [];
if ($selected_user) {
    $sql_messages = "SELECT m.*, u.name AS sender_name FROM messages m JOIN users u ON m.sender_id = u.id WHERE 
        (m.sender_id = $user_id AND m.receiver_id = $selected_user) OR 
        (m.sender_id = $selected_user AND m.receiver_id = $user_id) 
        ORDER BY m.sent_at ASC";
    $result_messages = $conn->query($sql_messages);
    while($row = $result_messages->fetch_assoc()) {
        $messages[] = $row;
    }
}
 
if ($_SERVER["REQUEST_METHOD"] == "POST" && $selected_user) {
    $content = $_POST['content'];
    $sql = "INSERT INTO messages (sender_id, receiver_id, content) VALUES ($user_id, $selected_user, '$content')";
    $conn->query($sql);
    echo '<script>window.location.href = "messages.php?user=' . $selected_user . '";</script>';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Messages - LinkedIn Clone</title>
    <style>
        /* Internal CSS - Chat-like interface */
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f3f2ef; margin: 0; padding: 0; color: #333; }
        .container { max-width: 800px; margin: 20px auto; display: flex; }
        .sidebar { width: 30%; background: white; padding: 20px; border-radius: 8px 0 0 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .chat { width: 70%; background: white; padding: 20px; border-radius: 0 8px 8px 0; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        ul { list-style-type: none; padding: 0; }
        li { padding: 10px; border-bottom: 1px solid #ccc; cursor: pointer; }
        li:hover { background: #e7e7e7; }
        .message { padding: 10px; margin-bottom: 10px; border-radius: 4px; }
        .sent { background: #0073b1; color: white; align-self: flex-end; }
        .received { background: #e7e7e7; }
        form { display: flex; margin-top: 10px; }
        input { flex: 1; padding: 10px; border: 1px solid #ccc; border-radius: 4px 0 0 4px; }
        button { background-color: #0073b1; color: white; padding: 10px; border: none; border-radius: 0 4px 4px 0; cursor: pointer; }
        button:hover { background-color: #005582; }
        @media (max-width: 600px) { .container { flex-direction: column; } .sidebar, .chat { width: 100%; border-radius: 8px; margin-bottom: 10px; } }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h3>Connections</h3>
            <ul>
                <?php while($row = $result_connections->fetch_assoc()) { ?>
                    <li onclick="window.location.href='messages.php?user=<?php echo $row['id']; ?>'"><?php echo $row['name']; ?></li>
                <?php } ?>
            </ul>
        </div>
        <div class="chat">
            <?php if ($selected_user) { ?>
                <h3>Chat with Selected User</h3>
                <?php foreach($messages as $msg) { ?>
                    <div class="message <?php echo $msg['sender_id'] == $user_id ? 'sent' : 'received'; ?>">
                        <strong><?php echo $msg['sender_name']; ?>:</strong> <?php echo $msg['content']; ?>
                    </div>
                <?php } ?>
                <form method="post">
                    <input type="text" name="content" placeholder="Type a message..." required>
                    <button type="submit">Send</button>
                </form>
            <?php } else { ?>
                <p>Select a connection to start messaging.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
