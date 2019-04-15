<?php

require_once 'libs/phpThumb/src/ThumbLib.inc.php';

try
{
	 $thumb = PhpThumbFactory::create('image.png');
	 $thumb2 = PhpThumbFactory::create('image.png');
}
catch (Exception $e)
{
	echo "IMAGE NOT FOUND";
     // handle error here however you'd like
}


$thumb->resize(100, 100);
$thumb2->resize(250, 250);
//$thumb->show();
$thumb->save("tn_image.jpg");
$thumb2->save("lrg_image.jpg");

?>



asdf