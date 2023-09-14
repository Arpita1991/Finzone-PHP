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
    	 $email = $_REQUEST['email'];
    	
	 $qry = "SELECT count(tl.userID) as totaltras,p.emailID,p.imagePath,p.username,p.bio,p.dob,p.badgeID,
				p.location,ba.*,e.* FROM 
				profile AS p INNER JOIN badge AS b ON p.badgeID = b.badgeID 				
				inner join experience as e ON e.expID = p.experienceID
				inner join bank as ba on ba.userID = p.userID
				left join transactionlog as tl on tl.userID = p.userID
				WHERE p.emailID ='$email'";
        $result = mysql_query($qry) or die("not executed");     
             
        
        if(!$result || mysql_num_rows($result) <= 0)
		{   
			http_response_code(401);
		}
		else
		{
			$row = mysql_fetch_array($result);
			$bankamount = $row['amount'];
			header('Cache-Control: no-cache, must-revalidate');
			
			header('Content-type: application/json');
			echo json_encode($row);
			
		}     
                	
    }

   	?>
