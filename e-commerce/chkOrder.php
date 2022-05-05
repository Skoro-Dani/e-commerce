<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");

date_default_timezone_set('Europe/Rome');
$time = date('H:i', time());
$date=date("d-m-Y");

$totale=CalcolaPrezzo();

$sql = $conn->prepare("INSERT INTO `ordine`(`IdCarrello`, `DataAcquisto`, `OraAcquisto`, `Prezzo`) VALUES(?,?,?,?)");
$sql->bind_param("issi", $_SESSION['IDcarrello'],$date,$time,$totale);
$sql->execute();

$IDordine= $sql->insert_id;

$sql = $conn->prepare("INSERT INTO carrello (IdUtente) VALUES (?)");
$sql->bind_param("i", $_SESSION['IDutente']);
$sql->execute();
$_SESSION["IDcarrello"]=$sql->insert_id;
header("location:index.php");

