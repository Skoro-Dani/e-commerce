<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");

$username = $_POST["username"];
$password = md5($_POST["password"]);

$sql = $conn->prepare("SELECT * FROM utente WHERE username = ? AND password = ?");
$sql->bind_param('ss', $username, $password);

$sql->execute();
$result = $sql->get_result();
$funziona = false;
if ($result->num_rows > 0) {
  // output data of each row
  if ($row = $result->fetch_object()) {
    if($row->admin==1) $_SESSION["IsAdmin"]=1;
    else $_SESSION["IsAdmin"]=0;
    $_SESSION["IDutente"] = $row->ID;
    $funziona = true;
  }
}

if ($funziona == true) {
  $sql = $conn->prepare("SELECT * FROM carrello WHERE IdUtente = ". $_SESSION["IDutente"]);
  $sql->execute();
  $result = $sql->get_result();
  $funziona = false;
  if ($result->num_rows > 0) {
    // output data of each row
    if ($row = $result->fetch_object()) {
      header("location:SpostaCarrello.php?IDcarrelloNS=" . $_SESSION["IDcarrello"] . "&IDcarrelloYS=" . $row->ID);
    }
  }
} else header("location:Login.php?msg=Credenziali sbagliate");
echo "errore";
