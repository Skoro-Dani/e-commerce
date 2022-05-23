<?php
//////////////////////////////
//Reindirizzammento alla pagina corrretta
//////////////////////////////
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");

if(isset($_SESSION["IDutente"]))
header("location:AccountDati.php");
else header("location:Login.php");