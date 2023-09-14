<?php
ob_start();
session_start();
	require('conn.php');
    require('userlog.php');
    
    
    if(empty($_REQUEST['fromuserID']) || empty($_REQUEST['touserID'])|| empty($_REQUEST['timestamp']))
    {
    	http_response_code(401);	
    }
    else
    {
    	$data = array();
    	
    	$from = $_REQUEST['fromuserID'];
    	$to = $_REQUEST['touserID'];
    	$timestamp = $_REQUEST['timestamp'];
    	
      $qry = "SELECT m.* FROM message AS m
			WHERE (m.from_userID =  '$from' AND m.to_userID =  '$to')  AND (m.DateTime > $timestamp)";
    	
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
