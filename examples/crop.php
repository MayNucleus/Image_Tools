<?php
/*
 * Example of Crop class usage.
 * NB! Crop class works only with a copy of the original image.
 *
 */

// import package classes
use Img\Image;
use Img\Tools\Crop;

error_reporting(E_ALL | E_STRICT);

// autoload function
require_once 'autoload_classes.php';

// path to image you want to resample
$img      =  'pics/lighthouse.jpg';
// thumbnail's save path
$savepath = 'pics/thumbnail.png';
// options required for manipulating image
$options = array('x' => 0,         // cropping area upper left corner
                 'y' => 0,         // cropping area upper left corner
                 'width'  => 100,  // cropping area width
                 'height' => 100); // cropping area height

try {
    // initialize Image class and necessary tool, in this case class Resize.
    $thumbnail = new Image(new Crop(), $options);
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
