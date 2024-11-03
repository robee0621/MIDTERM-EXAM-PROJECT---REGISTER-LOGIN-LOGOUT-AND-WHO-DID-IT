<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if 'customerID' exists in the URL
if (isset($_GET['customerID'])) {
    $customerID = htmlspecialchars($_GET['customerID']);
    $getCustomerByID = getCustomerByID($pdo, $customerID);  // Fetch customer details by ID

    // Check if the customer exists
    if (!$getCustomerByID) {
        echo "Customer not found.";
        exit();
    }
} else {
    // Handle the case where customerID is not present in the URL
    echo "No customer specified for deletion.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Customer</title>
</head>
<body>
    <h1>Bar Management System</h1>
    <br><br>
    <h2>Are you sure you want to delete this customer?</h2>
    <br>
    <p>First Name: <?php echo htmlspecialchars($getCustomerByID['fname']); ?></p>
    <p>Last Name: <?php echo htmlspecialchars($getCustomerByID['lname']); ?></p>
    <p>Email: <?php echo htmlspecialchars($getCustomerByID['email']); ?></p>

    <!-- Ensure the form uses POST and sends the customerID as a hidden input -->
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="customerID" value="<?php echo htmlspecialchars($customerID); ?>">
        <input type="submit" value="Delete" name="deleteCustomerBtn">
    </form>
</body>
</html>
