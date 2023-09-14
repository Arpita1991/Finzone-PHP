<?php 

 require('conn.php');
 
 function userlog($userid)
 {
       $date =  date('m/d/Y h:i:s a', time());
       
        $query = "INSERT INTO userlog(`logID`, `userID`, `loginDate`)
  	    VALUES('','$userid','$date')";
  	    
         $res = mysql_query($query);
          
         if($res) 
         {
           http_response_code(201);
         } 
         else
         {
           http_response_code(401);
         }  
 }
 
 
 function GenerateBankAccount($userid)
 {
        $randomNum = generateRandomNumber();;   
       $query = "INSERT INTO `finzone_db`.`bank` (`bankID`, `userID`, `accountNo`, `amount`)
                VALUES ('', '$userid', '$randomNum', '10000')";
  	    
         $res = mysql_query($query);
          
        if($res)
        {
           userlog($userid);
        }
        else
        {
            http_response_code(401);
        }  
  
 }
 
 function generateRandomNumber($length = 9)
 {
    $number = '1234567890';
    $numberLength = strlen($number);
    $randomNumber = '';
    for ($i = 0; $i < $length; $i++) {
        $randomNumber .= $number[rand(0, $numberLength - 1)];
    }
    return $randomNumber;
}


function getEmail($email)
{
    
     $qry = "Select * from profile where emailID='$email'";
        	$result = mysql_query($qry) or die("not executed");     
             
         	if(!$result || mysql_num_rows($result) <= 0)
    		{   
    			http_response_code(401);
    		}
    		else
    		{
    			$row = mysql_fetch_array($result);
    			return $row['userID'];
    		}
    
}

function GeneratePortfolioAccount($email)
{
   $qry = mysql_query("INSERT INTO `finzone_db`.`portfolio` (`portfolioID`, `userID`, `stockInvest`, `commoditiesInvest`, `forexInvest`, `stockProfit`, `forexProfit`, `commodityProfit`) 
    VALUES ('', '$email', '0', '0', '0', '0', '0', '0')");
     return $qry;
}
  
?>