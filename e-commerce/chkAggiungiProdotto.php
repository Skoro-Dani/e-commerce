<?php
//////////////////////////////
//Check Aggiungi prodotto
//////////////////////////////
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");
if (isAdmin() == 1) {
    $categorie = "";
    if (isset($_POST["c1"]) && $categorie == "") $categorie .= $_POST["c1"];
    else if (isset($_POST["c1"])) $categorie .= "," . $_POST["c1"];
    if (isset($_POST["c2"]) && $categorie == "") $categorie .= $_POST["c2"];
    else if (isset($_POST["c2"])) $categorie .= "," . $_POST["c2"];
    if (isset($_POST["c3"]) && $categorie == "") $categorie .= $_POST["c3"];
    else if (isset($_POST["c3"])) $categorie .= "," . $_POST["c3"];
    if (isset($_POST["c4"]) && $categorie == "") $categorie .= $_POST["c4"];
    else if (isset($_POST["c4"])) $categorie .= "," . $_POST["c4"];
    if (isset($_POST["c5"]) && $categorie == "") $categorie .= $_POST["c5"];
    else if (isset($_POST["c5"])) $categorie .= "," . $_POST["c5"];
    if (isset($_POST["c6"]) && $categorie == "") $categorie .= $_POST["c6"];
    else if (isset($_POST["c6"])) $categorie .= "," . $_POST["c6"];

    $sql_get = $conn->prepare("INSERT INTO `articoli`(`Nome`, `DescShort`, `DescLong`, `QuantitaDisp`, `Prezzo`, `Venditore`, `sconto`, `Categorie`) VALUES(?,?,?,?,?,?,?,?)");
    $sql_get->bind_param("sssiisis", $_POST["Nome"], $_POST["DescShort"], $_POST["DescLong"], $_POST["QuantitaDisp"], $_POST["Prezzo"], $_POST["Venditore"], $_POST["Sconto"], $categorie);
    $sql_get->execute();

    $count = 1;
    $Esiste = true;
    while ($Esiste == true) {
        if (isset($_FILES['imgsrc' . $count]['name']) && $_FILES['imgsrc' . $count]['name'] != "") {
            $nomefile = $_FILES['imgsrc' . $count]['name'];
            //echo $nomefile;
            $uploaddir = 'imgUtenti/';
            $uploadfile = $uploaddir . basename($_FILES['imgsrc' . $count]['name']);
            $idarticolo = $sql_get->insert_id;
            $sql = $conn->prepare("INSERT INTO `imgsrc`(`IDarticolo`, `source`) VALUES (?,?)");
            $sql->bind_param("is", $idarticolo, $nomefile);
            $sql->execute();
            $count += 1;
        } else $Esiste = false;
    }
}
header("location:index.php");
