<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");
if (isAdmin() == 1) {
    $SQLSTRING = "DELETE FROM `articoli` WHERE ID = " . $_GET["ID"];
    //echo $SQLSTRING;
    $sql = $conn->prepare($SQLSTRING);
    $sql->execute();
}
