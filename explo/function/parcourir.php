<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<?php

$url = "../";
if (isset($_GET['dossier'])) {
    $dossier = ($_GET['dossier']);
    $url = $url.$dossier;
}
$dirs = array_diff(@scandir($url), ['explorateur',"."]);


foreach(@$dirs as $dir){
    if (is_dir($url.$dir)){
        if ($dir == "..") {
            if (isset($_GET['dossier'])){?>
                <a class="folder" href="index.php?dossier=<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$dossier.$dir.readdir($dir,$dossier); ?>/">
                    <div class=""><i class="fas fa-angle-double-left fa-lg"></i><i class="fas fa-angle-double-left fa-lg"></i></div>
                </a>
            <?php }
        } else {
            if (isset($_GET['dossier'])) {?>
                <a class="folder" href="index.php?dossier=<?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$dossier.$dir; ?>/">
                    <img src="image/folder.png" alt="" width="30"><?php echo "&nbsp;&nbsp;&nbsp;&nbsp;".$dir;?>
                </a>
            <?php } else {?>
                <a class="folder" href="index.php?dossier=<?php echo $dir ?>/">

                    <img src="image/folder.png" class="img-fluid" width="100" alt=""><?php echo $dir; ?>

                </a>
            <?php }
        }
    } else {
        if (isset($dir)){
            $extension = pathinfo($dir, PATHINFO_EXTENSION);
            if ($extension == "html"){
                ?>
                <a class="folder">
                    <img src="image/html.png" class="img-fluid" alt="" width="100"><?php echo $dir; ?>
                </a>
                <?php
            } elseif ($extension == "txt"){
                ?>
                <a class="folder">
                    <img src="image/text.png" alt="" class="img-fluid" width="100"><?php echo $dir; ?>
                </a>
                <?php
            } elseif ($extension == "png"){
                ?>
                <a class="folder">
                    <img src="image/png.png" alt="" class="img-fluid" width="100"><?php echo $dir; ?>
                </a>
                <?php
            } elseif ($extension == "js") {
                ?>
                <a class="folder">
                    <img src="image/js.png" alt="" class="img-fluid" width="100"><?php echo $dir; ?>
                </a>
                <?php
            }
            elseif($extension == "md")
            {
                ?>
                <a class="folder">
                    <img src="image/text.png" class="img-fluid" alt="" width="100"><?php echo $dir; ?>
                </a>
                <?php
            }
            elseif($extension == "jpg")
            {
                ?>
                <a class="folder">
                    <img src="image/jpg.png" alt="" class="img-fluid" width="100"><?php echo $dir; ?>
                </a>
                <?php

            }
            elseif ($extension == "zip")
            {
                ?>
                <a class="folder">
                    <img src="image/zip.png" class="img-fluid" alt="" width="100"><?php echo $dir; ?>
                </a>

                <?php
            }
            elseif ($extension == "php"){
                ?>
                <a class="folder">
                    <img src="image/php1.png" alt="" class="img-fluid" width="100"><?php echo $dir; ?>
                </a>
                <?php
            } elseif ($extension == "pdf"){
                ?>
                <a class="folder">
                    <img src="icone/pdf.png" alt="" class="img-fluid" width="100"><?php echo $dir; ?>
                </a>
                <?php
            } else{
                ?>
                <a class="folder">
                    <img src="icone/text.png" alt="" class="img-fluid" width="100"><?php echo $dir; ?>
                </a>
                <?php
            }
        }
    }
}
?>

<style>

</style>