<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["fileToUpload"])) {
    $uploadDirectory = "uploads/"; // Directory to store uploaded files

    // Generate a random string for the file name
    $randomString = substr(str_shuffle("abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 10);
    
    $originalFileName = $_FILES["fileToUpload"]["name"];
    $fileExtension = pathinfo($originalFileName, PATHINFO_EXTENSION);
    $newFileName = $randomString . "." . $fileExtension;
    $uploadFile = $uploadDirectory . $newFileName;

    // Create a database record to track the file and its download status
    $db = new mysqli("localhost", "username", "password", "your_database");
    if ($db->connect_error) {
        die("Connection failed: " . $db->connect_error);
    }
    
    $sql = "INSERT INTO uploaded_files (filename, download_count) VALUES (?, 0)";
    $stmt = $db->prepare($sql);
    $stmt->bind_param("s", $newFileName);
    
    if ($stmt->execute()) {
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $uploadFile)) {
            $shareableLink = "https://example.com/downloads/" . $newFileName;
            echo "File uploaded successfully. Share this link: <a href=\"$shareableLink\">$shareableLink</a>";
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "Sorry, there was an error creating the file record.";
    }

    $stmt->close();
    $db->close();
}

// Implement a function to track and handle downloads
function downloadFile($fileId) {
    // Check if the user is authorized to download the file
    if (isAuthorized($fileId)) {
        // Serve the file to the user
        serveFile($fileId);

        // Mark the file as downloaded and remove it from the database and server
        markFileAsDownloaded($fileId);
    } else {
        echo "Access Denied";
    }
}

function isAuthorized($fileId) {
    // Check authorization logic here
    // For example, you may implement user authentication and permissions
}

function serveFile($fileId) {
    // Serve the file to the user
}

function markFileAsDownloaded($fileId) {
    // Update the database to mark the file as downloaded and remove it from the server
}
?>
