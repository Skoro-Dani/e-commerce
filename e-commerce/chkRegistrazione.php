<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");
include("Funzioni.php");

$sql_get = $conn->prepare("SELECT username FROM utente where username like ?");
$sql_get->bind_param("s", $_POST["username"]);
$sql_get->execute();
$result_get = $sql_get->get_result();

if ($result_get->num_rows == 0) {
    $password = md5($_POST["password"]);
    if ($_FILES['imgsrc']['name'] != "") {
        $nomefile = $_FILES['imgsrc']['name'];
        $uploaddir = 'imgUtenti/';
        $uploadfile = $uploaddir . basename($_FILES['imgsrc']['name']);
        move_uploaded_file($_FILES['imgsrc']['tmp_name'], $uploadfile);

        $sql = $conn->prepare("INSERT INTO utente(username,password,nome,cognome,imgsrc) values(?,?,?,?,?)");
        $sql->bind_param("sssss", $_POST["username"], $password, $_POST["Nome"], $_POST["Cognome"], $nomefile);
    } else {

        $sql = $conn->prepare("INSERT INTO utente(username,password,nome,cognome) values(?,?,?,?)");
        $sql->bind_param("ssss", $_POST["username"], $password, $_POST["Nome"], $_POST["Cognome"]);
    }

    if ($sql->execute()) 
    {
        $_SESSION["IDutente"]=$sql->insert_id;
        header("location:AddIndirizzo.php"); //OK
    }
    else header("location:AccountRegistrati.php?msg=Errore durante la registrazione");
}else header("location:AccountRegistrati.php?msg=nome utente gia in uso");
