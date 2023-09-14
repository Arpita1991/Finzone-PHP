<?php 

 	require('conn.php');
  require('userlog.php');

  	if(empty($_REQUEST['username']) || empty($_REQUEST['password'])|| empty($_REQUEST['email']) || empty($_REQUEST['dob']))
    {
		  http_response_code(401);
	}else
	{
  	  $username = trim($_REQUEST['username']);
  	  $bio= trim($_REQUEST['bio']);
  	  $dob = trim($_REQUEST['dob']);
      $password = trim($_REQUEST['password']);
      $email = trim($_REQUEST['email']); 
      $date =  date('d-m-y');
      $pwdmd5 = md5($password);
     	
     
      $target_file=md5($email).".png";
     
      	$contents = file_get_contents($_FILES['image']['tmp_name']);
      	file_put_contents($target_file,base64_decode($contents)); 
    	
     	  
     	 $query = "INSERT INTO `finzone_db`.`profile` 
        	(`userID`, `imagePath`, `emailID`, `username`, `bio`, `password`, `verificationcode`, `location`,`dob`, `badgeID`, `experienceID`, `createdDate`) 
     	  VALUES ('', '$target_file',  '$email',  '$username',  '$bio',  '$password','','Canada','$dob','0','1','$date')";
     	
         $res = mysql_query($query);
          
         if($res) 
         {
       		$userID = getEmail($email);
       		GeneratePortfolioAccount($userID);
			GenerateBankAccount($userID);
         } 
         else
         {   
            http_response_code(401);
         }  
	}
    
  
  
?>