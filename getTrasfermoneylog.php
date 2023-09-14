<?php 

 	require('conn.php');
   require('userlog.php');
  
  	if(empty($_REQUEST['username']))
   {
		  http_response_code(401);
	  }
  	else
  	{
  		 $data = array(); 
    	 $user_id = getEmail($_REQUEST['username']);
  	 
    	$qry = "SELECT tm.*,p.username FROM 
           		`transfermoney` as tm inner join profile as p on tm.userID_to = p.userID
           		where tm.userID_from = '$user_id'";
           				
				  $result = mysql_query($qry);
          
          
      if(!$result || mysql_num_rows($result) <= 0)
     		{   
     			http_response_code(401);
     		}
     		else
     		{
   		       	while($row = mysql_fetch_array($result)) 
   	         {
   	    		    $data[] = $row;
   			       }
        			header('Cache-Control: no-cache, must-revalidate');
        			header('Content-type: application/json');
        			echo json_encode($data);
     		}    
  	}
    
  
?>