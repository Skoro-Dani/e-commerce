<?php
//////////////////////////////
//Svolge il Logout
//////////////////////////////
include("SetUp/connection.php");

session_start();
session_unset();
session_destroy();

include("SetUp/CookiesSET.php");


header("location:index.php");
