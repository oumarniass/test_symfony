<?php

if (isset($_POST['upload'])){
    $fichier = $_FILES['file']['name'];
    $taille_max = 2097152;
    $taille = filesize($_FILES['file']['tmp_name']);
    $extensions = ['.png','.jpg','.jpeg'];
    $extension = strrchr($fichier, '.');

    if (!in_array($extension, $extensions)){
        $error = '<div class="alert">Vous devez uploader un fichier de type<? echo $extension;?> </div>';
    }
    if ($taille > $taille_max){
        $error = '<div class="alert">Fichier trop volumineux ...</div>';
    }
    if (!isset($error)){
        $fichier = preg_replace('/([^.a-z0-9]+)/', '.', $fichier);
        move_uploaded_file($_FILES['file']['tmp_name'], "/".$fichier);
        echo "reussie";
    } else {
        if(file_exists($fichier))
        echo $error;
        echo "le fichier existe ";
    }
}


?>