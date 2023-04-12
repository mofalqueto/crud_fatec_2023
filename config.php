<?php

$host = "localhost"; // nome do servidor MySQL
$user = "id20421037_monicafalqueto"; // usuário do MySQL
$pass = "Aa111111--Bb"; // senha do MySQL
$dbname = "id20421037_game"; // nome do banco de dados

// Conexão com o banco de dados MySQL
$conn = mysqli_connect($host, $user, $pass, $dbname);

// Verifica se houve erro na conexão
if (!$conn) {
    die("Falha na conexão: " . mysqli_connect_error());
}
