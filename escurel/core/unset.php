<?php

include_once 'dbConfig.php';
session_start(); // Start the session to manage session data

// Define the queries to reset the bartender, customer, and order data
$deleteOrdersQuery = "DELETE FROM orders"; // First delete orders
$deleteBartendersQuery = "DELETE FROM bartenders"; // Then delete bartenders
$resetBartenderIncrementQuery = "ALTER TABLE bartenders AUTO_INCREMENT = 1";
$deleteCustomersQuery = "DELETE FROM customers"; // Finally delete customers
$resetCustomerIncrementQuery = "ALTER TABLE customers AUTO_INCREMENT = 1";
$resetOrderIncrementQuery = "ALTER TABLE orders AUTO_INCREMENT = 1"; // Reset auto-increment for orders

try {
    // Prepare the deletion and reset statements
    $deleteOrdersStmt = $pdo->prepare($deleteOrdersQuery);
    $deleteBartendersStmt = $pdo->prepare($deleteBartendersQuery);
    $resetBartenderIncrementStmt = $pdo->prepare($resetBartenderIncrementQuery);
    $deleteCustomersStmt = $pdo->prepare($deleteCustomersQuery);
    $resetCustomerIncrementStmt = $pdo->prepare($resetCustomerIncrementQuery);
    $resetOrderIncrementStmt = $pdo->prepare($resetOrderIncrementQuery);

    // Execute the deletion queries
    $deleteOrders = $deleteOrdersStmt->execute();
    $deleteBartenders = $deleteBartendersStmt->execute();
    $deleteCustomers = $deleteCustomersStmt->execute();

    // Reset the auto-increment values
    $resetBartenderIncrement = $resetBartenderIncrementStmt->execute();
    $resetCustomerIncrement = $resetCustomerIncrementStmt->execute();
    $resetOrderIncrement = $resetOrderIncrementStmt->execute();

    // Check if all queries were successful
    if ($deleteOrders && $deleteBartenders && $deleteCustomers && $resetBartenderIncrement && $resetCustomerIncrement && $resetOrderIncrement) {
        session_unset(); // Clear session variables
        session_destroy(); // Destroy the session
        header('Location: ../index.php'); // Redirect to homepage
        exit(); // Stop further script execution after redirect
    } else {
        $_SESSION['error_message'] = "Error occurred while resetting data. Please try again.";
        header('Location: ../error.php'); // Redirect to an error page (optional)
        exit();
    }
} catch (PDOException $e) {
    // Log the error and set a session message for the user
    error_log("Database error in unset.php: " . $e->getMessage());
    $_SESSION['error_message'] = "Database error occurred. Please contact support.";
    header('Location: ../error.php'); // Redirect to an error page (optional)
    exit();
}
?>
