<?php

$dir = ("./"); // on this file dir

// detect if the path has arabic characters and use " u "  optional to enable function to match multibyte characters

if (preg_match('#[\x{0600}-\x{06FF}]#iu', $dir) )
{
    // convert input ( utf-8 ) to output ( windows-1256 )
    $dir = iconv("utf-8","windows-1256",$dir);
}
if( is_dir($dir) )
{
    if(  ( $dh = opendir($dir) ) !== null  )
    {
        while ( ( $file = readdir($dh) ) !== false  )
        {

            echo "<img src=\"dossier.png\" alt=\"test\">.$file ." filetype : ".filetype($dir.$file)."";
        }
    }

}

?>