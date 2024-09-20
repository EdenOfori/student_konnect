<?php

session_start();

# Check if the user is logged in
if (isset($_SESSION['username'])) {
    # Check if the receiver_id is submitted
    if(isset($_POST['receiver_id'])){
        # Database connection file
        include '../db.conn.php';

        # Get the sender's user ID from the session
        $sender_id = $_SESSION['user_id'];

        # Get the receiver's user ID from the form data
        $receiver_id = $_POST['receiver_id'];

        # Check if the sender is not sending a friend request to themselves
        if ($sender_id != $receiver_id) {
            # Check if the sender has not already sent a friend request to the receiver
            $sql_check = "SELECT * FROM friend_requests WHERE sender_id = ? AND receiver_id = ?";
            $stmt_check = $conn->prepare($sql_check);
            $stmt_check->execute([$sender_id, $receiver_id]);
            if ($stmt_check->rowCount() == 0) {
                # Insert the friend request into the database
                $sql_insert = "INSERT INTO friend_requests (sender_id, receiver_id) VALUES (?, ?)";
                $stmt_insert = $conn->prepare($sql_insert);
                $stmt_insert->execute([$sender_id, $receiver_id]);

                // Send success response as JSON
                echo json_encode(['success' => true, 'message' => 'Friend request sent successfully.']);
                exit;
            } else {
                // Send error response as JSON
                echo json_encode(['success' => false, 'message' => 'Friend request already sent.']);
                exit;
            }
        } else {
            // Send error response as JSON
            echo json_encode(['success' => false, 'message' => 'Cannot send friend request to yourself.']);
            exit;
        }
    } else {
        // Send error response as JSON
        echo json_encode(['success' => false, 'message' => 'Receiver ID not provided.']);
        exit;
    }
} else {
    // Send error response as JSON
    echo json_encode(['success' => false, 'message' => 'You are not logged in.']);
    exit;
}
?>
