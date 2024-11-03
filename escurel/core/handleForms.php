<?php
require_once 'dbConfig.php'; // Database connection
require_once 'models.php';   // Data handling functions

// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session only if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("POST request received"); // Debugging line

    // Handle User Registration
    if (isset($_POST['createUserBtn'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (createAccount($pdo, $username, $password)) {
            $_SESSION['message'] = "Registration successful! Please log in.";
            header("Location: ../login.php");
            exit;
        } else {
            $_SESSION['message'] = "Registration failed. Try again.";
            header("Location: ../register.php");
            exit;
        }
    }

    // Handle User Login
    if (isset($_POST['loginUserBtn'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        $user = loginUser($username, $password, $pdo);
        if ($user) {
            $_SESSION['username'] = $user['username']; // Set session variable with username
            $_SESSION['user_id'] = $user['user_id'];   // Set session variable with user ID
            header("Location: ../index.php");
            exit;
        } else {
            $_SESSION['message'] = "Invalid login credentials.";
            header("Location: ../login.php");
            exit;
        }
    }

    // Handle Bartender Operations
    if (isset($_POST['addBartenderBtn'])) {
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $experience = (int)$_POST['experience'];
        $added_by = $_SESSION['username']; // Record who added the bartender

        if (addBartender($pdo, $fname, $lname, $experience, $added_by)) {
            $_SESSION['message'] = "Bartender added successfully!";
        } else {
            $_SESSION['message'] = "Failed to add bartender.";
        }
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['deleteBartenderBtn'])) {
        $bartenderID = (int)$_POST['bartenderID'];
        if (deleteBartender($pdo, $bartenderID)) {
            $_SESSION['message'] = "Bartender deleted successfully!";
        } else {
            $_SESSION['message'] = "Failed to delete bartender.";
        }
        header("Location: ../index.php");
        exit;
    }

    // Handle Bartender Edit
    if (isset($_POST['editBartenderBtn'])) {
        $bartenderID = (int)$_POST['bartenderID'];
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $experience = (int)$_POST['experience'];

        // Retrieve the original bartender data to maintain added_by
        $originalBartender = getBartenderByID($pdo, $bartenderID);

        // Check if the original bartender was found
        if (!$originalBartender) {
            $_SESSION['message'] = "No bartender found with ID: $bartenderID";
            error_log("No bartender found with ID: $bartenderID");
            header("Location: ../index.php");
            exit;
        }

        // Keep the original added_by field and update last_updated timestamp
        $added_by = $originalBartender['added_by'];
        $last_updated = date('Y-m-d H:i:s'); // Update timestamp for last_updated

        // Validate inputs
        if (!empty($fname) && !empty($lname) && $experience >= 0) {
            // Call to update the bartender
            if (updateBartender($pdo, $fname, $lname, $experience, $bartenderID, $added_by, $last_updated)) {
                $_SESSION['message'] = "Bartender updated successfully!";
            } else {
                $_SESSION['message'] = "Failed to update bartender. Please check your input.";
                error_log("Failed to update bartender with ID: $bartenderID");
            }
        } else {
            $_SESSION['message'] = "Please fill in all fields correctly.";
        }

        header("Location: ../index.php");
        exit;
    }

    // Handle Customer Operations
    if (isset($_POST['addCustomerBtn'])) {
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        $added_by = $_SESSION['username']; // Record who added the customer

        if (addCustomer($pdo, $fname, $lname, $phone, $email, $added_by)) {
            $_SESSION['message'] = "Customer added successfully!";
        } else {
            $_SESSION['message'] = "Failed to add customer.";
        }
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['deleteCustomerBtn'])) {
        $customerID = (int)$_POST['customerID'];
        if (deleteCustomer($pdo, $customerID)) {
            $_SESSION['message'] = "Customer deleted successfully!";
        } else {
            $_SESSION['message'] = "Failed to delete customer.";
        }
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['editCustomerBtn'])) {
        $customerID = (int)$_POST['customerID'];
        $fname = trim($_POST['fname']);
        $lname = trim($_POST['lname']);
        $email = trim($_POST['email']);
        $phone = trim($_POST['phone']);
        
        // Retrieve the original customer data to maintain added_by
        $originalCustomer = getCustomerByID($pdo, $customerID);
        
        // Check if the original customer was found
        if (!$originalCustomer) {
            $_SESSION['message'] = "No customer found with ID: $customerID";
            error_log("No customer found with ID: $customerID");
            header("Location: ../index.php");
            exit;
        }

        // Keep the original added_by field and update last_updated timestamp
        $added_by = $originalCustomer['added_by'];
        $last_updated = date('Y-m-d H:i:s'); // Update timestamp for last_updated

        if (updateCustomer($pdo, $fname, $lname, $phone, $email, $customerID, $added_by, $last_updated)) {
            $_SESSION['message'] = "Customer updated successfully!";
        } else {
            $_SESSION['message'] = "Failed to update customer.";
        }
        header("Location: ../index.php");
        exit;
    }

    // Handle Order Operations
    if (isset($_POST['addOrderBtn'])) {
        $customerID = (int)$_POST['customerID'];
        $bartenderID = (int)$_POST['bartenderID'];
        $orderDetails = trim($_POST['orderDetails']);
        $orderStatus = trim($_POST['orderStatus']);
        $added_by = $_SESSION['username']; // Record who added the order

        // Validate inputs
        if ($customerID > 0 && $bartenderID > 0 && !empty($orderDetails) && !empty($orderStatus)) {
            if (addOrder($pdo, $customerID, $bartenderID, $orderDetails, $orderStatus, $added_by)) {
                $_SESSION['message'] = "Order added successfully!";
            } else {
                $_SESSION['message'] = "Failed to add order.";
            }
        } else {
            $_SESSION['message'] = "Please fill in all fields correctly.";
        }
        header("Location: ../index.php");
        exit;
    }

    if (isset($_POST['deleteOrderBtn'])) {
        $orderID = (int)$_POST['orderID'];
        if (deleteOrder($pdo, $orderID)) {
            $_SESSION['message'] = "Order deleted successfully!";
        } else {
            $_SESSION['message'] = "Failed to delete order.";
        }
        header("Location: ../index.php");
        exit;
    }

    // Handle Order Edit
    if (isset($_POST['editOrderBtn'])) {
        $orderID = (int)$_POST['orderID'];
        $customerID = (int)$_POST['customerID'];
        $bartenderID = (int)$_POST['bartenderID'];
        $orderDetails = trim($_POST['orderDetails']);
        $orderStatus = trim($_POST['orderStatus']);
        
        // Retrieve the original order data to maintain added_by
        $originalOrder = getOrderByID($pdo, $orderID);
        
        // Check if the original order was found
        if (!$originalOrder) {
            $_SESSION['message'] = "No order found with ID: $orderID";
            error_log("No order found with ID: $orderID");
            header("Location: ../index.php");
            exit;
        }

        // Keep the original added_by field and update last_updated timestamp
        $added_by = $originalOrder['added_by'];
        $last_updated = date('Y-m-d H:i:s'); // Update timestamp for last_updated

        // Validate inputs
        if ($customerID > 0 && $bartenderID > 0 && !empty($orderDetails) && !empty($orderStatus)) {
            // Call to update the order
            if (editOrder($pdo, $orderID, $customerID, $bartenderID, $orderDetails, $orderStatus, $added_by, $last_updated)) {
                $_SESSION['message'] = "Order updated successfully!";
            } else {
                $_SESSION['message'] = "Failed to update order.";
                error_log("Failed to update order with ID: $orderID");
            }
        } else {
            $_SESSION['message'] = "Please fill in all fields correctly.";
        }

        header("Location: ../index.php");
        exit;
    }
}

// Handle Logout
if (isset($_GET['logout'])) {
    session_destroy(); // Destroy the session to log out
    header("Location: ../login.php");
    exit;
}
?>
