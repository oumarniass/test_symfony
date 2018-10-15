<?php

//Dossier defini comme racine
$ROOT = "./Root/";

//Gestion du telechargement
if(isset($_GET['download'])){
    $shortname = basename($_GET['download']);
    switch(strrchr($shortname, ".")){
	case ".gz": $type = "application/x-gzip"; break;
	case ".tgz": $type = "application/x-gzip"; break;
	case ".zip": $type = "application/zip"; break;
	case ".pdf": $type = "application/pdf"; break;
	case ".png": $type = "image/png"; break;
	case ".gif": $type = "image/gif"; break;
	case ".jpg": $type = "image/jpeg"; break;
	case ".txt": $type = "text/plain"; break;
	case ".htm": $type = "text/html"; break;
	case ".html": $type = "text/html"; break;
	default: $type = "application/octet-stream"; break;
    }
    header("Content-disposition: attachment; filename={$shortname}");
    header("Content-Type: application/force-download");
    header("Content-Transfer-Encoding: $type\n");
    header("Content-Length: ".filesize($_GET['download']));
    header("Pragma: no-cache");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0, public");
    header("Expires: 0");
    readfile($_GET['download']);
    //unset($_GET['download']);
    end;
}

if(isset($_GET['currentdir'])){

    //Verifie que l'on ne peut pas se rendre sous la racine
    if(substr($_GET['currentdir'], 0, strlen($ROOT)) != $ROOT){
	$_GET['currentdir'] = $ROOT;
    } else {
        while(strpos($_GET['currentdir'], "..")>-1){
	    $_GET['currentdir'] = str_replace("..",".",$_GET['currentdir']);
        }
    }
    $currentdir=$_GET['currentdir'];
} else {
    $currentdir=$ROOT;
}

//Upload de fichier
if(isset($_FILES['fichier'])){
    if($_FILES['fichier']['error']==0){
        move_uploaded_file($_FILES['fichier']['tmp_name'], $_POST['currentdir'] . $_FILES['fichier']['name']);
    } else {
	die("Une erreur est survenue lors de l'upload du fichier");
    }
    unset($_FILES['fichier']);
    $currentdir=$_POST['currentdir'];
}

//Suppresion de fichier ou dossier
if(isset($_GET['delete'])){
    Delete($_GET['delete']);
}

//Creation de dossier
if(isset($_GET['createdir'])){
    if(is_dir($_GET['currentdir'] . "Nouveau dossier")){
	$i=1;
	while(is_dir($_GET['currentdir'] . "Nouveau dossier ($i)")){
	    $i++;
	}
        mkdir($_GET['currentdir'] . "Nouveau dossier ($i)");
    } else {
        mkdir($_GET['currentdir'] . "Nouveau dossier");
    }
}

//Renommer
if(isset($_GET['rename'])){
    $rename = $_GET['rename'];
} else {
    $rename = "";
}

if(isset($_GET['newname'])){
    if(is_dir($currentdir . $_GET['exname']) || is_file($currentdir . $_GET['exname'])){
	@rename($currentdir . $_GET['exname'], $currentdir . $_GET['newname']);
    }
}

?>

<html>
<body bgcolor=black>
<center>
  <div style="width: 800px; height: 600px; font-family: tahoma; font-size: 11px; text-align: left; overflow: hidden; border: solid 1px #303030; color: black; background-color: #F0F0F0;">

    <div style="position: relative; top: -1px; left: -1px; width: 800px; height: 50px; border: solid 1px #303030;">
	<table>
	  <tr>
	    <td width=10></td>
	    <td><font size=6><b>PHP Explorer 2.0</b></font></td>
	  </tr>
	</table>
    </div>

    <div style="position: relative; top: -1px; left: -1px; width: 200px; height: 550px; overflow: auto;">
	<div style="width: 190px; height: 15px; border: solid 1px black; margin-left: 2px; margin-top: 1px; padding-left: 3px; overflow: hidden;">
		<?php echo $currentdir; ?>
		
	</div>
	<?php
	    DrawTree($ROOT, $currentdir);
	?>
    </div>

    <div style="position: relative; top: -552px; left: 198px; width: 300px; height: 550px; overflow: auto; border: solid 1px #303030;">
	<div style="width: 290px; height: 15px; border: solid 1px black; margin-left: 2px; margin-top: 1px; padding-left: 3px; overflow: hidden;">
		<form method="POST" action=index.php enctype="multipart/form-data">Upload <input type=hidden name=currentdir value="<?php echo $currentdir; ?>"><input name=fichier type=file style="height: 16px; font-family: tahoma; font-size: 8px; position: relative; top: -1px;"><input type=submit value="Uploader le fichier" style="height: 16px; width: 99px;font-family: tahoma; font-size: 9px;"></form></div>
	<?php
	    echo "<table width=300 style=\"font-family: tahoma; font-size: 11px; text-align: left;\">
    		     <tr>
			<td width=10><div style=\"width: 9px; height: 10px; border: solid 1px black; background-color: yellow; margin-top: 1px; line-height: 9px; padding-left: 3px; font-family: tahoma; font-size: 9px;\"><b>N</b></div></td>
			<td><input type=submit value=\"Nouveau dossier\" style=\"width: 170px; height: 16px; font-family: tahoma; font-size: 9px; cursor: pointer;\" OnClick=\"document.location.href='index.php?currentdir={$currentdir}&createdir=yes';\"></td>
			<td width=50></td>
			<td width=10></td>
			<td width=10></td>
			<td width=10></td>
		     </tr>
	          </table>";

	    DrawListDir($currentdir, $rename);
	    DrawListFile($currentdir, $rename);
	?>
    </div>

    <div style="position: relative; top: -1104px; left: 500px; width: 300px; height: 550px;">
	<?php
	    if(isset($_GET['select'])){
		ShowSelectFile($_GET['select']);
	    }
	?>
    </div>


  </div>
</center>
</body>
</html>

<?php

function ShowSelectFile($pathfile){

    echo "<div style=\"width: 290px; height: 290px; border: solid 1px black; margin-left: 2px; margin-top: 2px; padding-left: 3px; overflow: auto;\">";

    switch(strtoupper(substr($pathfile, -3))){
	case "JPG"; echo "<img src=\"$pathfile\">"; break;
	case "BMP"; echo "<img src=\"$pathfile\">"; break;
	case "GIF"; echo "<img src=\"$pathfile\">"; break;
	case "PNG"; echo "<img src=\"$pathfile\">"; break;
	default : echo NoScript(GetDataFile($pathfile)); break;
    }

    echo "</div>
	  <table width=300 style=\"font-family: tahoma; font-size: 11px; text-align: left;\">
	    <tr valign=top><td width=105>Nom du fichier</td>	<td style=\"overflow: hidden;\">" . basename($pathfile) . "</td></tr>
	    <tr valign=top><td width=105>Chemin complet</td>	<td style=\"overflow: hidden;\">" . $pathfile . "</td></tr>
	    <tr valign=top><td width=105>Taille du fichier</td>	<td style=\"overflow: hidden;\">" . OptimalFilesize($pathfile) . "</td></tr>
	    <tr valign=top><td width=105>Dernier acc�s</td>	<td style=\"overflow: hidden;\">" . date("d/m/Y � H:i:s", fileatime($pathfile)) . "</td></tr>
	    <tr valign=top><td width=105>Derni�re modification</td><td style=\"overflow: hidden;\">" . date("d/m/Y � H:i:s", filemtime($pathfile)) . "</td></tr>
	    <tr valign=top><td width=105>Droits</td>		<td style=\"overflow: hidden;\">" . FilePerm($pathfile) . "</td></tr>
	  </table>";

}

function DrawListFile($currentdir, $rename){
    $files = ListFile($currentdir);
    echo "<table width=300 style=\"font-family: tahoma; font-size: 11px; text-align: left;\">";
    for($i=1; $i<=$files[0]; $i++){
      if($rename!=$files[$i]){
	echo "<tr>
		<td width=10><div style=\"width: 10px; height: 12px; border: solid 1px black; background-color: #E0E0E0; margin-left: 1px;\"></div></td>
		<td><div style=\"width: 175px; cursor: pointer; overflow: hidden;\" OnClick=\"document.location.href='index.php?currentdir={$currentdir}&select={$currentdir}{$files[$i]}';\">{$files[$i]}</div></td>
		<td width=50>" . OptimalFilesize($currentdir . $files[$i]) . "</td>
		<td width=10><div style=\"width: 9px; height: 10px; border: solid 1px black; cursor: pointer; line-height: 7px; text-align: center; color: #005000; background-color: #A0A0A0;\" OnClick=\"window.open('index.php?download={$currentdir}{$files[$i]}', 'Downloader','menubar=no , status=no, scrollbars=no, menubar=no, width=1, height=1');\"><b>v</b></div></td>
		<td width=10><div style=\"width: 10px; height: 10px; border: solid 1px black; cursor: pointer; line-height: 9px; text-align: center; color: #000050; background-color: #A0A0A0;\" OnClick=\"document.location.href='index.php?currentdir={$currentdir}&rename={$files[$i]}';\"><b>R</b></div></td>
		<td width=10><div style=\"width: 9px; height: 10px; border: solid 1px black; cursor: pointer; line-height: 9px; text-align: center; color: #500000; background-color: #A0A0A0;\" OnClick=\"document.location.href='index.php?currentdir={$currentdir}&delete={$currentdir}{$files[$i]}';\"><b>X</b></div></td>
	      </tr>";
      } else {
	echo "<tr><form>
		<td width=10><div style=\"width: 10px; height: 12px; border: solid 1px black; background-color: #E0E0E0; margin-left: 1px;\"></div></td>
		<td><input name=newname type=text value=\"{$files[$i]}\" style=\"width: 175px; height: 18px; font-family: tahoma; font-size: 11px; cursor: pointer; overflow: hidden;\"></td>
		<td width=50><input type=submit value=Ok style=\"width: 50px; height: 18px; font-family: tahoma; font-size: 11px;\"></td>
		<td width=10><input type=hidden name=currentdir value=\"{$currentdir}\"</td>
		<td width=10><input type=hidden name=exname value=\"{$files[$i]}\"></td>
		<td width=10></td>
	      </form></tr>";
      }
    }
    echo "</table>";
}

function DrawListDir($currentdir, $rename){
    $dirs = ListDir($currentdir);
    echo "<table width=300 style=\"font-family: tahoma; font-size: 11px; text-align: left;\">";
    for($i=1; $i<=$dirs[0]; $i++){
     if($rename!=$dirs[$i]){
	echo "<tr>
		<td width=10><div style=\"width: 12px; height: 10px; border: solid 1px black; background-color: yellow; margin-top: 1px;\"></div></td>
		<td><div style=\"width: 175px; cursor: pointer; overflow: hidden;\" OnClick=\"document.location.href='index.php?currentdir={$currentdir}{$dirs[$i]}/';\">{$dirs[$i]}</div></td>
		<td width=50>" . OptimalFilesize($currentdir . $dirs[$i]) . "</td>
		<td width=10><div style=\"width: 9px; height: 10px; border: solid 1px black; cursor: pointer; line-height: 7px; text-align: center; color: #005000; background-color: #A0A0A0;\" OnClick=\"window.open('downloader.php?download={$currentdir}{$dirs[$i]}', 'Downloader','menubar=no , status=no, scrollbars=no, menubar=no, width=1, height=1');\"><b>v</b></div></td>
		<td width=10><div style=\"width: 10px; height: 10px; border: solid 1px black; cursor: pointer; line-height: 9px; text-align: center; color: #000050; background-color: #A0A0A0;\" OnClick=\"document.location.href='index.php?currentdir={$currentdir}&rename={$dirs[$i]}';\"><b>R</b></div></td>
		<td width=10><div style=\"width: 9px; height: 10px; border: solid 1px black; cursor: pointer; line-height: 9px; text-align: center; color: #500000; background-color: #A0A0A0;\" OnClick=\"document.location.href='index.php?currentdir={$currentdir}&delete={$currentdir}{$dirs[$i]}';\"><b>X</b></div></td>
	      </tr>";
      } else {
	echo "<tr><form>
		<td width=10><div style=\"width: 12px; height: 10px; border: solid 1px black; background-color: yellow; margin-top: 1px;\"></div></td>
		<td><input name=newname type=text value=\"{$dirs[$i]}\" style=\"width: 175px; height: 18px; font-family: tahoma; font-size: 11px; overflow: hidden;\"></td>
		<td width=50><input type=submit value=Ok style=\"width: 50px; height: 18px; font-family: tahoma; font-size: 11px;\"></td>
		<td width=10><input type=hidden name=currentdir value=\"{$currentdir}\"</td>
		<td width=10><input type=hidden name=exname value=\"{$dirs[$i]}\"></td>
		<td width=10></td>
	      </form></tr>";
      }
    }
    echo "</table>";
}

function FilePerm($file){

	$perms = fileperms($file);
	if (($perms & 0xC000) == 0xC000) { 	 $info = 's'; // Socket
	} elseif (($perms & 0xA000) == 0xA000) { $info = 'l'; // Lien symbolique
	} elseif (($perms & 0x8000) == 0x8000) { $info = '-'; // R�gulier
	} elseif (($perms & 0x6000) == 0x6000) { $info = 'b'; // Block special
	} elseif (($perms & 0x4000) == 0x4000) { $info = 'd'; // Dossier
	} elseif (($perms & 0x2000) == 0x2000) { $info = 'c'; // Caract�re sp�cial
	} elseif (($perms & 0x1000) == 0x1000) { $info = 'p'; // pipe FIFO
	} else {				 $info = 'u'; // Inconnu
	}

	// Autres
	$info .= (($perms & 0x0100) ? 'r' : '-');
	$info .= (($perms & 0x0080) ? 'w' : '-');
	$info .= (($perms & 0x0040) ? (($perms & 0x0800) ? 's' : 'x' ) : (($perms & 0x0800) ? 'S' : '-'));

	// Groupe
	$info .= (($perms & 0x0020) ? 'r' : '-');
	$info .= (($perms & 0x0010) ? 'w' : '-');
	$info .= (($perms & 0x0008) ? (($perms & 0x0400) ? 's' : 'x' ) : (($perms & 0x0400) ? 'S' : '-'));

	// Tout le monde
	$info .= (($perms & 0x0004) ? 'r' : '-');
	$info .= (($perms & 0x0002) ? 'w' : '-');
	$info .= (($perms & 0x0001) ? (($perms & 0x0200) ? 't' : 'x' ) : (($perms & 0x0200) ? 'T' : '-'));

        return $info;
}

function OptimalFilesize($file){
    $size = filesize($file);
    if($size>1073741824){
	$size = intval($size/1073741824*10)/10 . " Go";
    } else {
        if($size>1048576){
	    $size = intval($size/1048576*10)/10 . " Mo";
        } else {
            if($size>1024){
	        $size = intval($size/1024*10)/10 . " Ko";
            } else {
	        $size = $size . " o";
            }
        }
    }
    return $size;
}

function DrawTree($root, $currentdir){

    echo "
	<table cellspacing=0 cellpadding=0>
	  <tr>
	    <td>
	      <table cellspacing=1 style=\"font-family: tahoma; font-size: 11px; text-align: left;\">
		<tr style=\"cursor: pointer;\" OnClick=\"document.location.href='index.php?currentdir={$root}';\">
	          <td width=0></td>
	          <td><div style=\"width:7px; height: 7px; border: solid 1px #303030; line-height: 6px; font-size: 10px; color: #303030; background-color: white; margin-top: 2px; text-align: center;\">-</div></td>
	          <td><div style=\"width: 12px; height: 10px; border: solid 1px black; background-color: yellow; margin-top: 1px;\"></div></td>
	          <td><div>.</div></td>
	        </tr>
	      </table>
	    </td>
	  </tr>";

	//Affichage recursif des sous dossiers
        DrawTreeRecursive($currentdir, 1);

    echo "</table>";
}


function DrawTreeRecursive($path, $level){

    $cuts = array();
    $cuts = explode("/", $path);

    $cutpath = "";
    for($i=0; $i<=$level; $i++){
        $cutpath .= $cuts[$i] . "/";
    }

    $liste = array();
    $liste = ListDir($cutpath);
    for($i=1; $i<=$liste[0]; $i++){
	if($liste[$i] == $cuts[$level+1]){
	    echo "
	      <table cellspacing=1 style=\"font-family: tahoma; font-size: 11px; text-align: left;\">
		<tr style=\"cursor: pointer;\" OnClick=\"document.location.href='index.php?currentdir={$cutpath}{$liste[$i]}/';\">
	          <td width=" . ($level*12) . "></td>
	          <td><div style=\"width:7px; height: 7px; border: solid 1px #303030; line-height: 6px; font-size: 10px; color: #303030; background-color: white; margin-top: 2px; text-align: center;\">-</div></td>
	          <td><div style=\"width: 12px; height: 10px; border: solid 1px black; background-color: yellow; margin-top: 1px;\"></div></td>
	          <td><div>{$liste[$i]}</div></td>
	        </tr>
	      </table>";
	    DrawTreeRecursive($path, $level+1);
	} else {
	    echo "
	      <table cellspacing=1 style=\"font-family: tahoma; font-size: 11px; text-align: left;\">
	        <tr style=\"cursor: pointer;\" OnClick=\"document.location.href='index.php?currentdir={$cutpath}{$liste[$i]}/';\">
	          <td width=" . ($level*12) . "></td>
	          <td><div style=\"width:7px; height: 7px; border: solid 1px #303030; line-height: 6px; font-size: 10px; color: #303030; background-color: white; margin-top: 2px; text-align: center;\">+</div></td>
	          <td><div style=\"width: 12px; height: 10px; border: solid 1px black; background-color: yellow; margin-top: 1px;\"></div></td>
	          <td><div>{$liste[$i]}</div></td>
	        </tr>
	      </table>";
	}
    }
}

function Delete($path){
    if(is_file($path)){
	unlink($path);
    } else {
        if(is_dir($path)){
	    $files = array();
	    $files = ListFile($path);
	    for($i=1; $i<=$files[0]; $i++){
		unlink($path . "/" . $files[$i]);
	    }
	    $dirs = array();
	    $dirs = ListDir($path);
	    for($i=1; $i<=$dirs[0]; $i++){
		Delete($path . $dirs[$i]);
	    }
	    rmdir($path);
	}
    }
}

function ListDir($root){
    $list = array();
    $list[0] = 0;
    if(is_dir($root)){
	$mydir = opendir("./{$root}");
	while ($file = readdir($mydir)){
            if($file !='' && $file != '..' && $file !='.' ){ 
    	        if (is_dir("./{$root}/{$file}")){
		    $list[0]++;
		    $list[$list[0]] = $file;
	        }
            }
	}
        rewinddir($mydir);
        closedir($mydir);
    }
    return $list;
}

function ListFile($root){
    $list = array();
    $list[0] = 0;
    if(is_dir($root)){
	//affiche d'abord les dossiers
	$mydir = opendir("./{$root}");
	while ($file = readdir($mydir)){
            if($file !='' && $file != '..' && $file !='.' ){ 
    	        if(is_file("./{$root}/{$file}")){
		    $list[0]++;
		    $list[$list[0]] = $file;
	        }
            }
	}
        rewinddir($mydir);
        closedir($mydir);
    }
    return $list;
}

function GetDataFile($path) {
    $data = "";
    if(is_file($path)){
        $myfile = fopen ($path, "r");
            while (!feof($myfile)) {
                $data .= fgets($myfile, 1024);
            }
        fclose($myfile);
    }
    return $data;
}

function NoScript($string){
    $string = str_replace("<", "�", $string);
    $string = str_replace(">", "�", $string);
    $string = str_replace("\n", "<br>", $string);
    return $string;
}

?>