<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");

$sql = $conn->prepare("SELECT * FROM contiene WHERE IdArticolo = ? and IdCarrello = ?");
$sql->bind_param('ii', $_GET["IDarticolo"], $_SESSION["IDcarrello"]);
$sql->execute();
$result = $sql->get_result();
$quantita =  $_GET["quantita"];
$Esiste = false;
$ID = 0;
if ($result !== false && $result->num_rows > 0) {
    if ($row = $result->fetch_object()) {
        $Esiste = true;
        $ID = $row->ID;
    }
}
$sql = "UPDATE articoli SET QuantitaDisp = QuantitaDisp - $quantita WHERE QuantitaDisp >= $quantita and ID = $ID";

if ($conn->query($sql) === TRUE) {
    if ($Esiste == true) {
        $sql = $conn->prepare("UPDATE contiene SET quantita = quantita + $quantita WHERE ID = $ID");
        $sql->execute();
        $result = $sql->get_result();
    } else {

        $sql = $conn->prepare("INSERT INTO contiene(IdArticolo,IdCarrello,quantita) VALUES (?,?,?)");
        $sql->bind_param('iii', $_GET["IDarticolo"], $_SESSION["IDcarrello"], $_GET["quantita"]);
        $sql->execute();
        $result = $sql->get_result();
    }
}



header("location:" . $_GET["Pagina"]);
