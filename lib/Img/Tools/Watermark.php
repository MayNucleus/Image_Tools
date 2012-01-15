<?php
/**
 * This file is part of the ImageProcessingTools package
 *
 * @category  Image
 * @package   ImageProcessingTools
 * @author    Marina Lagun <mari.lagun@gmail.com>
 * @copyright Marina Lagun
 * @license   http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @link      Watermark.php
 */

namespace Img\Tools;

use Img\Tools\ImageTool;
use Img\Tools\Utils;

/**
 * Watermark class creates watermarks from image file or string. Allowed is to set
 * text TrueType font, font size, color. Also manage watermark transparency, offset
 * and choose between 0 and 90 angle degrees.
 *
 * @category Image
 * @package  ImageProcessingTools
 * @author   Marina Lagun <mari.lagun@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @version  0.1
 * @link     Watermark
 * @since    0.1
 */
class Watermark extends ImageTool {

    /**
     * List of $options array available options:
     * <pre>
     * stamp        mixed  image or text
     * font         string link to TrueType font file
     * font_size    int    TrueType font size
     * color        string hex color in string
     * transparency int    transparency level of the watermark
     * h_offset     int    horizontal offset from the image's bottom right corner
     * v_offset     int    horizontal offset from the image's bottom right corner
     * angle        const  possible values: 0 and 90 degrees.
     * </pre>
     *
     * @var    array contains options, which will be used for watermark creation
     * @access protected
     */
    protected $options = array(
        'h_offset'     => 10,
        'v_offset'     => 10,
        'angle'        => 0,
        'transparency' => 50);

    /**
     * Includes allowed options data types
     *
     * @var    array options data types
     * @access protected
     */
    protected $availableOptions = array(
        'stamp'        => 'mixed',
        'transparency' => 'unsigned int',
        'h_offset'     => 'unsigned int',
        'v_offset'     => 'unsigned int',
        'angle'        => 'unsigned int');

    /**
     * Property contains watermark's gd resource
     *
     * @var    resource gd resource
     * @access protected
     */
    protected $stamp = null;

    /**
     * Method copies watermark into given image with given parameters.
     *
     * @param  resource $img image's resource
     * @return resource
     */
    public function manipulate($img) {
        // prepare stamp
        $this->stamp = $this->createImage($this->options['stamp']);

        $width = imagesx($this->stamp);
        $height = imagesy($this->stamp);

        $img_x = imagesx($img);
        $img_y = imagesy($img);

        $dst_x = $img_x - $width - $this->options['h_offset'];
        $dst_y = $img_y - $height - $this->options['v_offset'];

        imagecopymerge($img, $this->stamp, $dst_x, $dst_y, 0, 0, $width, $height, $this->options['transparency']);

        return $img;
    }

}