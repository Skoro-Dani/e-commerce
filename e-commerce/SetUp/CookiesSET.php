<?php
include("connection.php");
session_start();
//controllo se esiste il cookie
if (!isset($_COOKIE["IDcarrelloCOOKIES"])) {
    //se non esiste lo creo
    $cookie_name = "IDcarrelloCOOKIES";
    $cookie_value = "";

    $sql = "INSERT INTO carrello () VALUES ()";

    if (mysqli_query($conn, $sql)) {
        $cookie_value = mysqli_insert_id($conn);
    }
    setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
} else {
    //se esiste mi salvo l'id del carrello
    $cookie_value = $_COOKIE["IDcarrelloCOOKIES"];
}
//controllo se esiste un utente
if (!isset($_SESSION["IDutente"]) || ($_SESSION["IDutente"]=="" || $_SESSION["IDutente"]==null)) {
    //se non esiste controllo che l'id del carrello non sia assegnato ad un utente con accesso
    $sql = $conn->prepare("SELECT ID FROM carrello where IdUtente is null and ID = ?");
    $sql->bind_param("i", $cookie_value);
    $sql->execute();
    $result = $sql->get_result();

    $bool = false;
    if ($result !== false && $result->num_rows > 0) {
        if ($row = $result->fetch_object()) {
            $_SESSION["IDcarrello"] = $row->ID;
        }
        $bool = true;
    }
    //se il carrello è assegnato a qualcuno creo un nuovo cookie con un nuovo valore
    if ($bool == false) {
        $cookie_name = "IDcarrelloCOOKIES";
        $cookie_value = "";

        $sql = "INSERT INTO carrello () VALUES ()";

        if (mysqli_query($conn, $sql)) {
            $cookie_value = mysqli_insert_id($conn);
        }

        setcookie($cookie_name, $cookie_value, time() + (86400 * 30), "/");
        $_SESSION["IDcarrello"] = $cookie_value;
    }
} else {
    //se la sessione esiste prendo l'id del carrello dal db
    $sql = $conn->prepare("SELECT max(ID) as ID FROM carrello where IdUtente = ?");
    $sql->bind_param("i", $_SESSION["IDutente"]);
    $sql->execute();
    $result = $sql->get_result();
    if ($result !== false && $result->num_rows > 0) {
        if ($row = $result->fetch_object()) {
            $_SESSION["IDcarrello"] = $row->ID;
        }
    }
}
