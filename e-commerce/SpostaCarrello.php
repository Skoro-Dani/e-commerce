<?php
//////////////////////////////
//Sposta tutti gli elementi dal carello provvisorio a quello effettivo dell'account
//////////////////////////////
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");

$IDcarrelloNS = $_GET["IDcarrelloNS"];
$IDcarrelloYS = $_GET["IDcarrelloYS"];

$sql = $conn->prepare("SELECT * FROM contiene WHERE IdCarrello = ?");
$sql->bind_param('i', $IDcarrelloNS);

$sql->execute();
$result = $sql->get_result();
$arrIDart = null;
$arrQuantita = null;
if ($result !== false && $result->num_rows > 0) {
    for ($j = 0; $j < $result->num_rows; $j++) {
        if ($row = $result->fetch_object()) {
            $arrIDart[] = $row->IdArticolo;
            $arrQuantita[] = $row->quantita;
        }
    }
}
if ($arrIDart != null) {
    for ($i = 0; $i < Count($arrIDart); $i++) {
        $sql = $conn->prepare("SELECT * FROM contiene WHERE IdArticolo = ? and IdCarrello = ?");
        $sql->bind_param('ii', $arrIDart[$i], $IDcarrelloYS);
        $sql->execute();
        $result = $sql->get_result();
        $Esiste = false;
        $ID = 0;
        if ($result !== false && $result->num_rows > 0) {
            if ($row = $result->fetch_object()) {
                $Esiste = true;
                $ID = $row->ID;
            }
        }
        if ($Esiste == true) {
            $sql = $conn->prepare("UPDATE contiene SET quantita = quantita + $arrQuantita[$i] WHERE ID = $ID");
            $sql->execute();
            $result = $sql->get_result();
        } else {

            $sql = $conn->prepare("INSERT INTO contiene(IdArticolo,IdCarrello,quantita) VALUES (?,?,?)");
            $sql->bind_param('iii', $arrIDart[$i], $IDcarrelloYS, $arrQuantita[$i]);
            $sql->execute();
            $result = $sql->get_result();
        }
    }
    for ($i = 0; $i < Count($arrIDart); $i++) {
        $sql = $conn->prepare("DELETE FROM contiene WHERE IdCarrello = $IDcarrelloNS");
        $sql->execute();
        $result = $sql->get_result();
    }
}
header("location:index.php");
