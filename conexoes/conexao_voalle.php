<?php
$integracao_voalle = "SELECT iv.host_db, iv.user_db, iv.pass_db FROM integracao_voalle as iv WHERE iv.id = 1";
$stmt_iv = $pdo->query($integracao_voalle);
$row = $stmt_iv->fetch(PDO::FETCH_ASSOC);

$host_db = $row['host_db'];
$user_db = $row['user_db'];
$pass_db = $row['pass_db'];

try {
    $pgsql_pdo = new PDO("pgsql:host=$host_db;port=5432;dbname=dbemp00155;user=$user_db;password=$pass_db");
    $pgsql_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão PostgreSQL: " . $e->getMessage());
}