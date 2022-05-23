<?php
//////////////////////////////
//Aggiunge o toglie la quantità
//////////////////////////////
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");
if (isAdmin() == 1) {
    $ID = $_GET["ID"];
    $quantita = $_GET["quantita"];

    $sql = $conn->prepare("UPDATE articoli SET QuantitaDisp =QuantitaDisp + $quantita WHERE  ID = $ID");
    $sql->execute();
}
