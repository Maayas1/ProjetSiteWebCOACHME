<?php 

$server = "localhost";
$user = "root";
$pass = "";
$database = "coach_appointment";

$conn = mysqli_connect($server, $user, $pass, $database);

if (!$conn) {
    die("<script>alert('Erreur de connexion a la base de donnée.')</script>");
}

?>