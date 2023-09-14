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
    	$data = array();
    	$email = getEmail($_REQUEST['email']);
    	
    	  $qry = "SELECT pl.Datetime as paidDate,pl.* FROM `paymentlog` as pl 
				where pl.userID = '$email'";
    	
       $result = mysql_query($qry) or die("not executed");     
             
        
        
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
