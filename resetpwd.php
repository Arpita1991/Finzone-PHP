<?php
ob_start();
session_start();
	require('conn.php');
	require('userlog.php');
    
    if(empty($_REQUEST['email']) || empty($_REQUEST['password']))
    {
    	http_response_code(401);
    }
    else
    {
    	$email = $_REQUEST['email'];
    	
    	if(getEmail($email))
    	{
    	   $password = md5($_REQUEST['password']);

		   	$sql = "update profile set password = '$password' where emailID='$email'";	 
		
	        $result = mysql_query($sql) or die("not executed");     
	             
	        if(!$result)
			{   
				http_response_code(401);
			}
			else
			{
				http_response_code(201);
			}     	
    	}
    	else
    	{
    		http_response_code(401);
    	}
    }	
  
   	?>
