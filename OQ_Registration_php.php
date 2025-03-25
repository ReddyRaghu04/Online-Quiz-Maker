<?php
header('Content-Type: application/json'); // Ensure JSON response

$servername = "localhost";
$username = "root";  // Change if needed
$password = "";      // Change if needed
$dbname = "online_quiz_maker";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed!"]);
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $username = trim($_POST['username']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $organization = trim($_POST['organization']);
    $role = trim($_POST['role']);

    $sql = "INSERT INTO registration (full_name, email, username, password, organization, role) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("ssssss", $full_name, $email, $username, $password, $organization, $role);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Registration successful!"]);
        } else {
            echo json_encode(["success" => false, "message" => "Error: " . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Error preparing SQL statement."]);
    }
}

$conn->close();
?>
