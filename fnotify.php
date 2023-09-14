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
    	 $email = getEmail($_REQUEST['username']);
  	 
    	  $qry = "SELECT p.*,f.* from friends as f inner join profile as p on p.userID = f.userID_from WHERE f.userID_to = '$email' and f.status = '0'";
				
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