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
                " a été enregistrez avez succés ";
        } else{
            echo "Il y a une erreurs veillez réessayez svp";
        }
    }
}
upload();
?>