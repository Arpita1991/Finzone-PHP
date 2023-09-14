<?php
 ob_start();
 session_start();
	require('conn.php');
	require('userlog.php');

    if(empty($_REQUEST['email']) || empty($_REQUEST['code']))
    {
    	http_response_code(401);	
    }
    else
    {
        $email = $_REQUEST['email'];
        $code = $_REQUEST['code'];
    	
        $qry = "SELECT verificationcode FROM `profile` where emailID = '$email'";
				    							
		$result = mysql_query($qry) or die("not executed");     
             
        if(!$result || mysql_num_rows($result) <= 0)
		{   
			http_response_code(401);
		}
		else
		{
			$row = mysql_fetch_array($result); 
	        if($row['verificationcode'] == $code)
	        {
	        	http_response_code(201);
	        }
	        else
	        {
	        	http_response_code(401);	
	        }
		}     
                	
    }
    
   	?>
