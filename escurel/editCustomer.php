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
        h2 {
            color: #5a5a5a;
        }
        label {
            margin-top: 10px;
            display: block;
        }
        input[type="text"], input[type="email"] {
            width: 95%;
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
        .info {
            margin-top: 20px;
            font-size: 14px;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bar Management System</h1>
        <h2>Update Customer Information:</h2>
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
        <button><a href="index.php" style="text-decoration: none; color: black;">Back</a></button>
    </div>
</body>
</html>
