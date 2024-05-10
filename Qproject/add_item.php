<?php
session_start();
include 'connection.php'; // Includes database connection setup

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "store_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    echo "<h3>Debugging Info:</h3>";
    echo "Request Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
    echo "POST Data: ";
    print_r($_POST);
    echo "<br>FILES Data: ";
    print_r($_FILES);
    echo "<br>";
    die("Connection failed: " . $conn->connect_error);
}



    

echo "Connected successfully";


// Check if the form submission is via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['itemProductPhoto']) && $_FILES['itemProductPhoto']['error'] == 0 && isset($_POST['productItemName']) && !empty($_POST['productItemName'])) {
        $productName = htmlspecialchars($_POST['productItemName'], ENT_QUOTES, 'UTF-8'); // Sanitize the input
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES['itemProductPhoto']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Validate the file is an image
        $check = getimagesize($_FILES['itemProductPhoto']['tmp_name']);
        if ($check !== false) {
            echo "File is an image - " . $check['mime'] . ".<br>";
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "Sorry, file already exists.<br>";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES['itemProductPhoto']['size'] > 5000000) {
                echo "Sorry, your file is too large.<br>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
                $uploadOk = 0;
            }

            // Attempt to upload file if all checks pass
            if ($uploadOk == 1) {
                if (move_uploaded_file($_FILES['itemProductPhoto']['tmp_name'], $target_file)) {
                    echo "The file " . htmlspecialchars(basename($_FILES['itemProductPhoto']['name'])) . " has been uploaded.<br>";
                    // Prepare SQL query to insert product data into database
                    $sql = "INSERT INTO products (product_name, product_img) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    if ($stmt === false) {
                        die("SQL Error: " . $conn->error);
                    }
                    $stmt->bind_param("ss", $productName, $target_file);
                    if ($stmt->execute()) {
                        echo "The product has been added successfully!<br>";
                    } else {
                        echo "Error: " . $stmt->error;
                    }
                    $stmt->close();
                } else {
                    echo "Sorry, there was an error uploading your file.<br>";
                }
            } else {
                echo "Your file was not uploaded due to restrictions.<br>";
            }
        } else {
            echo "File is not an image.<br>";
        }
    } else {
        echo "Invalid request method or necessary data not provided.<br>";
    }
} else {
    echo "Invalid request method.<br>";
}
?>
