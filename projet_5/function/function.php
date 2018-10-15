<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<?php
$bar_url="../" ;//chemin du dossier
if(isset($_GET['dossier'])){
    $dossier = ($_GET['dossier']);
    $bar_url=$bar_url.$dossier;
}

$dirs = scandir($bar_url);

foreach ($dirs as $dir) {

    if (is_dir($bar_url.$dir)) {
        if ($dir == "..") {

        } else {
            # code...
            if (isset($_GET['dossier'])) {

                ?>
                <a href="index.php?dossier=<?php echo $dossier.$dir; ?>/">
                    <img src='image/dossier.png' alt=''width='60'><?php echo $dir; ?>
                </a><br><br><a href="index.php">retour au menu</a><br><br>
                <?php
            } else {

                ?>
                <a href="index.php?dossier=<?php echo $dir; ?>/">
                    <img src='image/dossier.png' alt=''width='60'><?php echo $dir; ?>
                </a>

                <?php
            }
        }
    } else {
        # code...
        echo "
                <a>
                <img src='image/index.png' alt=''width='60'></a>".$dir."
                </a>
            ";
    }
}
/*function explorateur($dir)
{
    $repertoire = openDir($dir);
    echo "<div class='container'>";
    while ($fichier = readDir($repertoire)) {
        if ($fichier != "." && $fichier != "..") {
            if (is_dir($fichier)) {

                echo "<img src='image/dossier.png'>" . $fichier ."&nbsp;&nbsp;&nbsp;&nbsp";


            }

        }
        echo "</div>";
    }
    $repertoire = openDir($dir);
    echo "<div class='container'>";
    while($fichier = readDir($repertoire))
    {
        if($fichier !="." && $fichier !="..")
            if (is_file($fichier)) {

                echo  $fichier . "&nbsp;&nbsp;&nbsp;&nbsp&nbsp;&nbsp;&nbsp;&nbsp";

            }

    }
    echo "</div>";
}*/
$action = isset($_GET['action']);
switch($action) {
    case "mkdir":
        if (@mkdir($_GET['action'], 0777)) {
            echo "<h1>le dossier a ete creer</h1>";
            die();
        }
        if (!@mkdir($_GET['action'], 0777)) {
            echo "le dossier n'a pas ete creer veillez ressayer svp il se peut que le dossier existe déjá";
            die();
        }
        break;
    case "copy":
    case "upload":
        if ( ! isset($_FILES['uploadFile']) )

        break;

    default:
        echo "bonjour";

}







