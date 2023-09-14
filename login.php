<?php
ob_start();
session_start();
	require('conn.php');
    require('userlog.php');
  
    if($_REQUEST['sl']=="false")
    {
	    if(empty($_REQUEST['email']) || empty($_REQUEST['password']) )
		{
			 http_response_code(401);  
		}else
		{	
			Login($_REQUEST['email'],$_REQUEST['password']);
		}
    }else if($_REQUEST['sl'] =='true')
    {
    	LoginWithSoc($_REQUEST['email'],$_REQUEST['password'],$_REQUEST['img'],$_REQUEST['username']);
    }else
    {
    	 http_response_code(401);
    }

	function Login($mail,$pwd)
	{
	
		$email = trim($mail);
		$password = trim($pwd);
		
		 $pwdmd5 = md5($password);
		
		 $qry = "Select * from profile where emailID='$email' and password='$pwdmd5' ";
    	$result = mysql_query($qry) or die("not executed");
    
		if(!$result || mysql_num_rows($result) <= 0)
		{
			 http_response_code(401);
		}
		else
		{
			$row = mysql_fetch_array($result);
			userlog($row['userID']);
		}
	}
	
	
	function LoginWithSoc($mail,$pwd,$img,$username)
	{
	  $email = trim($mail);
      $password = trim($pwd);
      $imagePath = trim($img);
      $fname = trim($fname);
      $lname = trim($lname);
      
  	  $date =  date('m/d/Y h:i:s a', time());
	
	 $pwdmd5 = md5($password);
  
  	   $qry = "Select * from profile where emailID='$email' and password='$pwdmd5' ";
       $result = mysql_query($qry) or die("not executed");
	
		if(!$result || mysql_num_rows($result) <= 0)
		{
			 $query = "INSERT INTO profile(`userID`, `imagePath`, `emailID`, `username`, `password`,
	  	                                  `badgeID`, `experienceID`, `createdDate`)
	  	    VALUES('','$imagePath','$email','$username','$pwdmd5','0','1','$date')";
	  	    
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
		else
		{
			$row = mysql_fetch_array($result);
			userlog($row['userID']);
		}

	}
   	?>
