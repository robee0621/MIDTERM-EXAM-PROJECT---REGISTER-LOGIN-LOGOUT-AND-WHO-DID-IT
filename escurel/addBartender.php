<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if bartenderID is provided in the URL
if (!isset($_GET['bartenderID'])) {
    die('Error: bartenderID is missing.');
}

// Retrieve bartenderID from URL
$bartenderID = (int) $_GET['bartenderID'];

// Fetch bartender data by ID
$getBartenderByID = getBartenderByID($pdo, $bartenderID); // Ensure the function name is correct

// If no bartender found, display an error message
if (!$getBartenderByID) {
    die('Error: Bartender not found.');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        /* Dark theme styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #121212;
            color: #e0e0e0;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #1e1e1e;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        h1 {
            color: #ffffff;
        }
        h2 {
            color: #e0e0e0;
        }
        label {
            margin-top: 10px;
            display: block;
            color: #e0e0e0;
        }
        input[type="text"], input[type="number"] {
            width: 95%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #444;
            border-radius: 4px;
            background-color: #2e2e2e;
            color: #e0e0e0;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #5e81ac; /* Blueish for primary buttons */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4a7096; /* Slightly darker blue for hover */
        }
        .alert {
            color: #f48fb1; /* Light pink for alert messages */
            margin-bottom: 20px;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #88c0d0; /* Light blue for back button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #6c9bb3;
        }
        button a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bartender Settings</h1>
        <h2>Edit info</h2>

        <!-- Form to edit bartender details -->
        <form action="core/handleForms.php" method="POST">
            <input type="hidden" name="bartenderID" value="<?php echo htmlspecialchars($bartenderID); ?>">

            <!-- First Name Field -->
            <label for="fname">First Name</label>
            <input type="text" name="fname" id="fname" value="<?php echo htmlspecialchars($getBartenderByID['fname']); ?>" required>

            <!-- Last Name Field -->
            <label for="lname">Last Name</label>
            <input type="text" name="lname" id="lname" value="<?php echo htmlspecialchars($getBartenderByID['lname']); ?>" required>

            <!-- Experience Field -->
            <label for="experience">Years of Experience</label>
            <input type="number" name="experience" id="experience" min="0" value="<?php echo htmlspecialchars($getBartenderByID['experience']); ?>" required>

            <!-- Submit Button -->
            <input type="submit" value="Update Bartender" name="editBartenderBtn">
        </form>
        <button><a href="index.php">Back</a></button>
    </div>
</body>
</html>
