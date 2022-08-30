<?php
session_start();
$base = 'http://127.0.0.1/devsbookOO/';
$db_name = 'devsbook';
$db_hos = '127.0.0.1';
$db_user = 'root';
$db_pass = '';
$pdo = new PDO('mysql:dbname' . $db_name . ';host=' . $db_hos, $db_user, $db_pass);
