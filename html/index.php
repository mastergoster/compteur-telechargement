<?php
session_start();
//var_dump($_GET["url"]);
$url = explode("/", $_GET["url"]);
if ($url[0] == "css") {
    include 'css/style.css';
    die();
}
$_SESSION['csrf'] = uniqid();
try {
    $pdo = new PDO('sqlite:' . dirname(__FILE__) . '/fichiers/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
} catch (Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : " . $e->getMessage();
    die();
}
$stm = $pdo->prepare("SELECT * FROM compteur");
$stm->execute();
var_dump($stm->fetchAll());
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/machin.css">
</head>

<body>
    coucou index general
    <a href='http://localhost/fichiers/<?= $_SESSION["csrf"] ?>/RGAA.pdf'>ok</a>
    <a href='http://localhost/fichiers/RGAA2.pdf'>ok</a>
    <a href='http://localhost/fichiers/RGAA.bm.pdf'>pas ok</a>
    <a href='http://localhost/fichiers/RGAA.jpg'>pas ok</a>
    <a href='http://localhost/fichiers/bou.pdf'>pas ok</a>
</body>

</html>