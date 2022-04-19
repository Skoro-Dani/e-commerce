<?php
include("SetUp/connection.php");
include("SetUp/CookiesSET.php");

$username = $_POST["username"];
$password = md5($_POST["password"]);

$sql = $conn->prepare("SELECT id,username FROM utente WHERE username = ? AND password = ?");
$sql->bind_param('ss', $username, $password);

$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
  // output data of each row
  if ($row = $result->fetch_assoc()) {
    $_SESSION["IDutente"] = $row["id"];
  }
  header("location:Login.php");
} else {
  header("location:Login.php?msg=Credenziali sbagliate");
}
$conn->close();
