<?php
session_start();
require_once 'core/dbConfig.php';
require_once 'core/models.php'; // Include your models

$message = ''; // Initialize message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fname = trim($_POST['fname']);
    $lname = trim($_POST['lname']);
    $experience = trim($_POST['experience']);
    $added_by = $_SESSION['username'] ?? 'Unknown'; // Get the username from the session

    // Validate input data
    if (!empty($fname) && !empty($lname) && is_numeric($experience)) {
        // Call the function to add the bartender
        if (addBartender($pdo, $fname, $lname, (int)$experience, $added_by)) {
            $message = "Bartender added successfully!";
        } else {
            $message = "Failed to add a bartender.";
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
    <title>Bartender</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #121212; /* Dark background */
            margin: 0;
            padding: 20px;
            color: #e0e0e0; /* Light text color */
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #1e1e1e; /* Dark container background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        h1 {
            color: #ffffff; /* White heading color */
        }
        .alert {
            color: #ff4d4d; /* Light red for alert messages */
            margin-bottom: 20px;
        }
        label {
            margin-top: 10px;
            display: block;
            color: #e0e0e0; /* Light label color */
        }
        input[type="text"], input[type="number"] {
            width: 95%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #444; /* Dark border */
            border-radius: 4px;
            background-color: #2e2e2e; /* Dark input background */
            color: #e0e0e0; /* Light input text */
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #5cb85c; /* Green button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button a {
            color: white; /* White link text */
            text-decoration: none;
        }
        button:hover {
            background-color: #4cae4c; /* Darker green on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add a bartender</h1>
        <?php if ($message): ?>
            <p class="alert"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>
        <form method="POST" action="">
            <label for="fname">First Name:</label>
            <input type="text" id="fname" name="fname" required>
            
            <label for="lname">Last Name:</label>
            <input type="text" id="lname" name="lname" required>
            
            <label for="experience">Experience (years):</label>
            <input type="number" id="experience" name="experience" required min="0">
            
            <button type="submit">Add a bartender</button>
        </form>
        <button><a href="index.php">Back</a></button>
    </div>
</body>
</html>
