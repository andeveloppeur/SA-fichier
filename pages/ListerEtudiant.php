<?php
session_start();
if (!isset($_SESSION["nom"])) {
    echo '<h1>Connectez-vous</h1>';
    header('Location: ../index.php');
    exit();
}
$_SESSION["actif"] = "ListerEtudiant";
if (isset($_GET["promo"])) {
    $Promo = $_GET["promo"];
} 
elseif (isset($_POST["promo"])) {
    $Promo = $_POST["promo"];
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
    <title>Liste des étudiants</title>
</head>

<body>
    <?php
    include("nav.php");
    ?>
    <header></header>
    <section class="container-fluid pageLister">
        <form method="POST" action="ListerEtudiant.php" class="MonForm row insc">
            <div class="col-md-3"></div>
            <div class="col-md-6 bor">
                <?php
                ///////////////////////////-------Promo---------------------//////////////////////
                echo '<div class="row">
                        <div class="col-md-2"></div>
                        <select class="form-control col-md-8 espace" name="promo" >';
                if(!isset($_POST["recherche"]) && !isset($_POST["aRechercher"])||isset($_POST["recherche"]) && empty($_POST["aRechercher"])|| isset($_POST["finRecherche"])){
                    $monfichier = fopen("promos.txt", "r");
                    while (!feof($monfichier)) {
                        $ligne = fgets($monfichier);
                        $etudiants = explode("|", $ligne);
                        if ($Promo == $etudiants[1]) {
                            echo '<option value="' . $etudiants[1] . '" selected>' . $etudiants[1] . '</option>';
                        } 
                        else {
                            echo '<option value="' . $etudiants[1] . '">' . $etudiants[1] . '</option>';
                        }
                    }
                    fclose($monfichier);
                }
                elseif(isset($_POST["recherche"])){
                    echo '<option value="">Rechercher dans tous les référentiels</option>';
                }
                echo '</select>
                    </div>';
                ///////////////////////////-------Fin Promo---------------------//////////////////////

                ///////////////////////////---------Nom---------------------//////////////////////
                echo '<div class="row">
                <div class="col-md-2"></div>
                <input type="text" class="form-control col-md-8 espace" '; if(isset($_POST["nom"])){echo' value="'.$_POST["nom"].'" ';}  echo' name="nom" placeholder="Nom de l\'apprenant">
                </div>';
                ///////////////////////////-------Fin Nom---------------------//////////////////////

                echo '<div class="row">
                <div class="col-md-3"></div>
                <input type="submit" class="form-control col-md-6 espace" value="Lister" name="valider">
                </div>';
                ?>
            </div>
        </form>
        <?php
        //if (isset($_POST["promo"]) || isset($_GET["promo"])) {
            echo '<table class="col-12 tabliste table">
            <thead class="thead-dark">
                <tr class="row">
                    <td class="col-md-2 text-center gras">N° CI</td>
                    <td class="col-md-1 text-center gras">Référentiel</td>
                    <td class="col-md-2 text-center gras">Nom</td>
                    <td class="col-md-2 text-center gras">Date de naissance</td>
                    <td class="col-md-1 text-center gras">Téléphone</td>
                    <td class="col-md-3 text-center gras">Email</td>
                    <td class="col-md-1 text-center gras">Emarger</td>
                </tr>
            </thead>';

            /////////////////////////////////////////------Debut Affichage-----///////////////////////// 
            $actualisation=false;
            $monfichier = fopen('etudiants.txt', 'r');
            while (!feof($monfichier)) {
                $ligne = fgets($monfichier);
                $etudiant = explode('|', $ligne);
                if (!isset($_POST["valider"]) && isset($etudiant[1]) && $etudiant[1] == "Dev Web" && !isset($_GET["promo"])){
                    $Promo="Dev Web";
                    $actualisation=true;
                }
                if ($actualisation==true && !isset($_POST["recherche"])&& $etudiant[1] == "Dev Web"||isset($Promo) && isset($etudiant[1]) && $etudiant[1] == $Promo && empty($_POST["nom"]) && !isset($_POST["recherche"])|| 
                isset($Promo) && isset($etudiant[1]) && $etudiant[1] == $Promo && !empty($_POST["nom"]) && strstr(strtolower($etudiant[2]),strtolower($_POST["nom"]))&& !isset($_POST["recherche"])||
                isset($_POST["recherche"]) && !empty($_POST["aRechercher"]) && strstr(strtolower($ligne), strtolower($_POST["aRechercher"])) || 
                $etudiant[0] != "" && isset($_POST["recherche"]) && empty($_POST["aRechercher"])&& $etudiant[1] == "Dev Web") {
                    echo
                        '<tr class="row">
                            <td class="col-md-2 text-center">' . $etudiant[0] . '</td>
                            <td class="col-md-1 text-center">' . $etudiant[1] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[2] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[3] . '</td>
                            <td class="col-md-1 text-center">' . $etudiant[4] . '</td>
                            <td class="col-md-3 text-center">' . $etudiant[5] . '</td>
                            <td class="col-md-1 text-center"><a href="emargement.php?code=' . $etudiant[0] . '&promo=' . $Promo .  '"   id="' . $etudiant[0] . '" ><button class="btn btn-outline-primary" >Emarger</button></a></td>
                        </tr>';
                }
            }
            fclose($monfichier);
            ####################################------Fin Affichage-----#################################
        //}
        ?>
        </table>
    </section>
    <?php
    include("piedDePage.php");
    ?>
</body>

</html>