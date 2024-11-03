<?php

require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if orderID is set in the URL
if (!isset($_GET['orderID'])) {
    die('Error: orderID is missing.');
}

// Retrieve orderID from URL and ensure it's an integer
$orderID = (int)$_GET['orderID'];

// Fetch order data by ID
$getOrderByID = getOrderByID($pdo, $orderID);

// If no order found, display an error message
if (!$getOrderByID) {
    die("Error: Order not found.");
}

// Fetch all customers and bartenders
$customers = getAllCustomers($pdo);
$bartenders = getAllBartenders($pdo); // Function to fetch all bartenders from the database

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
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
        select {
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
        .back-btn {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #d9534f;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .back-btn a {
            text-decoration: none;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Bar Management System</h1>
        <h2>Update Order Information:</h2>
        <form action="core/handleForms.php" method="POST">
            <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($orderID); ?>">

            <label for="customerName">Customer Name</label>
            <select name="customerID" required>
                <option value="" disabled>Select a customer</option>
                <?php foreach ($customers as $customer): ?>
                    <option value="<?php echo htmlspecialchars($customer['customerID']); ?>" 
                        <?php echo (isset($getOrderByID['customerID']) && $getOrderByID['customerID'] == $customer['customerID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($customer['fname'] . ' ' . $customer['lname']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            
            <label for="bartenderID">Bartender</label>
            <select name="bartenderID" required>
                <option value="" disabled>Select a bartender</option>
                <?php foreach ($bartenders as $bartender): ?>
                    <option value="<?php echo htmlspecialchars($bartender['bartenderID']); ?>" 
                        <?php echo (isset($getOrderByID['bartenderID']) && $getOrderByID['bartenderID'] == $bartender['bartenderID']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($bartender['fname'] . ' ' . $bartender['lname']); ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="orderDetails">Order Details</label>
            <select name="orderDetails" required>
                <option value="" disabled>---</option>
                <option value="Coke" <?php echo (isset($getOrderByID['orderDetails']) && $getOrderByID['orderDetails'] === 'Coke') ? 'selected' : ''; ?>>Coke</option>
                <option value="Sprite" <?php echo (isset($getOrderByID['orderDetails']) && $getOrderByID['orderDetails'] === 'Sprite') ? 'selected' : ''; ?>>Sprite</option>
                <option value="Lemonade" <?php echo (isset($getOrderByID['orderDetails']) && $getOrderByID['orderDetails'] === 'Lemonade') ? 'selected' : ''; ?>>Lemonade</option>
                <option value="Water" <?php echo (isset($getOrderByID['orderDetails']) && $getOrderByID['orderDetails'] === 'Water') ? 'selected' : ''; ?>>Water</option>
            </select>

            <label for="orderStatus">Order Status</label>
            <select name="orderStatus" required>
                <option value="" disabled>---</option>
                <option value="pending" <?php echo (isset($getOrderByID['orderStatus']) && $getOrderByID['orderStatus'] === 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="completed" <?php echo (isset($getOrderByID['orderStatus']) && $getOrderByID['orderStatus'] === 'completed') ? 'selected' : ''; ?>>Completed</option>
            </select>

            <div class="info">
                <p><strong>Added By:</strong> <?php echo htmlspecialchars($getOrderByID['added_by']); ?></p>
                <p><strong>Last Updated:</strong> <?php echo htmlspecialchars($getOrderByID['last_updated']); ?></p>
            </div>
            
            <input type="submit" value="Update" name="editOrderBtn">
        </form>
        <button class="back-btn"><a href="index.php">Back</a></button>
    </div>
</body>
</html>
