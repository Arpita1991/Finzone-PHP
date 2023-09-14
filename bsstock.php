<?php
ob_start();

	require('conn.php');
    require('userlog.php');
  

	if(empty($_REQUEST['companyName']) || empty($_REQUEST['email'])|| empty($_REQUEST['qty'])||
					empty($_REQUEST['price']) || empty($_REQUEST['domain']) || empty($_REQUEST['transtype']) ||
					empty($_REQUEST['symbol']))
    {
		  http_response_code(401);
	}
	else
	{
		  $companyName = trim($_REQUEST['companyName']);
	      $userID = getEmail(trim($_REQUEST['email']));
	      $qty = trim($_REQUEST['qty']);
	      $price = trim($_REQUEST['price']);
	      $domain = trim($_REQUEST['domain']);
	      $transtype = trim($_REQUEST['transtype']);
	      $symbol = trim($_REQUEST['symbol']);
	  	  $date =  date('d-m-y');
	
	
	       $buyingprice = ($price*$qty);
    
	      if($domain=='Buy') $domain='1';
	  		if($domain=='Sell') $domain='2';
	  	  if($transtype=='Stock') { 
	  			$transtype='1';
	  			$type='stockInvest';
	  		}	
	  		if($transtype=='Commodity'){
	  			$transtype='2';	
	  			$type='commoditiesInvest';
	  		} 
	  		if($transtype=='Forex') {
	  			$transtype='3';
	  			$type='forexInvest';
	  		}
	  		
	  		$sign = '+';
	  	
	  		$amount = checkbankammount($userID);

	  		if($amount >= $buyingprice){
	  			$userstock = adduserstock($transtype,$companyName,$date,$userID,$qty,$price,$symbol,$domain);
	  			if($userstock){
	  				 if($domain=='1') { $updatebankamount = updatebankamount($buyingprice,$userID);}
	  				 	$updateportfolio = updatePortfolio($type,$buyingprice,$sign,$userID);
	  				 	if($updateportfolio){
	  				 			http_response_code(201);
	  				 	}else{ http_response_code(401);}
	  			} else{ http_response_code(401);}
	  		}else{ http_response_code(401);}
	}
	
	function checkbankammount($userID)	{
		$qry = mysql_query("Select amount from bank where userID='$userID'");
		
	 if(!$qry || mysql_num_rows($qry) <= 0) { http_response_code(401);	}
		else
		{
			$amountdata = mysql_fetch_array($qry);
			$amount = $amountdata['amount'];
			return $amount;
		}
	}
	
	function adduserstock($transtype,$companyName,$date,$userID,$qty,$price,$symbol,$domain){
		
		$query = "INSERT INTO `finzone_db`.`usersStock`(`stockID` ,`transType`,`companyName` ,`DateTime` ,`userID` ,`qty` ,`price` ,`compnayTicker` ,`domainID`)
						    					VALUES ('' ,'$transtype','$companyName','$date','$userID','$qty','$price','$symbol','$domain')";
		$query = mysql_query($query);
		
		$query2 = "INSERT INTO `finzone_db`.`transactionlog`
									       (`tansID`, `userID`, `transType`, `price`, `quantity`, `DateTime`, `companyName`,`symbol`, `domainID`)
									       VALUES ('', '$userID', '$transtype', '$price', '$qty', '$date', '$companyName','$symbol', '$domain')";
		$query2 = mysql_query($query2);
		if(!$query || !$query2) return false;	
		else return true;
	}
	
	function updatebankamount($buyingprice,$userID){
			return mysql_query("update bank set amount = amount - ".$buyingprice." where userID='$userID'");
	}

	function updatePortfolio($type,$invest,$sign,$userID)	{
	    $sql = "update portfolio set ".$type."=".$type."".$sign."".$invest." where userID = '$userID'";
	    return mysql_query($sql);
	} 	 

   	?>
	