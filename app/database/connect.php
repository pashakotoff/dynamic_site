<?php
$driver = 'mysql';
$host = 'localhost';
$db_name = 'dynamic_site';
$db_user = 'root';
$db_pass = 'mysql';
$charset = 'utf8';
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC];

try{$pdo = new PDO("$driver:host=$host;db_name=$db_name;charset=$charset", $db_user, $db_pass, $options);

} catch
(PDOException $i){
    die("Ошибка подключения к базе данных");
}
