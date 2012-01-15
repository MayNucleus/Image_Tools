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
// options for image resizing
$thumb = array('width'    => 300,
                 'height' => 300);
// options for drawing borders
$borders = array('number'    => 2,         // number of lines
                 'thickness' => 1,         // border thickness
                 'margin'    => 5,         // margins from image borders
                 'space'     => 2,         // space between border lines
                 'color'     => 'FFFFFF'); // border color
// options for adding watermark
$watermark = array('stamp'        => 'pics/copyright.jpg', // watermark image
                   'transparency' => 25,                   // watermark transparency
                   'h_offset'     => 300,                  // offset from bottom
                   'v_offset'     => 300,                  // right corner
                   'angle'        => 0);                   // horizontal position
try {
    // initialize Image class and necessary tool, in this case class Resize.
    $thumbnail = new Image(new Resize(), $thumb);
    // call manipulate function to get resized image's copy
    $thumbnail->manipulate($img);
    // now draw borders
    $thumbnail->setTool(new Border(), $borders);
    $thumbnail->manipulate();
    // now draw watermark on thumbnail
    $thumbnail->setTool(new Watermark(), $watermark);
    $thumbnail->manipulate();
    // save resized copy in $savepath file
    $thumbnail->save($savepath, IMAGETYPE_PNG);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
