<?php
    $myServer   = "localhost";
    $myUser     = "ultimate_ec";
    $myPass     = "#s[H_z-*MFS)";
    $myDB       = "ultimate_ec";
    
    //connection to the database
    $dbhandle = mysql_connect($myServer, $myUser, $myPass)
        or die("Couldn't connect to SQL Server on $myServer"); 
    
    //select a database to work with
    $selected = mysql_select_db($myDB, $dbhandle)
        or die("Couldn't open database $myDB");  
?>