<?php 

 	require('conn.php');
   require('userlog.php');
  
  	if(empty($_REQUEST['username']))
   {
		  http_response_code(401);
	}
  	else
  	{
  	   $loanID = trim($_REQUEST['loanID']);
  	   $userID = getEmail($_REQUEST['username']);
      $cdate =  date('d-m-Y');
      $amount = $_REQUEST['amount'];
      $data = array(); 
      
    	 $email = $_REQUEST['username'];
  	 
     	$qry = "SELECT * FROM `bank` where userID='$userID'";
				
				  $result = mysql_query($qry);
				  $row = mysql_fetch_array($result);
				  header('Cache-Control: no-cache, must-revalidate');
        			
        			header('Content-type: application/json');
        			echo json_encode($row);
      
     
  	}
  	
?>