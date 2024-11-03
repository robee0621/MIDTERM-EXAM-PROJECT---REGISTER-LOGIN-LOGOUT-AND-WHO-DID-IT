<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if 'orderID' exists in the URL
if (isset($_GET['orderID'])) {
    $orderID = htmlspecialchars($_GET['orderID']);
    $getOrderByID = getOrderByID($pdo, $orderID);  // Fetch order details by ID

    // Check if the order exists
    if (!$getOrderByID) {
        echo "Order not found.";
        exit();
    }
} else {
    // Handle the case where orderID is not present in the URL
    echo "No order specified for deletion.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Order</title>
</head>
<body>
    <h1>Bar Management System</h1>
    <br><br>
    <h2>Are you sure you want to delete this order?</h2>
    <br>
    <p>Order ID: <?php echo htmlspecialchars($getOrderByID['orderID']); ?></p>
    <p>Customer Name: <?php echo htmlspecialchars($getOrderByID['customerName']); ?></p>
    <p>Drink: <?php echo htmlspecialchars($getOrderByID['drinkName']); ?></p>
    <p>Order Status: <?php echo htmlspecialchars($getOrderByID['orderStatus']); ?></p>

    <!-- Ensure the form uses POST and sends the orderID as a hidden input -->
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="orderID" value="<?php echo htmlspecialchars($orderID); ?>">
        <input type="submit" value="Delete" name="deleteOrderBtn">
    </form>
</body>
</html>
