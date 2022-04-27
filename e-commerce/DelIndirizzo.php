<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");

$sqlstring="SELECT ID FROM indirizzo WHERE ID = ? and IdUtente = ?";
echo $sqlstring;
echo $_GET["ID"].".". $_SESSION["IDutente"];
$sql = $conn->prepare($sqlstring);
$sql->bind_param("ii", $_GET["ID"], $_SESSION["IDutente"]);
$sql->execute();
$result = $sql->num_rows();
if ($sql->num_rows() > 0) {
    $sql_update = $conn->prepare("UPDATE indiririzzo set IdUtente = null where ID = ? ");
    $sql_update->bind_param("i", $_GET["ID"]);
    if ($sql_update->execute()) header("location:Account.php"); //OK
    else header("location:Account.php?msg=Errore, non è stato possibile eliminare l'indirirzzo");
}
header("location:Account.php");
