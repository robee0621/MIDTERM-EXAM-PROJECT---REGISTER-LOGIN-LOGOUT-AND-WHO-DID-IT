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
    <title>Edit Bartender</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            color: #34495e;
        }
        label {
            margin-top: 10px;
            display: block;
        }
        input[type="text"], input[type="number"] {
            width:95%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #4cae4c;
        }
        .alert {
            color: red;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bar Management System</h1>
        <h2>Edit Bartender Information</h2>

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
        <button><a href="index.php" style="text-decoration: none; color: black;">Back</a></button>
    </div>
</body>
</html>
