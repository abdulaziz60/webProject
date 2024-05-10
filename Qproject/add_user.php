<?php
session_start();  // Start or resume a session
include 'connection.php';  // Include your database connection setup

// Helper function to sanitize data
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

echo "<h3>Debugging Info:</h3>";
echo "Request Method: " . $_SERVER["REQUEST_METHOD"] . "<br>";
echo "POST Data: ";
print_r($_POST);
echo "<br>FILES Data: ";
print_r($_FILES);
echo "<br>";

// Check if the form submission is via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the form submission is via POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_FILES["itemProductPhoto"]) && $_FILES["itemProductPhoto"]["error"] == 0 && isset($_POST['productItemName']) && !empty($_POST['productItemName'])) {
            // Process the uploaded file and insert the product name and image path into the database
        } else {
            echo "No file uploaded or product name not set.<br>";
        }
    } else {
        echo "Invalid request method.<br>";

    }}
    ?>
        // Process the uploaded file and insert the product name and image path into the database
        $productName = sanitizeInput($_POST['productItemName']);
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["itemProductPhoto"]["name"]);
        $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Validate that the file is an actual image
                if (isset($_FILES["itemProductPhoto"]["tmp_name"])) {
                    $check = getimagesize($_FILES["itemProductPhoto"]["tmp_name"]);
                    if ($check !== false) {
                        echo "File is an image - " . $check["mime"] . ".<br>";
                    } else {
                        echo "File is not an image.<br>";
                        $uploadOk = 0;
                    }
                }

                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.<br>";
                    $uploadOk = 0;
                }

                // Check file size - limit to 5MB
                if ($_FILES["itemProductPhoto"]["size"] > 5000000) {
                    echo "Sorry, your file is too large.<br>";
                    $uploadOk = 0;
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
                    $uploadOk = 0;
                }

                // Attempt to upload the file if all checks pass
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.<br>";
                } else {
                    if (move_uploaded_file($_FILES["itemProductPhoto"]["tmp_name"], $target_file)) {
                        echo "The file ". htmlspecialchars(basename($_FILES["itemProductPhoto"]["name"])) . " has been uploaded.<br>";
                        $sql = "INSERT INTO products (product_name, product_img) VALUES (?, ?)";
                        $stmt = $conn->prepare($sql);
                        if ($stmt === false) {
                            die("Prepare failed: " . $conn->error);
                        }
                        $stmt->bind_param("ss", $productName, $target_file);
                        if ($stmt->execute()) {
                            echo "The product has been added successfully!<br>";
                        } else {
                            echo "Execute failed: " . $stmt->error;
                        }
                        $stmt->close();
                    } else {
                        echo "Sorry, there was an error uploading your file.<br>";
                    }
                }
            } else {
                echo "No file uploaded or product name not set.<br>";
            }
        } else {
            echo "Invalid request method.<br>";
        }
