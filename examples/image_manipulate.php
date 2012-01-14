<?php
/*
 * This example demonstrates complex usage of ImageProcessingTools library.
 * In this example we will create thumbnail, draw border lines and add watermark.
 *
 */

// import package classes
use Img\Image;
use Img\Tools\Resize;
use Img\Tools\Border;
use Img\Tools\Watermark;

error_reporting(E_ALL | E_STRICT);

// autoload function
require_once 'autoload_classes.php';

// path to image you want to resample
$img      =  'pics/lighthouse.jpg';
// thumbnail's save path
$savepath = 'pics/thumbnail.png';
// options required for manipulating image
$options = array('width' => 300,
                 'height' => 300,
                 'number'    => 2,         // number of lines
                 'thickness' => 1,         // border thickness
                 'margin'    => 5,        // margins from image borders
                 'space'     => 2,         // space between border lines
                 'color'     => 'FFFFFF'); // border color

try {
    // initialize Image class and necessary tool, in this case class Resize.
    $thumbnail = new Image(new Resize(), $options);
    // set image you want to resize
    $thumbnail->setImage($img);
    // call manipulate function to get resized image's copy
    $thumbnail->manipulate();
    // now draw borders
    $thumbnail->setTool(new Border(), $options);
    $thumbnail->manipulate();
    // save resized copy in $savepath file
    $thumbnail->save($savepath, IMAGETYPE_PNG);
    // or send image directly into browser
    /*if (!headers_sent()) {
        header("Content-type: image/png");
        $thumbnail->display(IMAGETYPE_PNG);
    }
    */
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
