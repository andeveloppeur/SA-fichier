<?php
session_start();
if (!isset($_SESSION["nom"])) {
    echo '<h1>Connectez-vous</h1>';
    header('Location: ../index.php');
    exit();
}
$_SESSION["actif"] = "presence";
$Promo="";
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
    <title>Emargement</title>
</head>

<body>
    <?php
    include("nav.php");
    ?>
    <header></header>
    <section class="container-fluid  pageLister">
        <?php
        $FichierVide=true;
        $sortie=false;
        $heureDepart="";
       $monfichier = fopen('emargement.txt', 'r');
        while (!feof($monfichier)) {
            $ligne = fgets($monfichier);
            $etudiant = explode('|', $ligne);
            if(isset($etudiant[1])){
                $FichierVide=false;
            }
            if (isset($_GET["code"]) && $etudiant[0]==$_GET["code"] && $etudiant[3]==date('d-m-Y')||isset($_POST["code"]) && $etudiant[0]==$_POST["code"] && $etudiant[3]==date('d-m-Y')){
                $sortie=true;
                $heurArrive=$etudiant[4];
            }
        }
        fclose($monfichier);
            ///////////////////////////-------rechercher par jour---------------------//////////////////////
            
        echo'<form method="POST" action="" class="MonForm row insc">
                <div class="col-md-3"></div>
                <div class="col-md-6 bor">';
                echo '<div class="row">
                    <div class="col-md-2"></div>
                    <input type="date" class="form-control col-md-8 espace" name="jourRech" '; if(!isset($_POST["jourRech"])){echo' value="'.date('Y-m-d').'" ';}else{echo' value="'.$_POST["jourRech"].'" ';} echo'>
                </div>';
                ///////////////////////////-------Promo---------------------//////////////////////
                echo '<div class="row">
                        <div class="col-md-2"></div>
                        <select class="form-control col-md-8 espace" name="promo" >';
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
                echo '</select>
                    </div>';
                ///////////////////////////-------Fin Promo---------------------//////////////////////

                /////////////////////////////-------Present/absent---------------------//////////////////////      
                echo '<div class="row">
                    <div class="col-md-2"></div>
                    <select class="form-control col-md-8 espace" name="presence" >
                        <option value="present" ';if(isset($_POST["presence"]) && $_POST["presence"]=="present"){echo' selected';}echo'>Présents</option>
                        <option value="absents" ';if(isset($_POST["presence"]) && $_POST["presence"]=="absents"){echo' selected';}echo'>Absents</option>
                    </select>                   
                </div>';
                ///////////////////////////-------Fin Present/absent---------------------//////////////////////

                echo '<div class="row">
                    <div class="col-md-3"></div>
                    <input type="submit" class="form-control col-md-6 espace" value="Lister" name="validerRechJour">
                </div>
                </div>
            </form>';
        
        ///////////////////////////-------rechercher par jour---------------------//////////////////////
        ?>
        <?php 
            $monfichier = fopen('emargement.txt', 'r');
            while (!feof($monfichier)) {
                $ligne = fgets($monfichier);
                $etudiant = explode('|', $ligne);
                if(isset($etudiant[2])) break;
            }
            fclose($monfichier);

            if(isset($etudiant[2]) || isset($_POST["validerRechJour"])){   //donc le fichier n'est pas vide ou qu'on appuis sur le submit
            echo '<table class="col-12 tabliste table">
            <thead class="thead-dark">
                <tr class="row">
                    <td class="col-md-2 text-center gras">N° CI</td>
                    <td class="col-md-2 text-center gras">Promo</td>
                    <td class="col-md-2 text-center gras">Nom</td>
                    <td class="col-md-2 text-center gras">Date</td>
                    <td class="col-md-2 text-center gras">Arrivée</td>
                    <td class="col-md-1 text-center gras">Sortie</td>
                    <td class="col-md-1 text-center gras">Stats</td>
                </tr>
            </thead>';
            }
            /////////////////////////////////////////------Debut Affichage-----///////////////////////// 
            if(isset($_POST["jourRech"])){
                $datN = new DateTime($_POST["jourRech"]);
                $date = $datN->format('d-m-Y');
            }
            ///////////////////////////////////////////----Present----//////////////////////////////////////////////
            if(!isset($_POST["validerRechJour"])|| isset($_POST["validerRechJour"]) && $_POST["presence"]=="present"){
                $monfichier = fopen('emargement.txt', 'r');            
                while (!feof($monfichier)) {
                    $ligne = fgets($monfichier);
                    $etudiant = explode('|', $ligne);
                    if (!isset($_POST["validerRechJour"]) && isset($etudiant[3]) && $etudiant[3]==date('d-m-Y')||
                    isset($_POST["validerRechJour"]) && isset($etudiant[3]) && $etudiant[3]==$date && $etudiant[1]==$_POST["promo"] && $_POST["presence"]=="present") {
                        echo
                        '<tr class="row">
                            <td class="col-md-2 text-center">' . $etudiant[0] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[1] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[2] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[3] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[4] . '</td>
                            <td class="col-md-1 text-center">' . $etudiant[5] . '</td>
                            <td class="col-md-1 text-center"><a href="stat.php?code=' . $etudiant[0] . '" ><button class="form-control" >Stat</button></a></td>
                        </tr>';
                    }
                }
                fclose($monfichier);
            }
            ///////////////////////////////////////////----Fin Present----//////////////////////////////////////////////

            ///////////////////////////////////////////----Absents----//////////////////////////////////////////////
            if(isset($_POST["validerRechJour"]) && $_POST["presence"]=="absents"){
                $monfichier = fopen('etudiants.txt', 'r');            
                while (!feof($monfichier)) {
                    $ligne = fgets($monfichier);
                    $etudiant = explode('|', $ligne);

                    $absent=true;
                    $fichier = fopen('emargement.txt', 'r');            
                    while (!feof($fichier)) {
                        $ligne = fgets($fichier);
                        $emarger = explode('|', $ligne);
                        $datN = new DateTime($_POST["jourRech"]);
                        $date = $datN->format('d-m-Y');
                        if($etudiant[0]==$emarger[0] && $emarger[3]==$date){
                            $absent=false;
                        }
                    }
                    fclose($fichier);
                    if($absent==true && $_POST["promo"]==$etudiant[1]){
                         echo
                        '<tr class="row">
                            <td class="col-md-2 text-center">' . $etudiant[0] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[1] . '</td>
                            <td class="col-md-2 text-center">' . $etudiant[2] . '</td>
                            <td class="col-md-2 text-center">' . $date . '</td>
                            <td class="col-md-2 text-center">--:--</td>
                            <td class="col-md-1 text-center">--:--</td>
                            <td class="col-md-1 text-center"><a href="stat.php?code=' . $etudiant[0] . '" ><button class="form-control" >Stat</button></a></td>
                        </tr>';
                    }
                }
                fclose($monfichier);
            }
            ///////////////////////////////////////////----Fin Absents----//////////////////////////////////////////////

            ####################################------Fin Affichage-----#################################

            ////////////////////////////----------------Debut Export-----------///////////////////////////
            if(isset($_POST["export"])){
                
                ////////////////-----etudiants.txt----//////////
                $tout="";
                $monfichier = fopen('etudiants.txt', 'r');            
                while (!feof($monfichier)) {
                    $ligne = fgets($monfichier);
                    $tout=$tout.$ligne;
                }
                fclose($monfichier);
                $tout=str_ireplace("|",";",$tout);

                $monfichier = fopen('../Exportation/etudiants '.date('d-m-Y').'.csv', 'w+');
                fwrite($monfichier,$tout);
                fclose($monfichier);
                ////////////////---Fin etudiants.txt----//////////
                
                 ////////////////-----emargement.txt----//////////
                $tout="";
                $monfichier = fopen('emargement.txt', 'r');            
                while (!feof($monfichier)) {
                    $ligne = fgets($monfichier);
                    $tout=$tout.$ligne;
                }
                fclose($monfichier);
                $tout=str_ireplace("|",";",$tout);
                $monfichier = fopen('../Exportation/emargement '.date('d-m-Y').'.csv', 'w+');
                fwrite($monfichier,$tout);
                fclose($monfichier);
                ////////////////---Fin emargement.txt----//////////
                
                 ////////////////-----promos.txt----//////////
                $tout="";
                $monfichier = fopen('promos.txt', 'r');            
                while (!feof($monfichier)) {
                    $ligne = fgets($monfichier);
                    $tout=$tout.$ligne;
                }
                fclose($monfichier);
                $tout=str_ireplace("|",";",$tout);
                $monfichier = fopen('../Exportation/promos '.date('d-m-Y').'.csv', 'w+');
                fwrite($monfichier,$tout);
                fclose($monfichier);
                ////////////////---Fin promos.txt----//////////
                
                 ////////////////-----visiteur.txt----//////////
                $tout="";
                $monfichier = fopen('visiteur.txt', 'r');            
                while (!feof($monfichier)) {
                    $ligne = fgets($monfichier);
                    $tout=$tout.$ligne;
                }
                fclose($monfichier);
                $tout=str_ireplace("|",";",$tout);
                $monfichier = fopen('../Exportation/visiteur '.date('d-m-Y').'.csv', 'w+');
                fwrite($monfichier,$tout);
                fclose($monfichier);
                ////////////////---Fin visiteur.txt----//////////
            }
            ####################################---------Fin Export-----------#############################
        ?>
        </table>
    </section>
    <?php
    include("piedDePage.php");
    ?>
</body>

</html>