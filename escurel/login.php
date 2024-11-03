<?php
session_start();
require_once 'core/models.php';
require_once 'core/dbConfig.php';

// Display any session message if available
$message = $_SESSION['message'] ?? '';
unset($_SESSION['message']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Manage your bar! - Login</title>
   <style>
       body {
           font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
           background-color: #121212;
           color: #e0e0e0;
           display: flex;
           justify-content: center;
           align-items: center;
           height: 100vh;
           margin: 0;
       }
       .container {
           background-color: #1e1e1e;
           padding: 30px;
           border-radius: 10px;
           box-shadow: 0 8px 16px rgba(0, 0, 0, 0.5);
           width: 100%;
           max-width: 400px;
           text-align: center;
       }
       h1 {
           color: #ffffff;
           margin-bottom: 10px;
           font-size: 24px;
       }
       h2 {
           color: #b3b3b3;
           margin-bottom: 20px;
           font-size: 18px;
       }
       .message {
           color: #e57373;
           font-size: 16px;
           margin-bottom: 15px;
       }
       form {
           display: flex;
           flex-direction: column;
           gap: 15px;
           margin-top: 20px;
       }
       label {
           text-align: left;
           color: #b3b3b3;
           font-weight: bold;
       }
       input[type="text"],
       input[type="password"] {
           padding: 12px;
           font-size: 16px;
           background-color: #2c2c2c;
           color: #ffffff;
           border: 1px solid #555;
           border-radius: 6px;
           transition: border-color 0.3s ease;
       }
       input[type="text"]:focus,
       input[type="password"]:focus {
           border-color: #3498db;
           outline: none;
       }
       input[type="submit"] {
           padding: 12px;
           font-size: 16px;
           color: #ffffff;
           background-color: #3498db;
           border: none;
           border-radius: 6px;
           cursor: pointer;
           transition: background-color 0.3s ease;
       }
       input[type="submit"]:hover {
           background-color: #2980b9;
       }
       p {
           font-size: 14px;
           color: #b3b3b3;
           margin-top: 10px;
       }
       a {
           color: #3498db;
           text-decoration: none;
           font-weight: bold;
       }
       a:hover {
           text-decoration: underline;
       }
   </style>
</head>
<body>
   <div class="container">
       <h1>Welcome to the Bartender System</h1>
       <h2>Employee Login</h2>
       <p>Manage your bar efficiently and with ease</p>

       <?php if ($message): ?>
           <p class="message"><?php echo htmlspecialchars($message); ?></p>
       <?php endif; ?>

       <form action="core/handleForms.php" method="POST">
           <label for="username">Username</label>
           <input type="text" name="username" id="username" required>
           <label for="password">Password</label>
           <input type="password" name="password" id="password" required>
           <input type="submit" name="loginUserBtn" value="Login">
       </form>
       <p>Don't have an account? <a href="register.php">Register here</a>!</p>
   </div>

   <?php
   // Redirect to index.php if user is already logged in
   if (isset($_SESSION['username'])) {
       header("Location: index.php");
       exit();
   }
   ?>
</body>
</html>
