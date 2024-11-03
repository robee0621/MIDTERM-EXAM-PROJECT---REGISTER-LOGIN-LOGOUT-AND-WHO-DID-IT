<?php
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if customerID is set in the URL
if (!isset($_GET['customerID'])) {
    die('Error: customerID is missing.');
}

$customerID = (int) $_GET['customerID']; // Ensure it's an integer
$getCustomerByID = getCustomerByID($pdo, $customerID);

// Check if customer data was found
if (!$getCustomerByID) {
    die("Error: Customer not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <style>
        /* Dark theme styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #0d0d0d; /* Very dark background */
            color: #f5f5f5; /* Light text color for better contrast */
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: auto;
            background-color: #1a1a1a; /* Darker card background */
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.7); /* Slightly darker shadow */
        }
        h1 {
            color: #ffffff; /* Pure white for heading */
        }
        h2 {
            color: #e0e0e0; /* Light subheading color */
        }
        label {
            margin-top: 10px;
            display: block;
            color: #e0e0e0; /* Light label color */
        }
        input[type="text"], input[type="email"] {
            width: 95%;
            padding: 10px; /* Increased padding for comfort */
            margin-top: 5px;
            border: 1px solid #444; /* Dark border */
            border-radius: 4px;
            background-color: #333; /* Dark input background */
            color: #f5f5f5; /* Light input text */
        }
        input[type="submit"] {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #4caf50; /* Green for primary buttons */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #45a049; /* Darker green on hover */
        }
        .info {
            margin-top: 20px;
            font-size: 14px;
            color: #e0e0e0; /* Light info text */
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #2196F3; /* Light blue for back button */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0b7dda; /* Darker blue on hover */
        }
        button a {
            color: white; /* Light color for link in button */
            text-decoration: none; /* No underline for link */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>The Bar!</h1>
        <h2>Change customer info:</h2>
        <form action="core/handleForms.php" method="POST">
            <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customerID); ?>">

            <label for="fname">First Name</label>
            <input type="text" name="fname" value="<?php echo htmlspecialchars($getCustomerByID['fname']); ?>" required>
            
            <label for="lname">Last Name</label>
            <input type="text" name="lname" value="<?php echo htmlspecialchars($getCustomerByID['lname']); ?>" required>
            
            <label for="email">Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($getCustomerByID['email']); ?>" required>
            
            <label for="phone">Phone</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($getCustomerByID['phone']); ?>" required>
            
            <!-- Display the added_by and last_updated fields as read-only -->
            <div class="info">
                <p><strong>Added By:</strong> <?php echo htmlspecialchars($getCustomerByID['added_by']); ?></p>
                <p><strong>Last Updated:</strong> <?php echo htmlspecialchars($getCustomerByID['last_updated']); ?></p>
            </div>
            
            <input type="submit" value="Update" name="editCustomerBtn">
        </form>
        <button><a href="index.php">Back</a></button>
    </div>
</body>
</html>
