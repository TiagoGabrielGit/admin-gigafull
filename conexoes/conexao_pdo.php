<?php

//Credenciais de acesso ao BD
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', 'G#4feD3@4f3$f5#');
define('DBNAME', 'dbsistem');

$pdo = new PDO('mysql:host=' . HOST . ';dbname=' . DBNAME . ';', USER, PASS);
