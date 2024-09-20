<?php
// Start the session
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    // Include your database connection file
    include '../db.conn.php';

    // Get the user ID from the session
    $user_id = $_SESSION['user_id'];

    // Query to check for new messages
    $sql = "SELECT COUNT(*) AS new_messages FROM chats WHERE to_id = ? AND opened = 0";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Return JSON response indicating if there are new messages
    echo json_encode(['new_messages' => ($row['new_messages'] > 0)]);
} else {
    // If user is not logged in, return JSON response with new_messages set to false
    echo json_encode(['new_messages' => false]);
}
?>
