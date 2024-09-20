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
                
                // Set success message for notification
                $_SESSION['success'] = "Friend request sent successfully.";

                // Redirect back to the page where the request was sent from
                header("Location: ".$_SERVER['HTTP_REFERER']);
                exit;
            } else {
                // Redirect back with a SweetAlert error message if the request has already been sent
                $_SESSION['error'] = "Friend request already sent.";
                header("Location: ".$_SERVER['HTTP_REFERER']);
                exit;
            }
        } else {
            // Redirect back with a SweetAlert error message if the sender and receiver are the same
            $_SESSION['error'] = "Cannot send friend request to yourself.";
            header("Location: ".$_SERVER['HTTP_REFERER']);
            exit;
        }
    } else {
        // Redirect back if receiver_id is not submitted
        header("Location: ".$_SERVER['HTTP_REFERER']);
        exit;
    }
} else {
    // Redirect to index.php if the user is not logged in
    header("Location: ../../index.php");
    exit;
}
?>
