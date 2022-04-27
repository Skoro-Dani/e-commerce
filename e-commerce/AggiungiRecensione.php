<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");

$testo = $_POST["testo"];
if(isset($_POST["rating"])) $rating = $_POST["rating"];
else $rating=0;
$verifica = IsVerificato($_POST["IDarticolo"],$_SESSION["IDutente"]);

$sqli = $conn->prepare("INSERT INTO `commento`(`IdArticolo`, `IdUtente`, `AcquistoVerificato`, `testo`, `stelleCommento`) VALUES (?,?,?,?,?) ");
$sqli->bind_param("iiisi", $_POST["IDarticolo"], $_SESSION["IDutente"], $verifica, $testo, $rating);

$sqli->execute();
echo $sqli->error;
if ($sqli->error == "" || $sqli->error == null) header("location:product.php?ID=" . $_POST["IDarticolo"]);
else header("location:product.php?ID=" . $_POST["IDarticolo"]);
