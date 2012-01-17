<?php
/**
 * This file is part of the ImageProcessingTools package
 *
 * @category  Image
 * @package   ImageProcessingTools
 * @author    Marina Lagun <mari.lagun@gmail.com>
 * @copyright 2012, Marina Lagun
 * @license   http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @link      Crop.php
 */

namespace Img\Tools;

use Img\Tools\ImageTool;

/**
 * Crop class implements ability to crop certain area out of original image.
 *
 * Parameters needed for image cropping:upper left corner x and y coordinates,
 * cropping area width and height.
 *
 * @category Image
 * @package  ImageProcessingTools
 * @author   Marina Lagun <mari.lagun@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @version  0.1
 * @link     Crop
 * @since    0.1
 */
class Crop extends ImageTool {

    /**
     * List of $options array available options:
     * <pre>
     * x       int     cropping area upper left corner x coordinate
     * y       int     cropping area upper left corner y coordinate
     * width   int     cropping area width
     * height  int     cropping area height
     * </pre>
     *
     * @var    array contains options, which will be used in image processing
     * @access protected
     */
    protected $options = array(
        'x' => 0,
        'y' => 0);

    /**
     * Includes allowed options data types
     *
     * @var    array options data types
     * @access protected
     */
    protected $availableOptions = array(
        'x'      => 'unsigned int',
        'y'      => 'unsigned int',
        'width'  => 'unsigned int',
        'height' => 'unsigned int');

    /**
     * Crop class's functionality implementation.
     *
     * @access public
     * @param  resource $img original image's resource
     * @return resource
     */
    public function manipulate($img) {
        $width  = imagesx($img);
        $height = imagesy($img);
        // cropping area upper left corner
        $imgX = $this->options['x'] < $width  ? $this->options['x'] : $width - 1;
        $imgY = $this->options['y'] < $height ? $this->options['y'] : $height - 1;

        $imgWidth  = $this->options['width'] <= $width ? $this->options['width'] : $width;
        $imgHeight = $this->options['height'] <= $height ? $this->options['height'] : $height;

        $checkWidth = $imgX + $imgWidth;
        if ($checkWidth > $width) {
            $imgWidth = $width - $imgX;
        }

        $checkHeight = $imgY + $imgHeight;
        if ($checkHeight > $height) {
            $imgHeight = $height - $imgY;
        }

        // create a target image
        if (function_exists('imagecreatetruecolor')) {
            $this->resultImage = imagecreatetruecolor($imgWidth, $imgHeight);
        } else {
            $this->resultImage = imagecreate($imgWidth, $imgHeight);
        }

        // enable transparency if supported
        if (GD_VERSION >= '2.0.28') {
            imagealphablending($this->resultImage, false);
            imagesavealpha($this->resultImage, true);
        }

        // get resultImage
        imagecopy($this->resultImage, $img, 0, 0, $imgX, $imgY,
                            $imgWidth, $imgHeight);

        imagedestroy($img);
        return $this->resultImage;
    }
}
