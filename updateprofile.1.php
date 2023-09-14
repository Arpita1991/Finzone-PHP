<?php
ob_start();
session_start();
	require('conn.php');
    require('userlog.php');
    
    if(empty($_REQUEST['email']))
    {
    
    }else
    {
    	$email = $_REQUEST['email'];
    	$username = $_REQUEST['username'];
    	$bio = $_REQUEST['bio'];
    	$password = $_REQUEST['password'];
    	$location = $_REQUEST['location'];
    	$dob = $_REQUEST['dob'];
    
      	$contents = file_get_contents($_FILES['image']['tmp_name']);
    	
		$VALUE = strToHex(base64_decode($contents));
	
	   	$qsl = mysql_query("update profile set imagePath = '$VALUE' where emailID='$email'");	 
	
	
		 $qry = "UPDATE  `finzone_db`.`profile` SET  
						`username` =  '$username',
						`bio` =  '$bio',
						`dob` =  '$dob',
						`location` =  '$location'
 						WHERE `profile`.`emailID` ='$email'";
 
        $result = mysql_query($qry) or die("not executed");     
             
        
        if(!$result)
		{   
			http_response_code(401);
		}
		else
		{
			http_response_code(201);
		}     
    }	
    
    function strToHex($string){
    $hex = '';
    for ($i=0; $i<strlen($string); $i++){
        $ord = ord($string[$i]);
        $hexCode = dechex($ord);
        $hex .= substr('0'.$hexCode, -2);
    }
    	return strToUpper($hex);
	}
    

   	?>
