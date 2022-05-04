<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");
if (isAdmin() == 0) header("location:index.php");

$SQLSTRING ="DELETE FROM `articoli` WHERE ID = ".$_GET["ID"];
//echo $SQLSTRING;
$sql = $conn->prepare($SQLSTRING);
$sql->execute();
header("location:index.php");

