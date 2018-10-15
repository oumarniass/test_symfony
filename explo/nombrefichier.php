<?php 

$files = glob("../*.*");
$compteur = count($files);/* Variable $compteur pour compter (count) les fichiers lister ($files) dans le dossier */
echo "Il y a <font color=#FF0000>$compteur</font>";
if ($compteur > 1) { echo " fichiers dans ce répertoire"; }
else { echo " fichier dans ce répertoire"; }
?>

