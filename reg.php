<!DOCTYPE html>
<html>
<head>
    
    <title>Sign up</title>
</head>
<link rel="stylesheet" href="styles.css">
<body>
    <noscript>
        <div style="text-align: center; padding: 20px; background-color: #850de7; color: white;">
            JavaScript must be enabled to use this website. Please enable JavaScript in your browser settings.
        </div>
    </noscript>
    <br>
    <br>    
    <br>    
    <br>    
    <br>
    <center>
    <h1>Register</h1><br>
    
    <form id="loginForm" action="registration.php" method="post">
        <label for="uname">Username:</label><br>
        <input type="text" id="uname" name="uname" required ><br><br>
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label><br>
        <input type="password" id="password" required minlength="6"><br>
    
        <input type="hidden" id="hashedPassword" name="hashedPassword"><br>
        <button type="submit">Login</button>
    </form>
    </center>
    <?php
    // Check if JavaScript is enabled
    echo "<script>document.cookie = 'js_enabled=true';</script>";
    ?>
    
    <?php if (isset($_COOKIE['js_enabled']) && $_COOKIE['js_enabled'] == 'true'): ?>
        <!-- JavaScript is enabled, execute JavaScript code -->
        <script src="hash.js"></script>
    <?php else: ?>
        <!-- JavaScript is not enabled, execute PHP code -->
        <?php
        // Your PHP code here
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["password"])) {
            $password = $_POST["password"];
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            echo '<input type="hidden" id="hashedPassword" name="hashedPassword" value="' . htmlspecialchars($hashedPassword) . '"><br>';
        }
        ?>
    <?php endif; ?>
   
</body>
</html>
