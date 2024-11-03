<?php

require_once 'dbConfig.php';

// Deletes a customer
function deleteCustomer(PDO $pdo, int $customerID): bool {
    try {
        $query = "DELETE FROM customers WHERE customerID = :customerID";
        $statement = $pdo->prepare($query);
        return $statement->execute([':customerID' => $customerID]);
    } catch (PDOException $e) {
        error_log("Error deleting customer: " . $e->getMessage());
        return false;
    }
}

// Retrieves a customer by ID
function getCustomerByID(PDO $pdo, int $customerID): ?array {
    try {
        $query = "SELECT customerID, fname, lname, phone, email, added_by, last_updated FROM customers WHERE customerID = :customerID";
        $statement = $pdo->prepare($query);
        $statement->execute([':customerID' => $customerID]);
        return $statement->fetch(PDO::FETCH_ASSOC) ?: null; // Return null if no customer found
    } catch (PDOException $e) {
        error_log("Error fetching customer: " . $e->getMessage());
        return null;
    }
}

// Updates customer information
function updateCustomer(PDO $pdo, string $fname, string $lname, string $phone, string $email, int $customerID, string $updatedBy): bool {
    try {
        $query = "UPDATE customers SET fname = :fname, lname = :lname, phone = :phone, email = :email, added_by = :added_by, last_updated = NOW() WHERE customerID = :customerID";
        $statement = $pdo->prepare($query);
        return $statement->execute([
            ':fname' => $fname,
            ':lname' => $lname,
            ':phone' => $phone,
            ':email' => $email,
            ':added_by' => $updatedBy,
            ':customerID' => $customerID
        ]);
    } catch (PDOException $e) {
        error_log("Error updating customer: " . $e->getMessage());
        return false;
    }
}

// Retrieves a bartender by ID
function getBartenderByID(PDO $pdo, int $bartenderID): ?array {
    try {
        $query = "SELECT bartenderID, fname, lname, experience, added_by, last_updated FROM bartenders WHERE bartenderID = :bartenderID";
        $statement = $pdo->prepare($query);
        $statement->execute([':bartenderID' => $bartenderID]);
        return $statement->fetch(PDO::FETCH_ASSOC) ?: null; // Return null if no bartender found
    } catch (PDOException $e) {
        error_log("Error fetching bartender: " . $e->getMessage());
        return null;
    }
}

// Retrieves all bartenders
function getAllBartenders(PDO $pdo): array {
    try {
        $query = "SELECT bartenderID, fname, lname, experience, added_by, last_updated FROM bartenders";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching bartenders: " . $e->getMessage());
        return [];
    }
}

// Adds a new bartender
function addBartender(PDO $pdo, string $fname, string $lname, int $experience, string $addedBy): bool {
    try {
        $query = "INSERT INTO bartenders (fname, lname, experience, added_by, last_updated) VALUES (:fname, :lname, :experience, :added_by, NOW())";
        $statement = $pdo->prepare($query);
        return $statement->execute([
            ':fname' => $fname,
            ':lname' => $lname,
            ':experience' => $experience,
            ':added_by' => $addedBy
        ]);
    } catch (PDOException $e) {
        error_log("Error adding bartender: " . $e->getMessage());
        return false;
    }
}

// Deletes a bartender
function deleteBartender(PDO $pdo, int $bartenderID): bool {
    try {
        $query = "DELETE FROM bartenders WHERE bartenderID = :bartenderID";
        $statement = $pdo->prepare($query);
        return $statement->execute([':bartenderID' => $bartenderID]);
    } catch (PDOException $e) {
        error_log("Error deleting bartender: " . $e->getMessage());
        return false;
    }
}

// Adds a new customer
function addCustomer(PDO $pdo, string $fname, string $lname, string $phone, string $email, string $addedBy): bool {
    try {
        $query = "INSERT INTO customers (fname, lname, phone, email, added_by, last_updated) VALUES (:fname, :lname, :phone, :email, :added_by, NOW())";
        $statement = $pdo->prepare($query);
        return $statement->execute([
            ':fname' => $fname,
            ':lname' => $lname,
            ':phone' => $phone,
            ':email' => $email,
            ':added_by' => $addedBy
        ]);
    } catch (PDOException $e) {
        error_log("Error adding customer: " . $e->getMessage());
        return false;
    }
}

// Retrieves all customers
function getAllCustomers(PDO $pdo): array {
    try {
        $query = "SELECT * FROM customers";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching customers: " . $e->getMessage());
        return [];
    }
}

// Retrieves all customers for dropdown options
function getAllCustomerNames(PDO $pdo): array {
    try {
        $query = "SELECT customerID, fname, lname FROM customers";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching customer names: " . $e->getMessage());
        return [];
    }
}

// Updates bartender information
function updateBartender(PDO $pdo, string $fname, string $lname, int $experience, int $bartenderID, string $updatedBy): bool {
    try {
        $query = "UPDATE bartenders SET fname = :fname, lname = :lname, experience = :experience, added_by = :added_by, last_updated = NOW() WHERE bartenderID = :bartenderID";
        $statement = $pdo->prepare($query);
        return $statement->execute([
            ':fname' => $fname,
            ':lname' => $lname,
            ':experience' => $experience,
            ':added_by' => $updatedBy,
            ':bartenderID' => $bartenderID
        ]);
    } catch (PDOException $e) {
        error_log("Error updating bartender: " . $e->getMessage());
        return false;
    }
}

// Registers an account with secure password hashing to database
function createAccount(PDO $pdo, string $username, string $password): bool {
    try {
        $checkQuery = "SELECT * FROM accounts WHERE username = :username";
        $statement = $pdo->prepare($checkQuery);
        $statement->execute([':username' => $username]);

        if ($statement->rowCount() == 0) {
            $insertQuery = "INSERT INTO accounts (username, password) VALUES (:username, :password)";
            $statement = $pdo->prepare($insertQuery);
            return $statement->execute([
                ':username' => $username,
                ':password' => password_hash($password, PASSWORD_DEFAULT)
            ]);
        } else {
            error_log("User already exists: $username");
        }
        return false;
    } catch (PDOException $e) {
        error_log("Error creating account: " . $e->getMessage());
        return false;
    }
}

// Logs in an account with password verification
function loginAccount(PDO $pdo, string $username): ?array {
    try {
        $checkQuery = "SELECT * FROM accounts WHERE username = :username";
        $statement = $pdo->prepare($checkQuery);
        $statement->execute([':username' => $username]);
        
        return $statement->fetch(PDO::FETCH_ASSOC) ?: null; // Return null if no user found
    } catch (PDOException $e) {
        error_log("Error logging in account: " . $e->getMessage());
        return null;
    }
}

// Logs in a user and verifies the password
function loginUser(string $username, string $password, PDO $pdo): ?array {
    try {
        $stmt = $pdo->prepare("SELECT user_id, username, password FROM accounts WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return $user; // User is valid
        }
    } catch (PDOException $e) {
        error_log("Error verifying user: " . $e->getMessage());
    }
    return null; // Invalid credentials
}

// Adds a new order
function addOrder(PDO $pdo, int $customerID, int $bartenderID, string $orderDetails, string $orderStatus, string $addedBy): bool {
    try {
        $query = "INSERT INTO orders (customerID, bartenderID, orderDetails, orderStatus, added_by, last_updated) VALUES (:customerID, :bartenderID, :orderDetails, :orderStatus, :added_by, NOW())";
        $statement = $pdo->prepare($query);
        
        // Log the parameters being passed to help with debugging
        error_log("Adding order with: Customer ID: $customerID, Bartender ID: $bartenderID, Order Details: $orderDetails, Order Status: $orderStatus, Added By: $addedBy");

        // Execute the prepared statement and return the result
        if ($statement->execute([
            ':customerID' => $customerID,
            ':bartenderID' => $bartenderID,
            ':orderDetails' => $orderDetails, // Updated to match the column name
            ':orderStatus' => $orderStatus,
            ':added_by' => $addedBy
        ])) {
            return true;
        } else {
            // Log any execution errors for debugging
            error_log("Failed to execute query: " . implode(", ", $statement->errorInfo()));
            return false;
        }
    } catch (PDOException $e) {
        error_log("Error adding order: " . $e->getMessage());
        return false;
    }
}

// Retrieves an order by ID
// Retrieves an order by ID along with customer name
function getOrderByID(PDO $pdo, int $orderID): ?array {
    try {
        $query = "SELECT orders.orderID, 
                         customers.fname AS customerFirstName, 
                         customers.lname AS customerLastName,
                         orders.bartenderID, 
                         orders.orderDetails, 
                         orders.orderStatus, 
                         orders.added_by, 
                         orders.last_updated 
                  FROM orders 
                  JOIN customers ON orders.customerID = customers.customerID 
                  WHERE orders.orderID = :orderID";
        $statement = $pdo->prepare($query);
        $statement->execute([':orderID' => $orderID]);
        return $statement->fetch(PDO::FETCH_ASSOC) ?: null; // Return null if no order found
    } catch (PDOException $e) {
        error_log("Error fetching order: " . $e->getMessage());
        return null;
    }
}



// Retrieves all orders with customer and bartender names
function getAllOrders(PDO $pdo): array {
    try {
        $query = "SELECT orders.orderID, 
                         customers.fname AS customerName, 
                         bartenders.fname AS bartenderName, 
                         orders.orderDetails, 
                         orders.orderStatus, 
                         orders.added_by, 
                         orders.last_updated 
                  FROM orders 
                  JOIN customers ON orders.customerID = customers.customerID 
                  JOIN bartenders ON orders.bartenderID = bartenders.bartenderID";
        $statement = $pdo->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error fetching orders: " . $e->getMessage());
        return [];
    }
}


// Deletes an order
function deleteOrder(PDO $pdo, int $orderID): bool {
    try {
        $query = "DELETE FROM orders WHERE orderID = :orderID";
        $statement = $pdo->prepare($query);
        return $statement->execute([':orderID' => $orderID]);
    } catch (PDOException $e) {
        error_log("Error deleting order: " . $e->getMessage());
        return false;
    }
}

// Updates order details
function editOrder(PDO $pdo, int $orderID, int $customerID, int $bartenderID, string $orderDetails, string $orderStatus, string $updatedBy): bool {
    try {
        $query = "UPDATE orders SET customerID = :customerID, bartenderID = :bartenderID, orderDetails = :orderDetails, orderStatus = :orderStatus, added_by = :added_by, last_updated = NOW() WHERE orderID = :orderID";
        $statement = $pdo->prepare($query);
        return $statement->execute([
            ':customerID' => $customerID,
            ':bartenderID' => $bartenderID,
            ':orderDetails' => $orderDetails,
            ':orderStatus' => $orderStatus,
            ':added_by' => $updatedBy,
            ':orderID' => $orderID
        ]);
    } catch (PDOException $e) {
        error_log("Error updating order: " . $e->getMessage());
        return false;
    }
}

?>
