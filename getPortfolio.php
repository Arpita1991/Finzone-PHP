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
    	
    	$email = getEmail($_REQUEST['email']);
    	
    
        $qry = "SELECT p.emailID,p.username,COALESCE(sum(l.loanamount),0) as loanamount,po.*,b.amount,
				(select count(*) from transactionlog where transType='1' and p.userID='$email') as numstock,
				(select count(*) from transactionlog where transType='2' and p.userID='$email') as numcommodity,
				(select count(*) from transactionlog where transType='3' and p.userID='$email') as numforex
					FROM bank as b
					inner join profile as p on p.userID = b.userID 
				    left outer join loan as l on l.bankID = b.bankID
					inner join portfolio as po on po.userID = p.userID										
					where p.userID='$email'";
				    	
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
