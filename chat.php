<?php
// Include necessary files
session_start();

// Check if the user is logged in
if (isset($_SESSION['username'])) {
    include 'app/db.conn.php';
    include 'app/helpers/user.php';
    include 'app/helpers/chat.php';
    include 'app/helpers/opened.php';
    include 'app/helpers/timeAgo.php';

    // Check if the 'user' parameter is set in the URL
    if (!isset($_GET['user'])) {
        header("Location: home.php");
        exit;
    }

    // Getting User data
    $chatWith = getUser($_GET['user'], $conn);

    // Redirect if user not found
    if (empty($chatWith)) {
        header("Location: home.php");
        exit;
    }

    // Get chat messages
    $chats = getChats($_SESSION['id'], $chatWith['user_id'], $conn);
    // print_r($chats);
    // die();
    // Mark messages as opened
    opened($chatWith['user_id'], $conn, $chats);

    // Display chat interface
    include 'chat_interface.php';
} else {
    // Redirect to index page if user not logged in
    header("Location: index.php");
    exit;
}
?>
