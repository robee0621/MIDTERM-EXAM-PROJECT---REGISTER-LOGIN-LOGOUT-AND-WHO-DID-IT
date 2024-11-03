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
        body {
            font-family: Arial, sans-serif;
            background-color: #2c3e50; /* Dark background color */
            color: #ecf0f1; /* Light text color */
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: #34495e; /* Darker container background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }
        h1 {
            color: #ecf0f1; /* Light color for headings */
        }
        label {
            margin-top: 10px;
            display: block;
            color: #ecf0f1; /* Light color for labels */
        }
        input[type="text"], input[type="number"] {
            width:95%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #7f8c8d; /* Lighter border for input */
            border-radius: 4px;
            background-color: #2c3e50; /* Dark input background */
            color: #ecf0f1; /* Light text color for input */
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #27ae60; /* Green button color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #219653; /* Darker green on hover */
        }
        .alert {
            color: #e74c3c; /* Red alert color */
            margin-bottom: 20px;
        }
        button a {
            color: #ecf0f1; /* Light color for link */
            text-decoration: none;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #e67e22; /* Orange button color */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #d35400; /* Darker orange on hover */
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
        <button><a href="index.php" style="text-decoration: none;">Back</a></button>
    </div>
</body>
</html>
