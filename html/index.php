<?php
session_start();
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
coucou index general
<a href='http://localhost/fichiers/RGAA.pdf?csrf=<?= $_SESSION["csrf"] ?>'>ok</a>
<a href='http://localhost/fichiers/RGAA2.pdf'>ok</a>
<a href='http://localhost/fichiers/RGAA.bm.pdf'>pas ok</a>
<a href='http://localhost/fichiers/RGAA.jpg'>pas ok</a>
<a href='http://localhost/fichiers/bou.pdf'>pas ok</a>