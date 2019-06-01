<?php
session_start();
if (!isset($_SESSION["nom"])) {
    echo '<h1>Connectez-vous</h1>';
    header('Location: ../index.php');
    exit();
}
$_SESSION["actif"] = "accueil";
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
</head>

<body>
    <?php
    include("nav.php");
    ?>
    <header></header>
    <section class="container-fluid">
        <h1 class="textAccueil">Pourcentage d'étudiants présents/absents</h1>
        
        <?php
        ///////////////////////////-------rechercher par jour---------------------//////////////////////
        echo'<form method="POST" action="" class="monformAcc row insc">
                <div class="col-md-3"></div>
                <div class="col-md-6 bor">';
                echo '<div class="row">
                    <div class="col-md-2"></div>
                    <input type="date" class="form-control col-md-8 espace" name="jourRech" value="';if(!isset($_POST["jourRech"])){echo date('Y-m-d');}else{echo $_POST["jourRech"];}echo'">
                </div>';
                echo '<div class="row">
                    <div class="col-md-3"></div>
                    <input type="submit" class="form-control col-md-6 espace" value="Lister" name="valider">
                </div>
                </div>
            </form>';
        ///////////////////////////-------rechercher par jour---------------------//////////////////////
        ?>
        <a href="presence.php"><div id="chartdiv"></div></a>
        <?php
        $i=0;
        if(isset($_POST["valider"])){
            $datN = new DateTime($_POST["jourRech"]);
            $date = $datN->format('d-m-Y');
        }
        $monfichier = fopen('promos.txt', 'r');
        while (!feof($monfichier)) {
            $ligne = fgets($monfichier);
            $promo = explode('|', $ligne);
            //////------compter effectif---//////
            $effectif = 0;
            $fichier = fopen('etudiants.txt', 'r');
            while (!feof($fichier)) {
                $line = fgets($fichier);
                $etudiant = explode('|', $line);
                if (isset($etudiant[1]) && isset($promo[1]) && $promo[1] == $etudiant[1]) {
                    $effectif++;
                }
            }
            fclose($fichier);
            //////------Fin compter effectif---//////

            ////////------compter emarger---///////
            $emarger=0;
            $fichier = fopen('emargement.txt', 'r');
            while (!feof($fichier)) {
                $line = fgets($fichier);
                $etudiant = explode('|', $line);
                if (isset($etudiant[1]) && isset($promo[1]) && $promo[1] == $etudiant[1] && $etudiant[3]==date('d-m-Y') && !isset($_POST["valider"]) || isset($_POST["valider"]) && isset($etudiant[1]) && isset($promo[1]) && $promo[1] == $etudiant[1] && $etudiant[3]==$date) {
                    $emarger++;
                }
            }
            fclose($fichier);
            //////------Fin compter emarger---//////
            $absent=$effectif-$emarger;
            $i++;
            echo'<div id="present'.$i.'" class="'.$emarger.'"></div>
                 <div id="absent'.$i.'" class="'.$absent.'"></div>';
        }
        fclose($monfichier);
     
        echo "<h2 class='bienv'></h2>
        </section>
            <footer class='piedPageaccueil'>
                <p class='cpr'>Copyright 2019 Sonatel Academy</p>
            </footer>";
        ?>
    <script src="../js/core.js"></script>
    <script src="../js/charts.js"></script>
    <script src="../js/animated.js"></script>
    <script src="../js/index.js"></script>
</body>

</html>