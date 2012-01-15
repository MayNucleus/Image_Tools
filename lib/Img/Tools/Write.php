<?php
/**
 * This file is part of the ImageProcessingTools package
 *
 * @category  Image
 * @package   ImageProcessingTools
 * @author    Marina Lagun <mari.lagun@gmail.com>
 * @copyright Marina Lagun
 * @license   http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @link      Write.php
 */

namespace Img\Tools;

use Img\Tools\ImageTool;

/**
 * Write class allows to write textual data into image file.
 * Parameters that need to be specified for adding text: link to font file,
 * font's size, text color in hex string, also specify text direction,
 * transparency and offsets from images bottom right corner.
 *
 * @category Image
 * @package  ImageProcessingTools
 * @author   Marina Lagun <mari.lagun@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @version  0.1
 * @link     Write
 * @since    0.1
 */
class Write extends ImageTool
{
    /**
     * List of $options array available options:
     * <pre>
     * text         string textual data in UTF-8 encoding
     * angle        int    for text horizontal position: 0 and 90 for vertical
     * font         int    link to ttf fonts file
     * font_size    int    text size in pixels
     * color        hex    text color in string
     * transparency int    text transparency
     * v_offset     int    vertical offset from lower right corner
     * h_offset     int    horizontal offset from lower right corner
	 * </pre>
	 *
	 * @var    array contains options, which will be used in image processing
	 * @access protected
	 */
    protected $options = array(
        'text'         => 'Left blank',
        'angle'        => 0,
        'transparency' => 75,
        'font_size'    => 18,
        'h_offset'     => 10,
        'v_offset'     => 10);

    /**
	 * Includes allowed options data types
	 *
	 * @var    array options data types
	 * @access protected
	 */
    protected $availableOptions = array(
        'text'         => 'string',
        'angle'        => 'unsigned int',
        'transparency' => 'unsigned int',
        'font'         => 'string',
        'font_size'    => 'unsigned int',
        'color'        => 'string',
        'v_offset'     => 'unsigned int',
        'h_offset'     => 'unsigned int');

    /**
	 * Write class's functionality implementation.
	 *
	 * @access public
	 * @param  resource $img original image's resource
	 * @return boolean/resource
	 */
    public function manipulate($img) {
        if (!is_readable($this->options['font'])) {
            throw new \Exception('Could not read font file');
        }

        $angle = $this->options['angle'] == 90 ? 90 : 0;

        $textBox = imagettfbbox($this->options['font_size'], $angle, $this->options['font'], $this->options['text']);
        if (!$textBox) {
            return false;
        }

        if ($angle == 0) {
            $width = abs($textBox[2] - $textBox[0]);
            $height = abs($textBox[1] - $textBox[7]);

            // lower left corner
            $x = abs($textBox[0]);
            $y = $height - abs($textBox[1]);
        } elseif ($angle == 90) {
            $width = abs($textBox[0]) + abs($textBox[6]);
            $height = abs($textBox[1] - $textBox[3]);

            // lower left corner
            $x = $width - abs($textBox[0]);
            $y = $height - abs($textBox[1]);
        }

        if (function_exists('imagecreatetruecolor')) {
            $this->stamp = imagecreatetruecolor($width, $height);
        } else {
            $this->stamp = imagecreate($width, $height);
        }

        $rgb = Utils::hexToRGB($this->options['color']);
        $color = imagecolorallocate($this->stamp, $rgb['r'], $rgb['g'], $rgb['b']);

        $bg = imagecolorallocate($this->stamp, 255, 255, 255);
        $bg_transp = imagecolortransparent($this->stamp, $bg);

        // fill stamp image with transparent color
        imagefill($this->stamp, 0, 0, $bg_transp);

        imagettftext($this->stamp, $this->options['font_size'], $angle, $x, $y, $color, $this->options['font'], $this->options['text']);

        $img_x = imagesx($img);
        $img_y = imagesy($img);

        $dst_x = $img_x - $width - $this->options['h_offset'];
        $dst_y = $img_y - $height - $this->options['v_offset'];

        imagecopymerge($img, $this->stamp, $dst_x, $dst_y, 0, 0, $width, $height, $this->options['transparency']);

        imagedestroy($this->stamp);
        return $img;
    }

}