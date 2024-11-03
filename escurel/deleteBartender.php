<?php 
require_once 'core/dbConfig.php';
require_once 'core/models.php';

// Check if 'bartenderID' exists in the URL
if (isset($_GET['bartenderID'])) {
    $bartenderID = htmlspecialchars($_GET['bartenderID']);
    $getBartenderByID = getBartenderByID($pdo, $bartenderID);  // Fetch bartender details by ID

    // Check if bartender exists
    if (!$getBartenderByID) {
        echo "Bartender not found.";
        exit();
    }
} else {
    // Handle the case where bartenderID is not present in the URL
    echo "No bartender specified for deletion.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Bartender</title>
</head>
<body>
    <h1>Bar Management System</h1>
    <br><br>
    <h2>Are you sure you want to delete this bartender?</h2>
    <br>
    <p>First Name: <?php echo htmlspecialchars($getBartenderByID['fname']); ?></p>
    <p>Last Name: <?php echo htmlspecialchars($getBartenderByID['lname']); ?></p>

    <!-- Ensure the form uses POST and sends the bartenderID as a hidden input -->
    <form action="core/handleForms.php" method="POST">
        <input type="hidden" name="bartenderID" value="<?php echo htmlspecialchars($bartenderID); ?>">
        <input type="submit" value="Delete" name="deleteBtn">
    </form>
</body>
</html>
