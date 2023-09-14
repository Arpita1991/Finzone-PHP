<?php
ob_start();

	require('conn.php');
    require('userlog.php');
  

	if(empty($_REQUEST['username']) || empty($_REQUEST['fuser'])|| empty($_REQUEST['status']))
    {
		  http_response_code(401);
	}
	else
	{
		
		  $emailID_from = getEmail(trim($_REQUEST['username']));
	      $emailID_to = trim($_REQUEST['fuser']);
	      $status = $_REQUEST['status'];
	  	
  			if($status == 'true')
  			{
  			 $updateamount = "UPDATE friends SET status = '1' where (userID_to = '$emailID_from' and userID_from = '$emailID_to') or (userID_from = '$emailID_from' and userID_to = '$emailID_to')";	
  			}
  			else if($status == 'false')
  			{
  			  $updateamount = "delete from friends where (userID_to = '$emailID_from' and userID_from = '$emailID_to') or (userID_from = '$emailID_from' and userID_to = '$emailID_to')";	
  			}
  			$updateamount = mysql_query($updateamount);
  			
        	if(!$updateamount)
    		{
    			http_response_code(401);
    		}
    		else
    		{
    			http_response_code(201);
    		}

	}
	
	  	 

   	?>
	