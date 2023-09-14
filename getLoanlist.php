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
    	 $email = $_REQUEST['username'];
  	 
    	 $qry = "SELECT l.*,b.* FROM loan AS l INNER JOIN bank AS b ON b.bankID = l.bankID
                    inner join profile as p on p.userID = b.userID
                    WHERE p.emailID = '$email'";
				
				  $result = mysql_query($qry);
          
          
      if(!$result || mysql_num_rows($result) <= 0)
     		{   
     			http_response_code(401);
     		}
     		else
     		{
   		       	while($row = mysql_fetch_array($result)) 
   	         {
   	          $d1 = strtotime($row['loanDate']);
              $d2 = strtotime($row['expirationDate']);
              
              $seconds_diff = $d2 - $d1;
              
   	           $row['daysleft'] =( $seconds_diff / (60 * 60 * 24));
   	          
   	          $cdate =  strtotime(date('d-m-Y'));
   	         // echo "\n";
   	            $diff_Exp_cdate = (int)( ($cdate - $d2) / (60 * 60 * 24));
   	           
   	          
   	          if($diff_Exp_cdate > 0)
   	          {
   	           
     	            if((int)($diff_Exp_cdate/7) != $row['flag'])
     	            {
     	              
     	              $flag = ( (int)($diff_Exp_cdate/7))+1;
     	              $downpayment = $row['downpayment']+(($row['downpayment']* $row['interest'])/100);
     	               $sql="update loan set flag = '$flag',downpayment = '$downpayment' where loanID = '$row[loanID]'";
     	               $query = mysql_query($sql);
     	              
     	            }
   	              
   	          }
   	          
   	    		    $data[] = $row;
   			       }
   
   		
        			header('Cache-Control: no-cache, must-revalidate');
        			
        			header('Content-type: application/json');
        			echo json_encode($data);
     			
     		}    
  	}
    
  
?>