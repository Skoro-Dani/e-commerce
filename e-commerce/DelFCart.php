<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");

$sql = $conn->prepare("SELECT * FROM contiene WHERE IdArticolo = ? and IdCarrello = ?");
$sql->bind_param('ii', $_GET["IDarticolo"], $_SESSION["IDcarrello"]);
$sql->execute();
$result = $sql->get_result();
$Esiste = false;
$ID = 0;
$quantita = 0;
$msg = "";

if ($result !== false && $result->num_rows > 0) {
    if ($row = $result->fetch_object()) {
        $Esiste = true;
        $ID = $row->IdArticolo;
        $quantita = $row->quantita;
    }
}

if ($Esiste == true) {
    $sql = "DELETE FROM contiene WHERE IdArticolo = $ID and IdCarrello = " . $_SESSION["IDcarrello"];

    //echo $sql;
    if ($conn->query($sql) === TRUE) {
        if ($Esiste == true) {
            $sql = "UPDATE articoli SET QuantitaDisp = QuantitaDisp + $quantita WHERE  ID = $ID";
            $conn->query($sql);
        } else {
            $msg = "Errore";
        }
    }
} else $msg = "Errore prodotto non trovato";



header("location:" . $_GET["Pagina"] . "?msg=$msg");
