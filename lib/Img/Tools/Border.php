<?php
/**
 * This file is part of the ImageProcessingTools package
 *
 * @category  Image
 * @package   ImageProcessingTools
 * @author    Marina Lagun <mari.lagun@gmail.com>
 * @copyright 2012, Marina Lagun
 * @license   http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @link      Border.php
 */

namespace Img\Tools;

use Img\Tools\ImageTool;
use Img\Tools\Utils;

/**
 * Border class allows to draw borders.
 *
 * Parameters for borders drawing: number of border lines, border thickness,
 * intendation from the images edge, space between border lines and lines color.
 *
 * @category Image
 * @package  ImageProcessingTools
 * @author   Marina Lagun <mari.lagun@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @version  0.1
 * @link     Border
 * @since    0.1
 */
class Border extends ImageTool
{
    /**
     * List of $options array available options:
     * <pre>
     * number    int     number of border lines
     * thickness int     borders thickness in pixels
     * margin    int     intendation from the images edge
     * space     int     space between border lines in pixels
     * color     string  hex value in string
     * </pre>
     *
     * @var    array contains options, which will be used in image processing
     * @access protected
     */
    protected $options = array(
                'number'    => 1,
                'thickness' => 1,
                'margin'    => 10,
                'space'     => 0,
                'color'     => '000000');

    /**
     * Includes allowed options data types
     *
     * @var    array options data types
     * @access protected
     */
    protected $availableOptions = array(
                'number'    => 'unsigned int',
                'thickness' => 'unsigned int',
                'margin'    => 'unsigned int',
                'space'     => 'unsigned int',
                'color'     => 'string');

    /**
     * Border class's functionality implementation.
     *
     * @access public
     * @param  resource $img original image's resource
     * @return resource
     */
    public function manipulate($img)
    {
        // borders' bottom right corner coordinates
        $x = imagesx($img) - $this->options['margin'];
        $y = imagesy($img) - $this->options['margin'];

        $rgb = Utils::hexToRGB($this->options['color']);

        // set border lines color and thickness
        $color = imagecolorallocate($img, $rgb['r'], $rgb['g'], $rgb['b']);
        imagesetthickness($img, $this->options['thickness']);

        // draw borders
        for ($i = 0; $i < $this->options['number']; $i++) {
            // upper left corner
            $up_x = $this->options['margin'] + $i * ($this->options['thickness'] + $this->options['space']);
            $up_y = $this->options['margin'] + $i * ($this->options['space'] + $this->options['thickness']);
            // bottom right corner
            $bot_x = $x - $i * ($this->options['space'] + $this->options['thickness']);
            $bot_y = $y - $i * ($this->options['space'] + $this->options['thickness']);

            imagerectangle($img, $up_x, $up_y, $bot_x, $bot_y, $color);
        }

        return $img;
    }
}