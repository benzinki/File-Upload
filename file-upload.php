<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $file = $_FILES["file"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format";
    } else {
        
        $allowedTypes = ["image/jpeg", "image/png"];
        if (in_array($file["type"], $allowedTypes)) {
            $uploadDir = "uploads/";
            $uploadFile = $uploadDir . basename($file["name"]);

            if (move_uploaded_file($file["tmp_name"], $uploadFile)) {
                echo "File uploaded successfully.";
            } else {
                echo "Error uploading file.";
            }
        } else {
            echo "Invalid file type. Only JPEG and PNG files are allowed.";
        }
    }
}
?>