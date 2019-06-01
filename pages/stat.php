<?php
session_start();
if (!isset($_SESSION["nom"])) {
    echo '<h1>Connectez-vous</h1>';
    header('Location: ../index.php');
    exit();
}
$_SESSION["actif"] = "stat";
if (!isset($_GET["code"])) {
    header('Location: presence.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="FR-fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" media="screen" href="../css/MonStyle.css">
    <title>Accueil</title>
    <style>
    body{
        background-color: #222222;
        background-image: none;
    }
    .statt {
        margin-top: 2%;
        margin-bottom: 5%;
    }
    </style>
</head>

<body>
    <?php
    include("nav.php");
    ?>
    <header></header>
    <section class="container-fluid">
        <?php
        $fichier = fopen('emargement.txt', 'r');
            while (!feof($fichier)) {
                $line = fgets($fichier);
                $emargement = explode('|', $line);
                if(isset($_GET["code"]) && $_GET["code"]==$emargement[0]){
                    echo'<h1 class="textAccueil">'.$emargement[2].'</h1>';
                    break;
                }
            }
            fclose($fichier);
        ?>
        <div id="chartdiv" class="statt"></div>
        <?php
        $i=0;
            $fichier = fopen('emargement.txt', 'r');
            while (!feof($fichier)) {
                $line = fgets($fichier);
                $emargement = explode('|', $line);
                if(isset($_GET["code"]) && $_GET["code"]==$emargement[0]){
                    $i++;
                echo'<div id="jour'.$i.'" class="'.$emargement[3].'"></div>
                     <div id="arrivee'.$i.'" class="'.$emargement[4].'"></div>
                     <div id="depart'.$i.'" class="'.$emargement[5].'"></div>';

                }
            }
            fclose($fichier);
            echo'<div id="jourPresent" class="'.$i.'"></div>';
        ?>
    </section>   
    <?php
    echo "
            <footer class='piedPageaccueil'>
                <p class='cpr'>Copyright 2019 Sonatel Academy</p>
            </footer>";
    ?>
    <script src="../js/core.js"></script>
    <script src="../js/charts.js"></script>
    <script src="../js/animated.js"></script>
    <script src="../js/dark.js"></script>
    <script src="../js/stat.js"></script>
</body>

</html>