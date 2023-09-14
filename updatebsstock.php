<?php
ob_start();

	require('conn.php');
    require('userlog.php');
  

  
	if(empty($_REQUEST['stockID']) || empty($_REQUEST['email']) || empty($_REQUEST['domain']) || empty($_REQUEST['profit']) 
				|| empty($_REQUEST['loss']) || empty($_REQUEST['transtype']) || empty($_REQUEST['price']) 
				|| empty($_REQUEST['quantity']) || empty($_REQUEST['cname']) || empty($_REQUEST['invest']))
    {
		  http_response_code(401);
	}
	else
	{
		  $stockID = trim($_REQUEST['stockID']);
	      $userID = getEmail(trim($_REQUEST['email']));
	      $domain = trim($_REQUEST['domain']);
	      $profit = trim($_REQUEST['profit']);
	      $loss = trim($_REQUEST['loss']);
	      $transtype = trim($_REQUEST['transtype']);
	      $price = $_REQUEST['price'];
	      $qty = $_REQUEST['quantity'];
	      $cname = $_REQUEST['cname'];
	      $symbol = $_REQUEST['symbol'];

	  	  $date =  date('d-m-y');
	  	  
	  		if($domain=='Buy') {
	  			$domain='2';
	  			}
	  		if($domain=='Sell') $domain='1';
	  		if($transtype=='stock') $transtype='1';
	  		if($transtype=='commodity') $transtype='2';
	  		if($transtype=='forex') $transtype='3';
	  	
	  		if($transtype=='1') {
	  			$type='stockInvest';
	  			}
	  		if($transtype=='2') {
	  			$type='commoditiesInvest';
	  			}
	  		if($transtype=='3') {
	  			$type='forexInvest';
			}
	  		$invest = $_REQUEST['invest'];
	  		$sign = '-';
	  	
	  
		  $bankupdate = updateBankProfit($userID,$profit);
		  if($bankupdate){
	  			$translogupdate = addTranslog($transtype,$userID,$price,$qty,$date,$cname,$symbol,$domain);	
	  		if($translogupdate){
	  			$userstockupdate = updateuserStock($userID,$stockID);		
	  		}if($userstockupdate){
	  			$portfolioupdate = updatePortfolio($type,$invest,$profit,$sign,$transprofit,$userID,$profsign);
		  			if($portfolioupdate){ http_response_code(201);}
					else{	http_response_code(401); }
		  			}
	  		}
	}

	function updateBankProfit($userID,$profit){
		 $sql = "update bank set amount = amount+".$profit." where userID = '$userID'";
		return mysql_query($sql);
	}
	function addTranslog($transtype,$userID,$price,$qty,$date,$companyName,$symbol,$domain)	{
		  $query = "INSERT INTO `finzone_db`.`transactionlog`(`tansID`, `userID`, `transType`, `price`, `quantity`, `DateTime`, `companyName`, `symbol`, `domainID`)
									    				VALUES ('', '$userID', '$transtype', '$price', '$qty', 
									    				'$date', '$companyName','$symbol','$domain')";
	    return  mysql_query($query);
	}
	
	function updateuserStock($userID,$stockID)	{
		 $sql = "delete from usersStock where userID = '$userID' and stockID = '$stockID'";
		return mysql_query($sql);
	}
	
	function updatePortfolio($type,$invest,$profitvalue,$sign,$transprofit,$userID,$banksing)	{
	   $sql = "update portfolio set ".$type."=".$type."".$sign."".$invest." where userID = '$userID'";
	    return mysql_query($sql);
	} 	 

   	?>
	