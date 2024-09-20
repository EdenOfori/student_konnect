<?php

session_start();

# check if the user is logged in
if (isset($_SESSION['username'])) {
    # check if the key is submitted
    if(isset($_POST['key'])){
       # database connection file
	   include '../db.conn.php';

	   # creating simple search algorithm :) 
	   $key = "%{$_POST['key']}%";
     
	   $sql = "SELECT * FROM users
	           WHERE username
	           LIKE ? OR name LIKE ?";
       $stmt = $conn->prepare($sql);
       $stmt->execute([$key, $key]);

       if($stmt->rowCount() > 0){ 
         $users = $stmt->fetchAll();

         foreach ($users as $user) {
         	if ($user['user_id'] == $_SESSION['id']) continue;
       ?>
       <li class="list-group-item">
		<a href="chat.php?user=<?=$user['username']?>"
		   >
			<div class="d-flex
			            align-items-center" >

			    <img src="profile/<?=$user['profile_image']?>"
			         class="  rounded-circle"
					 style="width: 45px!important "

					 >
			    <h3 class="fs-6 ms-2 mt-2">
			    	<?=$user['name']?>
			    </h3>            	
			</div>
		 </a>
	   </li>
       <?php } }else { ?>
         <div class="alert alert-info 
    				 text-center">
		   <i class="fa fa-user-times d-block fs-big"></i>
           The user "<?=htmlspecialchars($_POST['key'])?>"
           is  not found.
		</div>
    <?php }
    }

}else {
	header("Location: ../../index.php");
	exit;
}
?>