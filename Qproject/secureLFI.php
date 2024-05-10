<?php
// Define allowed directories
$allowed_directories = array(
    
    // Add more directories as needed
);

// Function to check if a file path is within allowed directories
function is_allowed_directory($file_path, $allowed_directories) {
    foreach ($allowed_directories as $dir) {
        if (strpos($file_path, $dir) === 0) {
            return true;
        }
    }
    return false;
}

// Function to include files securely
function secure_include($file_path, $allowed_directories) {
    if (is_allowed_directory($file_path, $allowed_directories)) {
        include($file_path);
    } else {
        // Log or handle unauthorized access attempt
        header("Location: unauthorized_access.php");
        exit();
    }
}


?>