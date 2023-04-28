<?php

$usuario = 'root';
$senha = '';
$database = 'dbsistem';
$host = 'localhost';

$mysqli = new mysqli($host, $usuario, $senha, $database);
$conn = new PDO("mysql:host=$host;dbname=".$database, $usuario, $senha);

if ($mysqli->error) {
    die("Falha ao conectar ao banco de dados" . $mysqli->error);
}
