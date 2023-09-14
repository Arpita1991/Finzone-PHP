<?php 
//https://finzone-db-arpitapatel.c9users.io/phpmyadmin

define('DBHOST', 'localhost');
 define('DBUSER', 'arpitapatel');
 define('DBPASS', '');
 define('DBNAME', 'finzone_db');
 
 $conn = mysql_connect(DBHOST,DBUSER,DBPASS);
 $dbcon = mysql_select_db(DBNAME);
 
 if ( !$conn ) {
  die("Connection failed : " . mysql_error());
 }
 
 if ( !$dbcon ) {
  die("Database Connection failed : " . mysql_error());
 }


?>
 