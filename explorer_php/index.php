<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="css/style.css">
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
   <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
   <title>explorer_php</title>
</head>
<body>
<header>
    <div id="searchbar">
        
        
                
                       
                <form action="" class="formulaire">
               <input class="champ" type="text" value="Search...)"/>
    
                    <input class="bouton" type="button" value=" " />
                     
                </form>
                </div>
</header>
<aside>
    <div>
    <?php include 'traitement.php' ?>
</div>
</aside>
<section>
   
<p style="font-size:10px; top:40px;">
<img src="image/afig.png" alt="" class="img1"><br><br>Afficher</p>

<img src="image/afficher.png" alt="" class="img1"><br><br>
<img src="image/supprimer.png" alt="" class="img1"><br><br>
<img src="image/corbeil.png" alt="" class="img1"><br><br>
</section>

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
                <a href="traitement.php?dossier=<?php echo $dossier.$dir; ?>/">
                <img src='image/images.png' alt=''width='60'><?php echo $dir; ?>
                </a><br><br><a href="index.php">retour au menu</a><br><br>
                <?php
            } else {
                # code...
                ?>
                <a href="traitement.php?dossier=<?php echo $dir; ?>/">
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

   ?>
   
   


    </body>

    </html>';


