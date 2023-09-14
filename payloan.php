<?php 

 	require('conn.php');
   require('userlog.php');
  
  	if(empty($_REQUEST['username']) || empty($_REQUEST['loanID'])|| empty($_REQUEST['amount']))
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
  	 
     	$qry = "SELECT * FROM `loan` as l  inner join bank as b on l.bankID=b.bankID where loanID='$loanID'";
				  $result = mysql_query($qry);
				 
				  
				 if(!$result || mysql_num_rows($result) <= 0)
    		{   
    			http_response_code(401);
    		}
    		else{
    		  $row = mysql_fetch_array($result);
    		  
				    $bankID=$row["bankID"];
				    $loanDate = $row['loanDate'];
				    $expirationDate = $row['expirationDate'];
				    
    				 $update_bank = "update bank set amount = amount - $amount where userID='$userID'";	
    				 
    				 $sql_payment = "INSERT INTO  `finzone_db`.`paymentlog` (`paymentID` ,`userID` ,`amount` ,`DateTime` ,`loanDate` ,`expirationDate`)VALUES
    				   ('' ,'$userID', '$amount','$cdate','$loanDate','$expirationDate')";
    				  
    		   $sql_loan = "delete from loan where loanID='$loanID'";
        
         if(!mysql_query($sql_loan) || !mysql_query($sql_payment) || !mysql_query($update_bank))
         {
       			http_response_code(401);
       		}
       		else
       		{
       			http_response_code(201);
       		}
        		 
    	 	}
				  
  	}
  	
?>