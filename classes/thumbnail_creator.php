<?php
// Code by selfPHP
function resizePicture($file, $width, $height)
{

    if(!file_exists($file))
        return false;
    
    header('Content-type: image/jpeg');

    $info = getimagesize($file);

    if($info[2] == 1)
    {
        $image = imagecreatefromgif($file);
    }
    elseif($info[2] == 2)
    {
        $image = imagecreatefromjpeg($file);
    }
    elseif($info[2] == 3)
    {
        $image = imagecreatefrompng($file);
    }
    else
    {
            return false;
    }
    
    if ($width && ($info[0] < $info[1])) 
    {
        $width = ($height / $info[1]) * $info[0];
    } 
    else 
    {
        $height = ($width / $info[0]) * $info[1];
    }

    $imagetc = imagecreatetruecolor($width, $height);

    imagecopyresampled($imagetc, $image, 0, 0, 0, 0, $width, $height, 
        	$info[0], $info[1]);

    imagejpeg($imagetc, null, 100);    
    
}
 $width = 150;
$height = 100;

resizePicture($_GET['file'], $width, $height);
?>