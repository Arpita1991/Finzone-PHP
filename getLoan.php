<?php 

 	require('conn.php');
   require('userlog.php');
  
  	if(empty($_REQUEST['username']) || empty($_REQUEST['amount']) || empty($_REQUEST['rate']) || empty($_REQUEST['time']))
   {
		  http_response_code(401);
	}
  	else
  	{
  	   $amount = trim($_REQUEST['amount']);
      $rate = trim($_REQUEST['rate']);
      $time = trim($_REQUEST['time']);
      
      $cdate =  date('d-m-Y');
     
      $expires = strtotime($time, strtotime($cdate));

      $expire_date = date('d-m-Y', $expires);
       
      $downpaymnet = $amount + (($amount*5)/100);
      
      
  	  echo $query = "INSERT INTO `finzone_db`.`loan` (`loanID`, `bankID`, `loanDate`, `expirationDate`, `interest`, `loanamount`,`downpayment`) VALUES
  	            ('', (select bankId from bank as b inner join profile as p on p.userID = b.userID where p.emailID = '".$_REQUEST['username']."'), '$cdate', '$expire_date', '$rate', '$amount','$downpaymnet')";
  	    
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