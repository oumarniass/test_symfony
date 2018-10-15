<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>explorateur</title>
</head>
<body>
<div class="jumbotron" style="border-bottom: black 4px solid !important;background-color: beige !important;background-image: url(image/test.png) !important;">
    <div class="row">
        <div class="col-md">
<img src="image/dossier.png" class="img-fluid" width="100px;" style="margin-right: 1000px !important;">

        </div>

        <div class="col-sm">
    <h1 style="color: Black;">Explorateur de Fichier</h1>
        </div>
    </div>
</div>
<div class="card mb-4" id="test" style="width: 300px !important;position: relative; top: -30px !important;height: 1400px !important;border-right:4px solid black;background-color: beige !important;">
<div class="container">
    <h3>menu</h3>
    <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modalRegisterForm"><img src="image/ajouter.png" class="img-fluid">

    </a>
    <br>
    <br>
    <a href="" class="btn btn-default btn-rounded" data-toggle="modal" data-target="#orangeModalSubscription"><img src="image/del2.png" class="img-fluid" width="80px";></a>
    <br>
    <br>
    <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm"><img src="image/creer2.png" width="100px" class="img-fluid" ></a>
    <br>
    <br>
    <a href="" class="btn btn-default btn-rounded" data-toggle="modal" data-target="#modalLoginAvatar"><img src="image/rename.png" width="100px" class="img-fluid" ></a>

</div>

</div>
<div class="container" style="position: relative; top: -1400px;margin-right: 100px!important;">
    <?php require "function/parcourir.php";?>
</div>
<?php require "upload.php"; ?>
<div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="padding: 20px !important;">
            <h1> Creation dossier</h1>
            <form method="post" action="index.php">
                <div class="form-group">
                    <input type="text" name="nomdossier" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-success" name="submit1" value="creer un dossier" >
                </div>
            </form>

        </div>
    </div>
</div>

<?php
    if(isset($_POST['submit1']))
    {
        if(!file_exists($_POST["nomdossier"]))
        {
            mkdir($_POST['nomdossier'],0777,true);
            echo "le dossier a été crée avec succés";

        }
        else
        {
            echo "Le dossier n'a pas  été crée avec succés";

        }
    }
?>
<div class="modal fade" id="orangeModalSubscription" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-notify modal-warning" role="document">
        <!--Content-->
        <div class="modal-content">
            <!--Header-->
            <div class="modal-header text-center">
                <h4 class="modal-title white-text w-100 font-weight-bold py-2">Supprimer Dossier ou fichier</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="white-text">&times;</span>
                </button>
            </div>

            <!--Body-->

            <form action="index.php" action="post" class="container">
                <div class="form-group">
                    <input type="text" name="folder_name" class="form-control" >
                </div>
                <div class="form-group">
                    <input type="submit" name="submit4" value="supprimer" class="btn btn-success">
                </div>
            </form>

        </div>

        <!--Footer-->

    </div>
    <!--/.Content-->
</div>
</div>
<?php
if (isset($_POST['submit4'])){
    if (isset($_POST['folder_name'])){
        $doc = $_POST['folder_name'];
        if (is_dir($doc)){
            rmdir($doc);
        } else {
            unlink($doc);
        }
    }
}
?>
<?php

if(isset($_POST['submit3']))
{
    if(!rename($_POST['old_name'],$_POST['new_name'] ))
    {
        echo "Le fichier a été renommer  avec succés";
    }
}
?>
<div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header text-center">

                <form action="index.php" method="post" enctype="multipart/form-data" >
                    <label for="">Dossier ou Fichier</label>
                    <input type="file" name="file" id="file">
                    <input type="submit" value="Uploader" class="btn btn-success" name="upload" id="upload">
                    <input type="submit" name="annuler" class="btn btn-danger" value="annuler">

                </form>

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modalLoginAvatar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog cascading-modal modal-avatar modal-sm" role="document">
        <!--Content-->
        <div class="modal-content">

            <!--Header-->
            <div class="modal-header">
            </div>
            <!--Body-->
            <h2 class="container">Renomage Fichier</h2>
            <form method="post" action="index.php" class="container">
                <div class="form-group">
                    <input type="text" name="old_name" class="form-control">
                </div>
                <div class="form-group">
                    <input type="text" name="new_name" class="form-control">
                </div>
                <div class="form-group">
                    <input type="submit" class="btn btn-danger" value="renomer" name="submit2">
                </div>
            </form>

        </div>
        <!--/.Content-->
    </div>
</div>
<?php

if(isset($_POST['submit2']))
{
    if(!rename($_POST['old_name'],$_POST['new_name'] ))
    {
        echo "Le fichier a été copier avec succés";
    }
}
?>

<script>

</script>
<style>
    #form_upload
    {
        position: relative !important;
        top:-1400px !important;
        left: 400px !important;
         }
</style>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>