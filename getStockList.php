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
    	$email = $_REQUEST['email'];
    	$type = $_REQUEST['type'];
		
		$qry = "SELECT t.shareType, d.type, s . * 
				FROM usersStock AS s
				INNER JOIN profile AS p ON p.userID = s.userID
				INNER JOIN domain AS d ON d.ID = s.domainID
				INNER JOIN transactiontype AS t ON t.ID = s.transType
				WHERE p.emailID = '$email' and t.shareType = '$type' order by s.stockID DESC";
				
		 $result = mysql_query($qry) or die("not executed");     
             
        
        
        if(!$result || mysql_num_rows($result) <= 0)
		{   
			http_response_code(401);
		}
		else
		{
			while ($row = mysql_fetch_array($result)) 
	        {  
	        //	echo "<br/>";
	           $d1 = strtotime(date($row['DateTime']));
	            $d2 = strtotime(date('d-m-y'));
               $seconds_diff = $d2 - $d1;
               $row['days'] =( $seconds_diff / (60 * 60 * 24));
   	          if($row['days']==0) $row['days']=1;
   	           $data[] = $row;
			}
			header('Cache-Control: no-cache, must-revalidate');
			header('Content-type: application/json');
			echo json_encode($data);
			
		}     
                	
    }
    
   	?>
