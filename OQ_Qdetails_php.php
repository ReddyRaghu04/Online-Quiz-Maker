<?php


// Database connection
$host = "localhost";
$user = "root"; // Change if using a different user
$password = ""; // Add password if set
$database = "online_quiz_maker";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Database connection failed"]));
}

// Get data from request
$data = json_decode(file_get_contents("php://input"), true);

if (isset($data["title"], $data["description"], $data["category"], $data["questionType"], $data["weightage"])) {
    $title = $conn->real_escape_string($data["title"]);
    $description = $conn->real_escape_string($data["description"]);
    $category = $conn->real_escape_string($data["category"]);
    $questionType = $conn->real_escape_string($data["questionType"]);
    $weightage = (int) $data["weightage"];

    // Insert into database
    $sql = "INSERT INTO quiz_details(title, description, category, question_type, weightage) 
            VALUES ('$title', '$description', '$category', '$questionType', $weightage)";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Quiz saved successfully!"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid input data"]);
}

$conn->close();
?>
