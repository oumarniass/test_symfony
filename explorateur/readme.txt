Explorateur de fichier----------------------
Url     : http://codes-sources.commentcamarche.net/source/49496-explorateur-de-fichierAuteur  : HakumbayaDate    : 07/08/2013
Licence :
=========

Ce document intitulé « Explorateur de fichier » issu de CommentCaMarche
(codes-sources.commentcamarche.net) est mis à disposition sous les termes de
la licence Creative Commons. Vous pouvez copier, modifier des copies de cette
source, dans les conditions fixées par la licence, tant que cette note
apparaît clairement.

Description :
=============

Voici une petite source simple &agrave; coupler avec une autre de mes sources (C
onsole FTP/MySQL).
<br />
<br />Cette derni&egrave;re permet l'exploration de 
fichier sur un serveur distant.
<br />Elle comprend :
<br />- Racine d'explora
tion parametrable (contante en t&ecirc;te de page)
<br />- Gestion Upload/Downl
oad
<br />- Affichage de l'arborescence du dossier en cours d'exploration
<br 
/>- Apercu simple des fichiers
<br />- Ajouter/Renommer/Supprimer fichiers et d
ossiers.
<br />- Source compact (18Ko) en un seul fichier (pas de code ou graph
isme externe)
<br />- Interface 600x800 pour les resolution les plus faibles.

<br />- Simplicit&eacute; de prise en main.
<br />- Programmation evenementiell
e PHP 4.0 (Pour les hebergeurs n'ayant pas PHP 5.0)
<br /><a name='source-exemp
le'></a><h2> Source / Exemple : </h2>
<br /><pre class='code' data-mode='basic
'>
&lt;?php

//Dossier defini comme racine
$ROOT = &quot;./Root/&quot;;

/
/Gestion du telechargement
if(isset($_GET['download'])){
    $shortname = base
name($_GET['download']);
    switch(strrchr($shortname, &quot;.&quot;)){
	case
 &quot;.gz&quot;: $type = &quot;application/x-gzip&quot;; break;
	case &quot;.t
gz&quot;: $type = &quot;application/x-gzip&quot;; break;
	case &quot;.zip&quot;
: $type = &quot;application/zip&quot;; break;
	case &quot;.pdf&quot;: $type = &
quot;application/pdf&quot;; break;
	case &quot;.png&quot;: $type = &quot;image/
png&quot;; break;
	case &quot;.gif&quot;: $type = &quot;image/gif&quot;; break;

	case &quot;.jpg&quot;: $type = &quot;image/jpeg&quot;; break;
	case &quot;.t
xt&quot;: $type = &quot;text/plain&quot;; break;
	case &quot;.htm&quot;: $type 
= &quot;text/html&quot;; break;
	case &quot;.html&quot;: $type = &quot;text/htm
l&quot;; break;
	default: $type = &quot;application/octet-stream&quot;; break;

    }
    header(&quot;Content-disposition: attachment; filename={$shortname}&
quot;);
    header(&quot;Content-Type: application/force-download&quot;);
    
header(&quot;Content-Transfer-Encoding: $type\n&quot;);
    header(&quot;Conten
t-Length: &quot;.filesize($_GET['download']));
    header(&quot;Pragma: no-cach
e&quot;);
    header(&quot;Cache-Control: must-revalidate, post-check=0, pre-ch
eck=0, public&quot;);
    header(&quot;Expires: 0&quot;);
    readfile($_GET['
download']);
    //unset($_GET['download']);
    end;
}

if(isset($_GET['cu
rrentdir'])){

    //Verifie que l'on ne peut pas se rendre sous la racine
  
  if(substr($_GET['currentdir'], 0, strlen($ROOT)) != $ROOT){
	$_GET['currentdi
r'] = $ROOT;
    } else {
        while(strpos($_GET['currentdir'], &quot;..&q
uot;)&gt;-1){
	    $_GET['currentdir'] = str_replace(&quot;..&quot;,&quot;.&quo
t;,$_GET['currentdir']);
        }
    }
    $currentdir=$_GET['currentdir'];

} else {
    $currentdir=$ROOT;
}

//Upload de fichier
if(isset($_FILES['
fichier'])){
    if($_FILES['fichier']['error']==0){
        move_uploaded_fil
e($_FILES['fichier']['tmp_name'], $_POST['currentdir'] . $_FILES['fichier']['nam
e']);
    } else {
	die(&quot;Une erreur est survenue lors de l'upload du fich
ier&quot;);
    }
    unset($_FILES['fichier']);
    $currentdir=$_POST['curr
entdir'];
}

//Suppresion de fichier ou dossier
if(isset($_GET['delete'])){

    Delete($_GET['delete']);
}

//Creation de dossier
if(isset($_GET['creat
edir'])){
    if(is_dir($_GET['currentdir'] . &quot;Nouveau dossier&quot;)){
	
$i=1;
	while(is_dir($_GET['currentdir'] . &quot;Nouveau dossier ($i)&quot;)){

	    $i++;
	}
        mkdir($_GET['currentdir'] . &quot;Nouveau dossier ($i)&q
uot;);
    } else {
        mkdir($_GET['currentdir'] . &quot;Nouveau dossier&
quot;);
    }
}

//Renommer
if(isset($_GET['rename'])){
    $rename = $_GE
T['rename'];
} else {
    $rename = &quot;&quot;;
}

if(isset($_GET['newnam
e'])){
    if(is_dir($currentdir . $_GET['exname']) || is_file($currentdir . $_
GET['exname'])){
	@rename($currentdir . $_GET['exname'], $currentdir . $_GET['n
ewname']);
    }
}

?&gt;

&lt;html&gt;
&lt;body bgcolor=black&gt;
&lt;c
enter&gt;
  &lt;div style=&quot;width: 800px; height: 600px; font-family: tahom
a; font-size: 11px; text-align: left; overflow: hidden; border: solid 1px #30303
0; color: black; background-color: #F0F0F0;&quot;&gt;

    &lt;div style=&quot
;position: relative; top: -1px; left: -1px; width: 800px; height: 50px; border: 
solid 1px #303030;&quot;&gt;
	&lt;table&gt;
	  &lt;tr&gt;
	    &lt;td width=1
0&gt;&lt;/td&gt;
	    &lt;td&gt;&lt;font size=6&gt;&lt;b&gt;PHP Explorer 2.0&lt
;/b&gt;&lt;/font&gt;&lt;/td&gt;
	  &lt;/tr&gt;
	&lt;/table&gt;
    &lt;/div&g
t;

    &lt;div style=&quot;position: relative; top: -1px; left: -1px; width: 
200px; height: 550px; overflow: auto;&quot;&gt;
	&lt;div style=&quot;width: 190
px; height: 15px; border: solid 1px black; margin-left: 2px; margin-top: 1px; pa
dding-left: 3px; overflow: hidden;&quot;&gt;&lt;?php echo $currentdir; ?&gt;&lt;
/div&gt;
	&lt;?php
	    DrawTree($ROOT, $currentdir);
	?&gt;
    &lt;/div&gt
;

    &lt;div style=&quot;position: relative; top: -552px; left: 198px; width
: 300px; height: 550px; overflow: auto; border: solid 1px #303030;&quot;&gt;
	&
lt;div style=&quot;width: 290px; height: 15px; border: solid 1px black; margin-l
eft: 2px; margin-top: 1px; padding-left: 3px; overflow: hidden;&quot;&gt;&lt;for
m method=&quot;POST&quot; action=index.php enctype=&quot;multipart/form-data&quo
t;&gt;Upload &lt;input type=hidden name=currentdir value=&quot;&lt;?php echo $cu
rrentdir; ?&gt;&quot;&gt;&lt;input name=fichier type=file style=&quot;height: 16
px; font-family: tahoma; font-size: 8px; position: relative; top: -1px;&quot;&gt
;&lt;input type=submit value=&quot;Uploader le fichier&quot; style=&quot;height:
 16px; width: 99px;font-family: tahoma; font-size: 9px;&quot;&gt;&lt;/form&gt;&l
t;/div&gt;
	&lt;?php
	    echo &quot;&lt;table width=300 style=\&quot;font-fam
ily: tahoma; font-size: 11px; text-align: left;\&quot;&gt;
    		     &lt;tr&gt
;
			&lt;td width=10&gt;&lt;div style=\&quot;width: 9px; height: 10px; border: 
solid 1px black; background-color: yellow; margin-top: 1px; line-height: 9px; pa
dding-left: 3px; font-family: tahoma; font-size: 9px;\&quot;&gt;&lt;b&gt;N&lt;/b
&gt;&lt;/div&gt;&lt;/td&gt;
			&lt;td&gt;&lt;input type=submit value=\&quot;Nou
veau dossier\&quot; style=\&quot;width: 170px; height: 16px; font-family: tahoma
; font-size: 9px; cursor: pointer;\&quot; OnClick=\&quot;document.location.href=
'index.php?currentdir={$currentdir}&amp;createdir=yes';\&quot;&gt;&lt;/td&gt;
	
		&lt;td width=50&gt;&lt;/td&gt;
			&lt;td width=10&gt;&lt;/td&gt;
			&lt;td w
idth=10&gt;&lt;/td&gt;
			&lt;td width=10&gt;&lt;/td&gt;
		     &lt;/tr&gt;
	
          &lt;/table&gt;&quot;;

	    DrawListDir($currentdir, $rename);
	   
 DrawListFile($currentdir, $rename);
	?&gt;
    &lt;/div&gt;

    &lt;div st
yle=&quot;position: relative; top: -1104px; left: 500px; width: 300px; height: 5
50px;&quot;&gt;
	&lt;?php
	    if(isset($_GET['select'])){
		ShowSelectFile($
_GET['select']);
	    }
	?&gt;
    &lt;/div&gt;

  &lt;/div&gt;
&lt;/cente
r&gt;
&lt;/body&gt;
&lt;/html&gt;

&lt;?php

function ShowSelectFile($path
file){

    echo &quot;&lt;div style=\&quot;width: 290px; height: 290px; borde
r: solid 1px black; margin-left: 2px; margin-top: 2px; padding-left: 3px; overfl
ow: auto;\&quot;&gt;&quot;;

    switch(strtoupper(substr($pathfile, -3))){
	
case &quot;JPG&quot;; echo &quot;&lt;img src=\&quot;$pathfile\&quot;&gt;&quot;; 
break;
	case &quot;BMP&quot;; echo &quot;&lt;img src=\&quot;$pathfile\&quot;&gt
;&quot;; break;
	case &quot;GIF&quot;; echo &quot;&lt;img src=\&quot;$pathfile\
&quot;&gt;&quot;; break;
	case &quot;PNG&quot;; echo &quot;&lt;img src=\&quot;$
pathfile\&quot;&gt;&quot;; break;
	default : echo NoScript(GetDataFile($pathfil
e)); break;
    }

    echo &quot;&lt;/div&gt;
	  &lt;table width=300 style=
\&quot;font-family: tahoma; font-size: 11px; text-align: left;\&quot;&gt;
	    
&lt;tr valign=top&gt;&lt;td width=105&gt;Nom du fichier&lt;/td&gt;	&lt;td style=
\&quot;overflow: hidden;\&quot;&gt;&quot; . basename($pathfile) . &quot;&lt;/td&
gt;&lt;/tr&gt;
	    &lt;tr valign=top&gt;&lt;td width=105&gt;Chemin complet&lt;
/td&gt;	&lt;td style=\&quot;overflow: hidden;\&quot;&gt;&quot; . $pathfile . &qu
ot;&lt;/td&gt;&lt;/tr&gt;
	    &lt;tr valign=top&gt;&lt;td width=105&gt;Taille 
du fichier&lt;/td&gt;	&lt;td style=\&quot;overflow: hidden;\&quot;&gt;&quot; . O
ptimalFilesize($pathfile) . &quot;&lt;/td&gt;&lt;/tr&gt;
	    &lt;tr valign=top
&gt;&lt;td width=105&gt;Dernier accès&lt;/td&gt;	&lt;td style=\&quot;overflow: h
idden;\&quot;&gt;&quot; . date(&quot;d/m/Y à H:i:s&quot;, fileatime($pathfile)) 
. &quot;&lt;/td&gt;&lt;/tr&gt;
	    &lt;tr valign=top&gt;&lt;td width=105&gt;De
rnière modification&lt;/td&gt;&lt;td style=\&quot;overflow: hidden;\&quot;&gt;&q
uot; . date(&quot;d/m/Y à H:i:s&quot;, filemtime($pathfile)) . &quot;&lt;/td&gt;
&lt;/tr&gt;
	    &lt;tr valign=top&gt;&lt;td width=105&gt;Droits&lt;/td&gt;		&l
t;td style=\&quot;overflow: hidden;\&quot;&gt;&quot; . FilePerm($pathfile) . &qu
ot;&lt;/td&gt;&lt;/tr&gt;
	  &lt;/table&gt;&quot;;

}

function DrawListFil
e($currentdir, $rename){
    $files = ListFile($currentdir);
    echo &quot;&l
t;table width=300 style=\&quot;font-family: tahoma; font-size: 11px; text-align:
 left;\&quot;&gt;&quot;;
    for($i=1; $i&lt;=$files[0]; $i++){
      if($rena
me!=$files[$i]){
	echo &quot;&lt;tr&gt;
		&lt;td width=10&gt;&lt;div style=\&q
uot;width: 10px; height: 12px; border: solid 1px black; background-color: #E0E0E
0; margin-left: 1px;\&quot;&gt;&lt;/div&gt;&lt;/td&gt;
		&lt;td&gt;&lt;div styl
e=\&quot;width: 175px; cursor: pointer; overflow: hidden;\&quot; OnClick=\&quot;
document.location.href='index.php?currentdir={$currentdir}&amp;select={$currentd
ir}{$files[$i]}';\&quot;&gt;{$files[$i]}&lt;/div&gt;&lt;/td&gt;
		&lt;td width=
50&gt;&quot; . OptimalFilesize($currentdir . $files[$i]) . &quot;&lt;/td&gt;
		
&lt;td width=10&gt;&lt;div style=\&quot;width: 9px; height: 10px; border: solid 
1px black; cursor: pointer; line-height: 7px; text-align: center; color: #005000
; background-color: #A0A0A0;\&quot; OnClick=\&quot;window.open('index.php?downlo
ad={$currentdir}{$files[$i]}', 'Downloader','menubar=no , status=no, scrollbars=
no, menubar=no, width=1, height=1');\&quot;&gt;&lt;b&gt;v&lt;/b&gt;&lt;/div&gt;&
lt;/td&gt;
		&lt;td width=10&gt;&lt;div style=\&quot;width: 10px; height: 10px;
 border: solid 1px black; cursor: pointer; line-height: 9px; text-align: center;
 color: #000050; background-color: #A0A0A0;\&quot; OnClick=\&quot;document.locat
ion.href='index.php?currentdir={$currentdir}&amp;rename={$files[$i]}';\&quot;&gt
;&lt;b&gt;R&lt;/b&gt;&lt;/div&gt;&lt;/td&gt;
		&lt;td width=10&gt;&lt;div style
=\&quot;width: 9px; height: 10px; border: solid 1px black; cursor: pointer; line
-height: 9px; text-align: center; color: #500000; background-color: #A0A0A0;\&qu
ot; OnClick=\&quot;document.location.href='index.php?currentdir={$currentdir}&am
p;delete={$currentdir}{$files[$i]}';\&quot;&gt;&lt;b&gt;X&lt;/b&gt;&lt;/div&gt;&
lt;/td&gt;
	      &lt;/tr&gt;&quot;;
      } else {
	echo &quot;&lt;tr&gt;&lt
;form&gt;
		&lt;td width=10&gt;&lt;div style=\&quot;width: 10px; height: 12px; 
border: solid 1px black; background-color: #E0E0E0; margin-left: 1px;\&quot;&gt;
&lt;/div&gt;&lt;/td&gt;
		&lt;td&gt;&lt;input name=newname type=text value=\&qu
ot;{$files[$i]}\&quot; style=\&quot;width: 175px; height: 18px; font-family: tah
oma; font-size: 11px; cursor: pointer; overflow: hidden;\&quot;&gt;&lt;/td&gt;

		&lt;td width=50&gt;&lt;input type=submit value=Ok style=\&quot;width: 50px; he
ight: 18px; font-family: tahoma; font-size: 11px;\&quot;&gt;&lt;/td&gt;
		&lt;t
d width=10&gt;&lt;input type=hidden name=currentdir value=\&quot;{$currentdir}\&
quot;&lt;/td&gt;
		&lt;td width=10&gt;&lt;input type=hidden name=exname value=\
&quot;{$files[$i]}\&quot;&gt;&lt;/td&gt;
		&lt;td width=10&gt;&lt;/td&gt;
	   
   &lt;/form&gt;&lt;/tr&gt;&quot;;
      }
    }
    echo &quot;&lt;/table&gt
;&quot;;
}

function DrawListDir($currentdir, $rename){
    $dirs = ListDir(
$currentdir);
    echo &quot;&lt;table width=300 style=\&quot;font-family: taho
ma; font-size: 11px; text-align: left;\&quot;&gt;&quot;;
    for($i=1; $i&lt;=$
dirs[0]; $i++){
     if($rename!=$dirs[$i]){
	echo &quot;&lt;tr&gt;
		&lt;td 
width=10&gt;&lt;div style=\&quot;width: 12px; height: 10px; border: solid 1px bl
ack; background-color: yellow; margin-top: 1px;\&quot;&gt;&lt;/div&gt;&lt;/td&gt
;
		&lt;td&gt;&lt;div style=\&quot;width: 175px; cursor: pointer; overflow: hid
den;\&quot; OnClick=\&quot;document.location.href='index.php?currentdir={$curren
tdir}{$dirs[$i]}/';\&quot;&gt;{$dirs[$i]}&lt;/div&gt;&lt;/td&gt;
		&lt;td width
=50&gt;&quot; . OptimalFilesize($currentdir . $dirs[$i]) . &quot;&lt;/td&gt;
		
&lt;td width=10&gt;&lt;div style=\&quot;width: 9px; height: 10px; border: solid 
1px black; cursor: pointer; line-height: 7px; text-align: center; color: #005000
; background-color: #A0A0A0;\&quot; OnClick=\&quot;window.open('downloader.php?d
ownload={$currentdir}{$dirs[$i]}', 'Downloader','menubar=no , status=no, scrollb
ars=no, menubar=no, width=1, height=1');\&quot;&gt;&lt;b&gt;v&lt;/b&gt;&lt;/div&
gt;&lt;/td&gt;
		&lt;td width=10&gt;&lt;div style=\&quot;width: 10px; height: 1
0px; border: solid 1px black; cursor: pointer; line-height: 9px; text-align: cen
ter; color: #000050; background-color: #A0A0A0;\&quot; OnClick=\&quot;document.l
ocation.href='index.php?currentdir={$currentdir}&amp;rename={$dirs[$i]}';\&quot;
&gt;&lt;b&gt;R&lt;/b&gt;&lt;/div&gt;&lt;/td&gt;
		&lt;td width=10&gt;&lt;div st
yle=\&quot;width: 9px; height: 10px; border: solid 1px black; cursor: pointer; l
ine-height: 9px; text-align: center; color: #500000; background-color: #A0A0A0;\
&quot; OnClick=\&quot;document.location.href='index.php?currentdir={$currentdir}
&amp;delete={$currentdir}{$dirs[$i]}';\&quot;&gt;&lt;b&gt;X&lt;/b&gt;&lt;/div&gt
;&lt;/td&gt;
	      &lt;/tr&gt;&quot;;
      } else {
	echo &quot;&lt;tr&gt;&
lt;form&gt;
		&lt;td width=10&gt;&lt;div style=\&quot;width: 12px; height: 10px
; border: solid 1px black; background-color: yellow; margin-top: 1px;\&quot;&gt;
&lt;/div&gt;&lt;/td&gt;
		&lt;td&gt;&lt;input name=newname type=text value=\&qu
ot;{$dirs[$i]}\&quot; style=\&quot;width: 175px; height: 18px; font-family: taho
ma; font-size: 11px; overflow: hidden;\&quot;&gt;&lt;/td&gt;
		&lt;td width=50&
gt;&lt;input type=submit value=Ok style=\&quot;width: 50px; height: 18px; font-f
amily: tahoma; font-size: 11px;\&quot;&gt;&lt;/td&gt;
		&lt;td width=10&gt;&lt;
input type=hidden name=currentdir value=\&quot;{$currentdir}\&quot;&lt;/td&gt;

		&lt;td width=10&gt;&lt;input type=hidden name=exname value=\&quot;{$dirs[$i]}\
&quot;&gt;&lt;/td&gt;
		&lt;td width=10&gt;&lt;/td&gt;
	      &lt;/form&gt;&lt
;/tr&gt;&quot;;
      }
    }
    echo &quot;&lt;/table&gt;&quot;;
}

func
tion FilePerm($file){

	$perms = fileperms($file);
	if (($perms &amp; 0xC000)
 == 0xC000) { 	 $info = 's'; // Socket
	} elseif (($perms &amp; 0xA000) == 0xA0
00) { $info = 'l'; // Lien symbolique
	} elseif (($perms &amp; 0x8000) == 0x800
0) { $info = '-'; // Régulier
	} elseif (($perms &amp; 0x6000) == 0x6000) { $in
fo = 'b'; // Block special
	} elseif (($perms &amp; 0x4000) == 0x4000) { $info 
= 'd'; // Dossier
	} elseif (($perms &amp; 0x2000) == 0x2000) { $info = 'c'; //
 Caractère spécial
	} elseif (($perms &amp; 0x1000) == 0x1000) { $info = 'p'; /
/ pipe FIFO
	} else {				 $info = 'u'; // Inconnu
	}

	// Autres
	$info .= 
(($perms &amp; 0x0100) ? 'r' : '-');
	$info .= (($perms &amp; 0x0080) ? 'w' : '
-');
	$info .= (($perms &amp; 0x0040) ? (($perms &amp; 0x0800) ? 's' : 'x' ) : 
(($perms &amp; 0x0800) ? 'S' : '-'));

	// Groupe
	$info .= (($perms &amp; 0x
0020) ? 'r' : '-');
	$info .= (($perms &amp; 0x0010) ? 'w' : '-');
	$info .= (
($perms &amp; 0x0008) ? (($perms &amp; 0x0400) ? 's' : 'x' ) : (($perms &amp; 0x
0400) ? 'S' : '-'));

	// Tout le monde
	$info .= (($perms &amp; 0x0004) ? 'r
' : '-');
	$info .= (($perms &amp; 0x0002) ? 'w' : '-');
	$info .= (($perms &a
mp; 0x0001) ? (($perms &amp; 0x0200) ? 't' : 'x' ) : (($perms &amp; 0x0200) ? 'T
' : '-'));

        return $info;
}

function OptimalFilesize($file){
    
$size = filesize($file);
    if($size&gt;1073741824){
	$size = intval($size/10
73741824*10)/10 . &quot; Go&quot;;
    } else {
        if($size&gt;1048576){

	    $size = intval($size/1048576*10)/10 . &quot; Mo&quot;;
        } else {

            if($size&gt;1024){
	        $size = intval($size/1024*10)/10 . &quo
t; Ko&quot;;
            } else {
	        $size = $size . &quot; o&quot;;
  
          }
        }
    }
    return $size;
}

function DrawTree($root, 
$currentdir){

    echo &quot;
	&lt;table cellspacing=0 cellpadding=0&gt;
	 
 &lt;tr&gt;
	    &lt;td&gt;
	      &lt;table cellspacing=1 style=\&quot;font-f
amily: tahoma; font-size: 11px; text-align: left;\&quot;&gt;
		&lt;tr style=\&q
uot;cursor: pointer;\&quot; OnClick=\&quot;document.location.href='index.php?cur
rentdir={$root}';\&quot;&gt;
	          &lt;td width=0&gt;&lt;/td&gt;
	       
   &lt;td&gt;&lt;div style=\&quot;width:7px; height: 7px; border: solid 1px #303
030; line-height: 6px; font-size: 10px; color: #303030; background-color: white;
 margin-top: 2px; text-align: center;\&quot;&gt;-&lt;/div&gt;&lt;/td&gt;
	     
     &lt;td&gt;&lt;div style=\&quot;width: 12px; height: 10px; border: solid 1px
 black; background-color: yellow; margin-top: 1px;\&quot;&gt;&lt;/div&gt;&lt;/td
&gt;
	          &lt;td&gt;&lt;div&gt;.&lt;/div&gt;&lt;/td&gt;
	        &lt;/tr
&gt;
	      &lt;/table&gt;
	    &lt;/td&gt;
	  &lt;/tr&gt;&quot;;

	//Affic
hage recursif des sous dossiers
        DrawTreeRecursive($currentdir, 1);

 
   echo &quot;&lt;/table&gt;&quot;;
}

function DrawTreeRecursive($path, $lev
el){

    $cuts = array();
    $cuts = explode(&quot;/&quot;, $path);

    
$cutpath = &quot;&quot;;
    for($i=0; $i&lt;=$level; $i++){
        $cutpath 
.= $cuts[$i] . &quot;/&quot;;
    }

    $liste = array();
    $liste = List
Dir($cutpath);
    for($i=1; $i&lt;=$liste[0]; $i++){
	if($liste[$i] == $cuts[
$level+1]){
	    echo &quot;
	      &lt;table cellspacing=1 style=\&quot;font-
family: tahoma; font-size: 11px; text-align: left;\&quot;&gt;
		&lt;tr style=\&
quot;cursor: pointer;\&quot; OnClick=\&quot;document.location.href='index.php?cu
rrentdir={$cutpath}{$liste[$i]}/';\&quot;&gt;
	          &lt;td width=&quot; . 
($level*12) . &quot;&gt;&lt;/td&gt;
	          &lt;td&gt;&lt;div style=\&quot;w
idth:7px; height: 7px; border: solid 1px #303030; line-height: 6px; font-size: 1
0px; color: #303030; background-color: white; margin-top: 2px; text-align: cente
r;\&quot;&gt;-&lt;/div&gt;&lt;/td&gt;
	          &lt;td&gt;&lt;div style=\&quot
;width: 12px; height: 10px; border: solid 1px black; background-color: yellow; m
argin-top: 1px;\&quot;&gt;&lt;/div&gt;&lt;/td&gt;
	          &lt;td&gt;&lt;div&
gt;{$liste[$i]}&lt;/div&gt;&lt;/td&gt;
	        &lt;/tr&gt;
	      &lt;/table&
gt;&quot;;
	    DrawTreeRecursive($path, $level+1);
	} else {
	    echo &quot
;
	      &lt;table cellspacing=1 style=\&quot;font-family: tahoma; font-size: 1
1px; text-align: left;\&quot;&gt;
	        &lt;tr style=\&quot;cursor: pointer;
\&quot; OnClick=\&quot;document.location.href='index.php?currentdir={$cutpath}{$
liste[$i]}/';\&quot;&gt;
	          &lt;td width=&quot; . ($level*12) . &quot;&
gt;&lt;/td&gt;
	          &lt;td&gt;&lt;div style=\&quot;width:7px; height: 7px
; border: solid 1px #303030; line-height: 6px; font-size: 10px; color: #303030; 
background-color: white; margin-top: 2px; text-align: center;\&quot;&gt;+&lt;/di
v&gt;&lt;/td&gt;
	          &lt;td&gt;&lt;div style=\&quot;width: 12px; height:
 10px; border: solid 1px black; background-color: yellow; margin-top: 1px;\&quot
;&gt;&lt;/div&gt;&lt;/td&gt;
	          &lt;td&gt;&lt;div&gt;{$liste[$i]}&lt;/d
iv&gt;&lt;/td&gt;
	        &lt;/tr&gt;
	      &lt;/table&gt;&quot;;
	}
    }

}

function Delete($path){
    if(is_file($path)){
	unlink($path);
    } 
else {
        if(is_dir($path)){
	    $files = array();
	    $files = ListFi
le($path);
	    for($i=1; $i&lt;=$files[0]; $i++){
		unlink($path . &quot;/&qu
ot; . $files[$i]);
	    }
	    $dirs = array();
	    $dirs = ListDir($path);

	    for($i=1; $i&lt;=$dirs[0]; $i++){
		Delete($path . $dirs[$i]);
	    }
	
    rmdir($path);
	}
    }
}

function ListDir($root){
    $list = array()
;
    $list[0] = 0;
    if(is_dir($root)){
	$mydir = opendir(&quot;./{$root}&
quot;);
	while ($file = readdir($mydir)){
            if($file !='' &amp;&amp;
 $file != '..' &amp;&amp; $file !='.' ){ 
    	        if (is_dir(&quot;./{$roo
t}/{$file}&quot;)){
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
	$mydi
r = opendir(&quot;./{$root}&quot;);
	while ($file = readdir($mydir)){
        
    if($file !='' &amp;&amp; $file != '..' &amp;&amp; $file !='.' ){ 
    	    
    if(is_file(&quot;./{$root}/{$file}&quot;)){
		    $list[0]++;
		    $list[
$list[0]] = $file;
	        }
            }
	}
        rewinddir($mydir);
 
       closedir($mydir);
    }
    return $list;
}

function GetDataFile($p
ath) {
    $data = &quot;&quot;;
    if(is_file($path)){
        $myfile = fo
pen ($path, &quot;r&quot;);
            while (!feof($myfile)) {
             
   $data .= fgets($myfile, 1024);
            }
        fclose($myfile);
    
}
    return $data;
}

function NoScript($string){
    $string = str_replac
e(&quot;&lt;&quot;, &quot;«&quot;, $string);
    $string = str_replace(&quot;&g
t;&quot;, &quot;»&quot;, $string);
    $string = str_replace(&quot;\n&quot;, &q
uot;&lt;br&gt;&quot;, $string);
    return $string;
}

?&gt;
</pre>
<br />
<a name='conclusion'></a><h2> Conclusion : </h2>
<br />Tout est dans le zip ;p
