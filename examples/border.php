<?php
/*
 * Example of Border class usage.
 * NB! Crop class works only with a copy of the original image.
 *
 */

// import package classes
use Img\Image;
use Img\Tools\Border;

error_reporting(E_ALL | E_STRICT);

// autoload function
require_once 'autoload_classes.php';

// path to image you want to resample
$img      =  'pics/lighthouse.jpg';
// thumbnail's save path
$savepath = 'pics/thumbnail.png';
// options required for manipulating image
$options = array('number'    => 2,         // number of lines
                 'thickness' => 1,         // border thickness
                 'margin'    => 15,        // margins from image borders
                 'space'     => 5,         // space between border lines
                 'color'     => 'FFFFFF'); // border color

try {
    // initialize Image class and necessary tool, in this case class Resize.
    $thumbnail = new Image(new Border(), $options);
    // set image you want to resize
    $thumbnail->setImage($img);
    // call manipulate function to get resized image's copy
    $thumbnail->manipulate();
    // save resized copy in $savepath file
    $thumbnail->save($savepath, IMAGETYPE_PNG);
    // or send image directly into browser
    /*if (!headers_sent()) {
        header("Content-type: image/png");
        $thumbnail->display(IMAGETYPE_PNG);
    }
    */
} catch (UnexpectedValueException $e) {
    echo $e->getMessage();
} catch (DomainException $e) {
    echo $e->getMessage();
} catch (LengthException $e) {
    echo $e->getMessage();
} catch (InvalidArgumentException $e) {
    echo $e->getMessage();
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
