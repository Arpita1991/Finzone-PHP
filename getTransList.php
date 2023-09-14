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
    	$email = $_REQUEST['email'];
    	
    	  $qry = "SELECT t.shareType, d.type as 'Type', tl.*
				FROM transactionlog AS tl
				INNER JOIN profile AS p ON p.userID = tl.userID
				INNER JOIN domain AS d ON d.ID = tl.domainID
				INNER JOIN transactiontype AS t ON t.ID = tl.transType
			    WHERE p.emailID = '$email' order by tl.tansID DESC";
       	
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
