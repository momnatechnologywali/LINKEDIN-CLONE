<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
 
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    if ($conn->query($sql) === TRUE) {
        echo '<script>window.location.href = "login.php";</script>';
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Sign Up - LinkedIn Clone</title>
    <style>
        /* Internal CSS - Professional, clean, real-looking design */
        body { font-family: 'Helvetica Neue', Arial, sans-serif; background-color: #f3f2ef; margin: 0; padding: 0; color: #333; }
        .container { max-width: 400px; margin: 50px auto; padding: 20px; background: white; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h2 { text-align: center; color: #0073b1; }
        form { display: flex; flex-direction: column; }
        label { margin-bottom: 5px; font-weight: bold; }
        input { margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; }
        button { background-color: #0073b1; color: white; padding: 10px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #005582; }
        @media (max-width: 600px) { .container { margin: 20px; padding: 15px; } }
    </style>
</head>
<body>
    <div class="container">
        <h2>Sign Up</h2>
        <form method="post">
            <label>Name:</label>
            <input type="text" name="name" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <button type="submit">Sign Up</button>
        </form>
    </div>
    <script>
        // JS for basic validation (no separate file)
        document.querySelector('form').addEventListener('submit', function(e) {
            if (document.querySelector('input[name="password"]').value.length < 6) {
                alert('Password must be at least 6 characters');
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
