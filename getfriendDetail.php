<?php
 ob_start();
session_start();
	require('conn.php');
    require('userlog.php');
    
    
    if(empty($_REQUEST['currentuser']) || empty($_REQUEST['frduser']))
    {
    	http_response_code(401);	
    }
    else
    {
    	$currentuser = getEmail($_REQUEST['currentuser']);
        $frduser = $_REQUEST['frduser'];
    
    
      $qry = mysql_query("SELECT status FROM `friends` where (userID_to = '$currentuser' and userID_from = '$frduser') or (userID_from = '$currentuser' and userID_to = '$frduser')");
   
    	if(mysql_num_rows($qry) > 0 )
    	{	
    		$resultdata = mysql_fetch_array($qry);
		    	
		    	 $data = getProfileData($frduser);
		    	 if($resultdata['status'] == 0)  $data[0]["friend"]="pending";
		    	 if($resultdata['status'] == 1)  $data[0]["friend"]="friend";
		      	 if($resultdata['status'] == 2)  $data[0]["friend"]="unfriend";
		    	 
    				header('Cache-Control: no-cache, must-revalidate');
					
					header('Content-type: application/json');
					echo json_encode($data);
		    	 
		    	 
		    	 
    	}
    	 else
    	 {
    				$data = getProfileData($frduser);
    	 			 $data[0]["friend"]="nofriend";
    				header('Cache-Control: no-cache, must-revalidate');
					
					header('Content-type: application/json');
					echo json_encode($data);
    	 }
                	
    }
    
    function getProfileData($userID)
    {	
    		$qry = "SELECT count(tl.userID) as totaltras,p.*,e.type FROM `profile` as p 
    				inner join experience as e on p.experienceID = e.expID
    				inner join transactionlog as tl on tl.userID = p.userID
    				where p.userID='$userID'";
				    							
				 $result = mysql_query($qry) or die("not executed");     
		             
		        	$data = array();
		        
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
				}  
				
				return $data;
    }
    
    
   	?>
