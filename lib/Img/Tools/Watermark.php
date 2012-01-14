<?php
/**
 * @category  Image
 * @package   ImageProcessingTools
 * @author    Marina Lagun <mari.lagun@gmail.com>
 * @copyright Marina Lagun
 * @license   http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @link      Utils.php
 */

namespace Img\Tools;
use Img\Tools\ImageTool;
use Img\Tools\Utils;

// watermark horizontal position
define('HORIZONTAL_POSITION', 0);
// watermark vertical position
define('VERTICAL_POSITION', 90);

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
 * @link     Thumbnail
 * @since    0.1
 */
class Watermark extends ImageTool
{
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
                'stamp'        => 'Left blank',
                'color'        => '000000',
                'h_offset'     => 10,
                'v_offset'     => 10,
                'angle'        => HORIZONTAL_POSITION,
                'transparency' => 50);

    /**
	 * Includes allowed options data types
	 *
	 * @var    array options data types
	 * @access protected
	 */
    protected $availableOptions = array(
                'stamp'        => 'mixed',
                'font'         => 'string',
                'font_size'    => 'unsigned int',
                'color'        => 'string',
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
    public function manipulate($img)
    {
        // prepare stamp
        if (is_string($this->options['stamp'])) {
            if ($this->options['angle'] != HORIZONTAL_POSITION
                || $this->options['angle'] != VERTICAL_POSITION) {
                throw new \UnexpectedValueException('Wrong angle!');
            }

            if (!is_readable($this->options['font'])) {
                throw new \Exception('Could not read font file');
            }

            $stamp = html_entity_decode($this->options['stamp'], ENT_QUOTES, UTF-8);

            $textBox = imagettfbbox($this->options['font_size'], $this->options['angle'],
                                    $this->options['font'], $stamp);
            if ($textBox) {
                $width = abs($textBox[4] + $textBox[0]);
                $height = abs($textBox[3] + $textBox[1]);

                // lower left corner
                $x = abs($textBox[0]);
                $y = $height - abs($textBox[1]);

                if (function_exists('imagecreatetruecolor')) {
                    $this->stamp = imagecreatetruecolor($width, $height);
                } else {
                    $this->stamp = imagecreate($width, $height);
                }

                $bg = imagecolorallocate($this->stamp, 255, 255, 255);
                imagecolortransparent($this->stamp, $bg);

                $rgb = Utils::hexToRGB($this->options['color']);
                $color = imagecolorallocate($this->stamp, $rgb['r'], $rgb['g'], $rgb['b']);

                imagettftext($this->stamp, $this->options['font_size'], $this->options['angle'],
                             $x, $y, $color, $this->options['font'], $stamp);
            }
        } else {
            $this->stamp = $this->createImage($this->options['stamp']);

            $width = imagesx($this->stamp);
            $height = imagesy($this->stamp);
        }

        $img_x = imagesx($img);
        $img_y = imagesy($img);

        $dst_x = $img_x - $width - $this->options['h_offset'];
        $dst_y = $img_y - $height - $this->options['v_offset'];

        imagecopymerge($img, $this->stamp, $dst_x, $dst_y, 0, 0, $width, $height, $this->options['transparency']);

        return $img;
    }
}