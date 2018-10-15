<?php


$bar_url="../" ;//chemin du dossier
if(isset($_GET['dossier'])){
    $dossier = ($_GET['dossier']);
    $bar_url=$bar_url.$dossier; 
}

$dirs = scandir($bar_url);  

foreach ($dirs as $dir) {
    # code...
    if (is_dir($bar_url.$dir)) {
        # code...
        if ($dir == "..") {
            # code...
        } else {
            # code...
            if (isset($_GET['dossier'])) {
                # code...
                ?>
                <a href="php.php?dossier=<?php echo $dossier.$dir; ?>/">
                <img src='image/images.png' alt=''width='60'><?php echo $dir; ?>
                </a>
                <?php
            } else {
                # code...
                ?>
                <a href="php.php?dossier=<?php echo $dir; ?>/">
                <img src='image/images.png' alt=''width='60'><?php echo $dir; ?>
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