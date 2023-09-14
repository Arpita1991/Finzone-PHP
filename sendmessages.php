<?php 

 	require('conn.php');
  require('userlog.php');
  
  	if(empty($_REQUEST['from']) || empty($_REQUEST['to'])|| empty($_REQUEST['message']) || empty($_REQUEST['timestamp']))
    {
		  http_response_code(401);
	}
  	else
 {
  	    $from = $_REQUEST['from'];
  	    $to =  $_REQUEST['to'];
  	  
          $message = trim($_REQUEST['message']);
      	  $date =  $_REQUEST['timestamp'];
  	    
  	    $query = "INSERT INTO  `finzone_db`.`message` (`messageID` ,`from_userID` ,`to_userID` ,`message` ,`DateTime`)VALUES ('' ,  '$from',  '$to',  '$message', '$date')";
  	    
          
        $res = mysql_query($query);
          
         if($res) 
         {
           http_response_code(201);
         } 
         else
         {
           http_response_code(401);
         }  
  	}
        
    
  
?>