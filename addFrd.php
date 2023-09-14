<?php 

 	require('conn.php');
   require('userlog.php');
  
  	if(empty($_REQUEST['cuser']) || empty($_REQUEST['frdid']))
   {
		  http_response_code(401);
	 }
  	else
  	{
  	   $cuser = getEmail(trim($_REQUEST['cuser']));
      $frdid = $_REQUEST['frdid'];


     $cdate =  date('d-m-Y');
  
     echo $query = "INSERT INTO `finzone_db`.`friends` (`frdID`, `userID_to`, `userID_from`, `status`, `createdDate`) 
                 VALUES ('', '$frdid', '$cuser', '0', '$cdate')";
  
  	   $res = mysql_query($query);
          
          
      if(!$res) 
      {
    			http_response_code(401);
    		}
    		else
    		{
    			http_response_code(201);
    		}


  	}
    
  
?>