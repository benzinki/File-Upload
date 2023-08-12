<?php

$dbHost = "localhost";
$dbUser = "admin";
$dbPassword = "password";
$dbName = "dbfile";

$dbConnection = new mysqli($localhost, $admin, $password, $dbfile);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $file = $_FILES["file"];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format!!!";
    } else {
        $allowedTypes = ["image/jpeg", "image/png"];
        if (in_array($file["type"], $allowedTypes)) {
            $uploadDir = "uploads/";
            $uploadFile = $uploadDir . basename($file["name"]);

            if (move_uploaded_file($file["tmp_name"], $uploadFile)) {
                $stmt = $dbConnection->prepare("INSERT INTO uploaded_files (email, file_path) VALUES (?, ?)");
                $stmt->bind_param("ss", $email, $uploadFile);

                if ($stmt->execute()) {
                    echo "File uploaded and data stored successfully!";
                } else {
                    echo "Error storing data in the database!";
                }

                $stmt->close();
            } else {
                echo "Error file upload!";
            }
        } else {
            echo "Invalid file type! Allowed file type: JPEG and PNG.";
        }
    }
}
?>