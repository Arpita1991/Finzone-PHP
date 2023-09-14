<?php 

require('conn.php');
require('userlog.php');
 
	if(empty($_REQUEST['email']))
    {
      	http_response_code(401);
    }
    else
    {
    	$email = $_REQUEST['email'];
    	
    	if(getEmail($email))
    	{
    			$newcode = generateRandomNumber(5);
    			
    			$sql = "update profile set verificationcode = '$newcode' where emailID='$email'";	 
	
		        $result = mysql_query($sql) or die("not executed");
		             
		        if(!$result)
				{   
					http_response_code(401);
				}
				else
				{
				    	$data = mysql_query("SELECT * FROM profile WHERE emailID =  '$email'");
		                $row = mysql_fetch_array($data);
				    
			            $to = $email;
						$from = "patelarpita1991@gmail.com";
						$Full_Name = $row['username'];
						$subject = "Password Verification Code";
						$message = '<html><body>';   
						$message .= '<table cellpadding="10" border="0">';
						$message .= '<tr><td colspan=2>&nbsp;</td></tr>';
						$message .= "<tr><td colspan='2'><strong>Dear ".$Full_Name.",</strong></td></tr>";
						$message .= '<tr><td colspan=2>&nbsp;</td></tr>';           
						$message .= '<tr><td colspan=2>Verification code : '.$row['verificationcode'].'</td></tr>';            
						$message .= '<tr><td colspan=2>&nbsp;</td></tr>';
		  				$message .= "<tr><td colspan='2'>Thank you.</tr>"; 
						$message .= "</table>";             
						$message .= "</body></html>";   
						$headers = "From: " . $from . "\r\n";
						$headers .= "CC: patelarpita1991@gmail.com\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
			
						 $sendmail = mail($to, "$subject", $message, "From:" . $headers);
						
						 if($sendmail)
						 {
						    http_response_code(201);
						 }
						 else
						 {
						   	http_response_code(401);
						 }
					
				}  
    	}
    	
       
    }	
  
?>