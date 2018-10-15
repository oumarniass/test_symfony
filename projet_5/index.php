<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#"><h1><?php echo getcwd();?></h1></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Acceuil<span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="index.php" id="createfolder">Creer un Dossier</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Ajouter un fichier</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="index.php" id="delete">Supprimer</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Renomer Fichier</a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Copier Fichier</a>
            </li>

        </ul>

    </div>
</nav>
<div class="container">

<?php echo "<br><br>";

?>
<form enctype="multipart/form-data" action="index.php" method="POST">
    <p>Upload your file</p>
    <input type="file" name="uploaded_file"></input><br />
    <input type="submit" value="Upload"></input>
</form>
<?PHP
function upload(){
    if(!empty($_FILES['uploaded_file']))
    {
        $path = "upload/";
        $path = $path . basename( $_FILES['uploaded_file']['name']);
        if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $path)) {
            echo "Le fichier ".  basename( $_FILES['uploaded_file']['name']).
                " v a été enregistrez avez succés ";
        } else{
            echo "Il y a une erreurs veillez réessayez svp";
        }
    }
}
upload();
?>
<form method="GET" action="index.php" id="creerdossier">
    <input type="hidden" >
    <input type="text" name="action" value="mkdir">
    <input type="submit" name="test" value="creer">
</form>
    <script>
        var creerdossier = document.getElementById('creerdossier');
        var createfolder = document.getElementById('createfolder');
    //    creerdossier.style.display="none";
        createfolder.addEventListener('click',formulaire1);
        function formulaire1(event)
        {
            creerdossier.style.display="block";
        }
    </script>
<?php
echo "<div id='delete1'>";
echo "<p><font face=\"verdana\" size=\"2\">";
        echo "<form method=\"post\">";
            echo "veillez indiquez le chemin ou le nom du dossier ou du fichier supprimer  <input type=\"texte\" name=\"fichier_ou_dossier\" value=\"\"> ";
            echo "<br/><input type=\"submit\" name=\"send\" value=\"Supprimer\"></form>";
            echo "<br>";

        function rm($fichier_ou_dossier)
        { // si le paramètre est une chaîne de caractère...
        if (is_string($fichier_ou_dossier))
        { // si le paramètre est un fichier...
        if (is_file($fichier_ou_dossier))
        { // on efface le fichier et renvoit le resultat
        return unlink($fichier_ou_dossier);
        }
        else
        // si c'est un dossier
        if (is_dir($fichier_ou_dossier))

        {
        $suppr_fichier = rm("$fichier_ou_dossier/*");

        // si les fichiers n'ont pas été supprimés
        if (!$suppr_fichier)
        {
        return false;
        }

        // supprime le dossier après être vidé ^^
        return rmdir($fichier_ou_dossier);
        }

        else
        { // on recherche les fichiers vérifiant un masque (*.html)
        $fichiers_masque = glob($fichier_ou_dossier);
        // si aucun fichier...
        if ($fichiers_masque === false)
        {
        // déclanche une erreur utilisateur
        trigger_error(sprintf('Aucun fichier correspondant au masque suivant: %s', $fichier_ou_dossier), E_USER_WARNING);
        return false;
        }
        // on rappel la fonction rm() pour chaque fichier afin de //les supprimer un par un
        $rslt = array_map('rm', $fichiers_masque);

        // si un false est trouvé il y a eu une erreur lors de la                //suppression
        if (in_array(false, $rslt))
        {
        return false;
        }
        }
        }
        else
        // s'il s'agit un tableau contenant les noms des fichiers...
        if (is_array($fichier_ou_dossier))
        {
        // on rappel la fonction rm() pour chaque fichier afin de les        //supprimer un par un
        $rslt = array_map('rm', $fichier_ou_dossier);
        // si un false est trouvé il y a eu une erreur lors de la //suppression
        if (in_array(false, $rslt))
        {
        return false;
        }
        }
        else
        {
        // déclanche une erreur utilisateur
        trigger_error('Le paramètre passé en argument n\'est pas valide !', E_USER_ERROR);
        return false;
        }
        return true;
        }

        // SUPPRESSION FICHIERS ou DOSSIERS

        if (isset($_POST['send']) && $_POST['send'] == "Supprimer"){

        $fichier_ou_dossier = $_POST['fichier_ou_dossier'];

        $send = $_POST['send'];

        if(empty($send)) { die ("\n Erreur!!\n");}

        if(empty($fichier_ou_dossier)) { die ("\n Vous n' avez pas remplis le champs ! \n");}

        if (isset($fichier_ou_dossier) &&  $send=="Supprimer") {

        rm($fichier_ou_dossier);
         echo "le dossier a été suppirmer avec succés";

        }
        else{

        echo "Erreur!!!";

        }

        $fichier_ou_dossier = "";
        $send = "";

        }
        ?>
</div>

<style>
    #creerdossier
    {

    }
</style>


<?php
require "function/function.php";

?>


