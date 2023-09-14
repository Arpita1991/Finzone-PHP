<?php
 ob_start();
session_start();
	require('conn.php');
    require('userlog.php');
    
    
    if(empty($_REQUEST['searchdata']))
    {
    	http_response_code(401);	
    }
    else
    {
        $searchdata = $_REQUEST['searchdata'];
    	$data = array();
    
    	  $qry = "SELECT p.emailID,p.userID,p.username,p.badgeID,e.type FROM `profile` as p inner join experience as e on p.experienceID = e.expID where p.username like '$searchdata%'";
				    							
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
