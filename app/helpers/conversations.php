<?php 

function getConversation($user_id, $conn){
    
    // Getting all the conversations 
    // for current (logged in) user
    $sql = "SELECT * FROM conversations
            WHERE user_one_id = ? OR user_two_id = ?
            ORDER BY conversation_id DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id, $user_id]);

    if($stmt->rowCount() > 0){
        $conversations = $stmt->fetchAll();

        // Creating an empty array to 
        // store the user conversation
        $user_data = [];
        
        // Looping through the conversations
        foreach($conversations as $conversation){
            // If conversation's user_one_id column equals user_id
            if ($conversation['user_one_id'] == $user_id) {
                $sql2  = "SELECT * FROM users WHERE user_id = ?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute([$conversation['user_two_id']]);
            } else {
                $sql2  = "SELECT * FROM users WHERE user_id = ?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->execute([$conversation['user_one_id']]);
            }

            $allConversations = $stmt2->fetchAll();

            // Pushing the data into the array 
            array_push($user_data, $allConversations[0]);
        }

        return $user_data;

    } else {
        $conversations = [];
        return $conversations;
    }  
}
?>
