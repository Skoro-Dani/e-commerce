<?php
//////////////////////////////
//Aggiunge un prodotto al carrello
//////////////////////////////
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");

$sql = $conn->prepare("SELECT * FROM contiene WHERE IdArticolo = ? and IdCarrello = ?");
$sql->bind_param('ii', $_GET["IDarticolo"], $_SESSION["IDcarrello"]);
$sql->execute();
$result = $sql->get_result();
$quantita =  $_GET["quantita"];

$Esiste = false;
$ID = $ID=$_GET["IDarticolo"]; ;
if ($result !== false && $result->num_rows > 0) {
    if ($row = $result->fetch_object()) {
        $Esiste = true;
    }
}

$sql = "UPDATE articoli SET QuantitaDisp = QuantitaDisp - ".intval($quantita)." WHERE QuantitaDisp >= $quantita and ID = $ID";

if ($conn->query($sql) === TRUE) {

    if ($Esiste == true) {
        $sqli = $conn->prepare("UPDATE contiene SET quantita = quantita + $quantita WHERE ID = $ID");
        $sqli->execute();

    } else {   
        $sqli = $conn->prepare("INSERT INTO contiene(IdArticolo,IdCarrello,quantita) VALUES (?,?,?)");
        $sqli->bind_param('iii', $_GET["IDarticolo"], $_SESSION["IDcarrello"], $_GET["quantita"]);
        $sqli->execute();
    }
}



header("location:" . $_GET["Pagina"]);
