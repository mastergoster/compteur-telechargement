<?php
session_start();
//var_dump($_GET["csrf"]);
//var_dump($_SESSION["csrf"]);
//var_dump($_SESSION["csrf"]);
//test si lutilisateur est connect ou autorisé
try {
    $pdo = new PDO('sqlite:' . dirname(__FILE__) . '/database.sqlite');
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // ERRMODE_WARNING | ERRMODE_EXCEPTION | ERRMODE_SILENT
} catch (Exception $e) {
    echo "Impossible d'accéder à la base de données SQLite : " . $e->getMessage();
    die();
}
$pdo->query("CREATE TABLE IF NOT EXISTS compteur ( 
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    fichier VARCHAR( 250 ),
    nombre VARCHAR( 250 )
);");
$urlresult = explode("/", $_GET["url"]);
if ($urlresult[0] != $_SESSION["csrf"]) {
    header("Location: http://localhost");

    exit();
}
//var_dump($urlresult);
//die();
if (isset($_GET["url"]) && !empty($_GET["url"]) && file_exists(dirname(dirname(__DIR__)) . '/ftp_files/' . end($urlresult))) {

    $fichier = explode(".", end($urlresult));
    if ($fichier[1] == "pdf") {
        $stm = $pdo->prepare("SELECT * FROM compteur WHERE fichier=?");
        $stm->execute([end($urlresult)]);
        $result = $stm->fetch();
        if ($result) {
            $stm = $pdo->prepare("UPDATE compteur SET nombre= ? WHERE id = ?");

            $stm->execute([$result["nombre"] + 1, $result["id"]]);
        } else {
            $stm = $pdo->prepare("INSERT INTO compteur (fichier, nombre) VALUES (?, 1) ");
            $stm->execute([end($urlresult)]);
        }


        header('Content-Type: application/pdf');

        echo file_get_contents(dirname(dirname(__DIR__)) . '/ftp_files/' . end($urlresult));
        exit;
    }
}
header("Location: http://localhost");
