<?php
session_start(); // Ensure session is started

require_once 'core/dbConfig.php';
require_once 'core/models.php'; // Include your models

$message = ''; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $addedBy = $_SESSION['username']; // Assuming the username is stored in the session after login

    // Validate input data
    if (!empty($fname) && !empty($lname) && !empty($phone) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Call the function to add the customer with 6 parameters
        if (addCustomer($pdo, $fname, $lname, $phone, $email, $addedBy)) {
            $message = "Customer added successfully!";
        } else {
            $message = "Failed to add a customer.";
        }
    } else {
        $message = "Please fill in all fields correctly.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        /* Dark theme styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            color: #e0e0e0; /* Light text color */
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #1e1e1e; /* Darker background for container */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        h1 {
            color: #ffffff; /* White heading */
        }
        .alert {
            color: #f48fb1; /* Light pink for alert messages */
            margin-bottom: 20px;
        }
        label {
            margin-top: 10px;
            display: block;
            color: #e0e0e0; /* Light text for labels */
        }
        input[type="text"], input[type="tel"], input[type="email"] {
            width: 95%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #444; /* Darker border */
            border-radius: 4px;
            background-color: #2e2e2e; /* Input background */
            color: #e0e0e0; /* Input text color */
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #5e81ac; /* Blueish for primary buttons */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button a {
            color: white;
            text-decoration: none;
        }
        button:hover {
            background-color: #4a7096; /* Darker blue on hover */
        }
        button.back {
            background-color: #88c0d0; /* Light blue for back button */
        }
        button.back:hover {
            background-color: #6c9bb3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add a customer!</h1>
        <?php if ($message): ?>
            <p class="alert"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" required>
            
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" required>
            
            <label for="phone">Phone:</label>
            <input type="tel" id="phone" name="phone" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
            
            <button type="submit">Add a customer!</button>
        </form>
        <button class="back"><a href="index.php">Back</a></button>
    </div>
</body>
</html>
