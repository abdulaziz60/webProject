<?php
session_start();
include 'connection.php';  // Make sure this path is correctly pointing to your connection setup file.

$host = "localhost";  
$user = "root";  
$password = '';  
$db_name ="store_db";

// Establish database connection
$conn = new mysqli($host, $user, $password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Display debugging information
else {
    echo "Connected successfully<br>";
    echo "Debugging Info:<br>";
    echo "Request Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
    echo "POST Data: ";
    print_r($_POST);
    echo "<br>";
}


// Check if the form submission is via POST and if the productItemId is present
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
    $productId = intval($_POST['product_id']);  // Convert to integer for safety

    // Prepare SQL statement to prevent SQL injection
    $sql = "DELETE FROM products WHERE product_id = ?"; // Table name corrected to 'products'
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo "Prepare failed: " . $conn->error;  // Corrected property access for error
        exit;
    }

    $stmt->bind_param("i", $productId);  // Bind integer 'i' param

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Item deleted successfully!";
        // Optional: Redirect to a confirmation page or back to a product management page
        // header("Location: manage_products.php");
        // exit();
    } else {
        echo "Error deleting item: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Invalid request or missing product ID.";
}
?>
