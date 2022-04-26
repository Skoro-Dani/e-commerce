<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");

$sql = $conn->prepare("INSERT INTO indirizzo(IdUtente,stato,regione,provincia,citta,via,civico,cap) values(?,?,?,?,?,?,?,?)");
$sql->bind_param("isssssss", $_SESSION["IDutente"], $_POST["Stato"], $_POST["Regione"], $_POST["Provincia"], $_POST["Citta"], $_POST["via"], $_POST["Civico"], $_POST["Cap"]);
//$sql->execute();
//$errore=$sql -> error;
//echo $errore;/*
if ($sql->execute()) header("location:Account.php"); //OK
else header("location:AddIndirizzo.php?msg=Errore durante l'aggiunta dell'indirizzo");
