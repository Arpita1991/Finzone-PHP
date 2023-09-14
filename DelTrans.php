<?php
	require('conn.php');

	if(empty($_REQUEST['email']) || empty($_REQUEST['transID']))
    {
		 http_response_code(401);
	}
	else
	{
		$email = $_REQUEST['email'];
		$tansID = $_REQUEST['transID'];
		$sql = mysql_query("DELETE t.* FROM transactionlog AS t WHERE t.userID = ( SELECT userID FROM profile WHERE emailID =  '$email' ) AND t.tansID =  '$tansID'");
	  
	    if($sql) 
         {
           http_response_code(201);
         } 
         else
         {
           http_response_code(401);
         }  
	}
   
?>
