<?php
//////////////////////////////
//Elimina un Indirizzo
//////////////////////////////
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");

$ID = $_GET["ID"];
$idutente = $_SESSION["IDutente"];


$sql_update = $conn->prepare("UPDATE indirizzo set IdUtente = null where ID = ?");
$sql_update->bind_param("i", $ID);

if ($sql_update->execute())  header("location:Account.php"); //OK
else ("location:Account.php?msg=Errore, non è stato possibile eliminare l'indirirzzo");

header("location:Account.php");
