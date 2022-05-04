<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");

$ID = $_GET["ID"];
$quantita = $_GET["quantita"];

$sql = $conn->prepare("UPDATE articoli SET QuantitaDisp =QuantitaDisp + $quantita WHERE  ID = $ID");
$sql->execute();
