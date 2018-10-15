<?php


if (isset($_POST['delete'])){
    if (isset($_POST['doc'])){
        $doc = $_POST['doc'];
        if (is_dir($doc)){
            rmdir($doc);
        } else {
            unlink($doc);
        }
    }
}
header('location: index.php');
