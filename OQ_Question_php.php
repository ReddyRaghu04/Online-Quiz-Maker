<?php

// Database Connection
$host = "localhost";
$user = "root"; 
$pass = ""; 
$dbname = "online_quiz_maker";

$conn = new mysqli($host, $user, $pass, $dbname);

// Check Connection
if ($conn->connect_error) {
    die(json_encode(["message" => "Database connection failed: " . $conn->connect_error]));
}

// Get JSON Data from Frontend
$data = json_decode(file_get_contents("php://input"), true);

if (!empty($data["questions"])) {
    foreach ($data["questions"] as $q) {
        $question = $conn->real_escape_string($q["question"]);
        $option1 = $conn->real_escape_string($q["options"][0]);
        $option2 = $conn->real_escape_string($q["options"][1]);
        $option3 = $conn->real_escape_string($q["options"][2]);
        $option4 = $conn->real_escape_string($q["options"][3]);
        $correct = $conn->real_escape_string($q["correct"]);

        // Insert into database
        $sql = "INSERT INTO quiz_questions (question, option1, option2, option3, option4, correct_answer) 
                VALUES ('$question', '$option1', '$option2', '$option3', '$option4', '$correct')";

        if (!$conn->query($sql)) {
            echo json_encode(["message" => "Error: " . $conn->error]);
            exit;
        }
    }
    echo json_encode(["message" => "Quiz saved successfully!"]);
} else {
    echo json_encode(["message" => "No questions received"]);
}

$conn->close();
?>
