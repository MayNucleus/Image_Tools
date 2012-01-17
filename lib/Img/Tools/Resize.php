<?php
/**
 * This file is part of the ImageProcessingTools package
 *
 * @category  Image
 * @package   ImageProcessingTools
 * @author    Marina Lagun <mari.lagun@gmail.com>
 * @copyright 2012, Marina Lagun
 * @license   http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @link      Resize.php
 */

namespace Img\Tools;

use Img\Tools\ImageTool;

/**
 * Resize class implements image resizing option, allowing to
 * resize original image.
 * Parameters that need to be specified for image resizing: thumbnail width and
 * height.
 * To resize image for certain percent, you should specify resizing percent.
 *
 * @category Image
 * @package  ImageProcessingTools
 * @author   Marina Lagun <mari.lagun@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @version  0.1
 * @link     Resize
 * @since    0.1
 */
class Resize extends ImageTool
{
    /**
     * List of $options array available options:
     * <pre>
     * width   int     thumbnail's width
     * height  int     thumbnail's height
     * percent numeric size of the thumbnail per size of the original image
	 * </pre>
	 *
	 * @var    array contains options, which will be used in image processing
	 * @access protected
	 */
    protected $options = array (
		'width'   => 100,
		'height'  => 100,
		'percent' => null);

	/**
	 * Includes allowed options data types
	 *
	 * @var    array options data types
	 * @access protected
	 */
	protected $availableOptions = array (
		'width'   => 'unsigned int',
		'height'  => 'unsigned int',
		'percent' => 'numeric');

	/**
	 * Resize class's functionality implementation.
	 *
	 * @access public
	 * @param  resource $img original image's resource
	 * @return resource
	 */
	public function manipulate($img) {
        // $img upper left corner
        $imgX = 0;
        $imgY = 0;

        $imgWidth = imagesx($img);
        $imgHeight = imagesy($img);

        if ($this->options['percent']) {
            // get thumbnail size in percents
            $this->options['width'] = $imgWidth * $this->options['percent'] / 100;
            $this->options['height'] = $imgHeight * $this->options['percent'] / 100;
        } else {
            // resample thumbnail to a given scale
            $imgRatio = $imgWidth / $imgHeight;
            if ($this->options['width'] / $this->options['height'] > $imgRatio) {
                $this->options['width'] = $this->options['height'] * $imgRatio;
            } else {
                $this->options['height'] = $this->options['width'] / $imgRatio;
            }
        }

		// create a target image
		if (function_exists('imagecreatetruecolor')) {
			$this->resultImage = imagecreatetruecolor($this->options['width'],
			                                          $this->options['height']);
		} else {
			$this->resultImage = imagecreate($this->options['width'],
			                                 $this->options['height']);
		}

		// enable transparency if supported
		if (GD_VERSION >= '2.0.28') {
			imagealphablending($this->resultImage, false);
			imagesavealpha($this->resultImage, true);
		}

		// get resultImage
        if (function_exists('imagecopyresampled')) {
            $result = imagecopyresampled($this->resultImage, $img, 0, 0,
                    $imgX, $imgY, $this->options['width'], $this->options['height'],
                    $imgWidth, $imgHeight);
        } else {
            $result = imagecopyresized($this->resultImage, $img, 0, 0, $imgX, $imgY,
                    $this->options['width'], $this->options['height'], $imgWidth, $imgHeight);
        }

		imagedestroy($img);
		return $this->resultImage;
	}
}