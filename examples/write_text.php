<?php
/*
 * Example of Watermark class usage.
 *
 *
 */

// import package classes
use Img\Image;
use Img\Tools\Write;

error_reporting(E_ALL | E_STRICT);

// autoload function
require_once 'autoload_classes.php';

// path to image you want to resample
$img      =  'pics/lighthouse.jpg';
// thumbnail's save path
$savepath = 'pics/thumbnail.png';
// options required for manipulating image
$options = array('text'         => 'Copyright',
                 'transparency' => 100,
                 'angle'        => 90,  // equivalent to vertical position
                 'font'         => '/home/may/www/Img/examples/backtobay.ttf',
                 'font_size'    => 30,
                 'font_color'   => 'FF0000',
                 'v_offset'     => 15,  // intendation from the images edge
                 'h_offset'     => 15); // in pixels

try {
    // initialize Image class and necessary tool, in this case class Resize.
    $thumbnail = new Image(new Write(), $options);
    // set image you want to resize
    //$thumbnail->setImage($img);
    // call manipulate function to get resized image's copy
    $thumbnail->manipulate($img);
    // save resized copy in $savepath file
    $thumbnail->save($savepath, IMAGETYPE_PNG);
    // or send image directly into browser
    /*if (!headers_sent()) {
        header("Content-type: image/png");
        $thumbnail->output(IMAGETYPE_PNG);
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
