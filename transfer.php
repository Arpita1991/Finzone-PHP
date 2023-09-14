<?php
ob_start();

	require('conn.php');
    require('userlog.php');
  

	if(empty($_REQUEST['username']) || empty($_REQUEST['fuser'])|| empty($_REQUEST['amount']))
    {
		  http_response_code(401);
	}
	else
	{
		
		  $emailID_from = getEmail(trim($_REQUEST['username']));
	      $emailID_to = trim($_REQUEST['fuser']);
	      $amount = trim($_REQUEST['amount']);
	  	  $date =  date('d-m-y');
	  	  
	  	
	  		 $getmaount = "Select amount from bank where userId = '$emailID_from'";
        	$getmaount = mysql_query($getmaount) or die("not executed");     
           
         		$row = mysql_fetch_array($getmaount);
	    			if($row['amount'] >= $amount )
	    			{
	    					$sql = mysql_query("UPDATE bank SET amount = amount+$amount  WHERE userID = '$emailID_to'");
							if($sql)
							{
									$updateamount = mysql_query("UPDATE bank SET amount = amount-$amount  WHERE userID = '$emailID_from'");
									if($updateamount)
									{	
										$query = "INSERT INTO `finzone_db`.`transfermoney` (`tID`, `userID_to`, `userID_from`, `amount`, `createdDate`) 
													VALUES ('', '$emailID_to', '$emailID_from', '$amount', '$date')";
								  	    
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
									else
									{
										http_response_code(401);
									}
						    }
							else
							{
								http_response_code(401);
							}
	    			}
	    			else
	    			{
	    			
	    				 http_response_code(401);	
	    			}
    		
	}
	
	  	 

   	?>
	