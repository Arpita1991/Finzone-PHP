<?php
 ob_start();
session_start();
	require('conn.php');
    require('userlog.php');
    
    
    if(empty($_REQUEST['email']))
    {
    	http_response_code(401);	
    }
    else
    {
    	$emailID = getEmail($_REQUEST['email']);

		$query = "SELECT p.emailID,p.username,p.userID,e.type
			FROM friends AS f			
			inner join profile as p on p.userID = if(f.userID_to!='$emailID',userID_to,userID_from)		
			inner join experience as e on p.experienceID=expID
			WHERE (f.userID_to = '$emailID' or f.userID_from = '$emailID') and f.status = '1'"; 
  	    
  		$result = mysql_query($query);
   
   
    	if(!$result || mysql_num_rows($result) <= 0)
		{   
			http_response_code(401);
		}
		else
		{
			while ($row = mysql_fetch_array($result)) 
	        {
	    		$data[] = $row;
			}

			header('Cache-Control: no-cache, must-revalidate');
			
			header('Content-type: application/json');
			echo json_encode($data);
		}     
                	
    }
    

    
   	?>
