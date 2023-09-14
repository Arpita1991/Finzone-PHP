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
		$qry = "SELECT imagePath FROM profile WHERE emailID =  '$email'";
        $result = mysql_query($qry) or die("not executed");     
             
        
        if(!$result || mysql_num_rows($result) <= 0)
		{   
			http_response_code(401);
		}
		else
		{
			$row = mysql_fetch_array($result);
			//print_r($row); 
		//header('Cache-Control: no-cache, must-revalidate');
		//header('Content-type: image/png');
	
		//echo '<img src="data:image/png;base64,' . base64_encode(hexToStr($row['imagePath'])) . '" />';
		
		//  echo  chr(bin2hex($row['imagePath']));
		
		//echo base64_encode(hexToStr($row['imagePath']));
	   // echo hexToStr($row['imagePath']);
		}     
    }
    
    function hexToStr($hex){
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2){
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;}

?>
