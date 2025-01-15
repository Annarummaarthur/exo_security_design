<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "security_design";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die('<p class="error">Erreur de connexion à la base de données : ' . $conn->connect_error . '</p>');
}
?>
