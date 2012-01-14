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

class Border extends ImageTool
{
    protected $options = array(
                'number'    => 1,
                'thickness' => 1,
                'margin'    => 10,
                'space'     => 0,
                'color'     => '000000');

    protected $availableOptions = array(
                'number'    => 'unsigned int',
                'thickness' => 'unsigned int',
                'margin'    => 'unsigned int',
                'space'     => 'unsigned int',
                'color'     => 'unsigned int');

    public function manipulate($img)
    {
        // borders' bottom right corner coordinates
        $x = imagesx($img) - $this->options['margin'];
        $y = imagesy($img) - $this->options['margin'];

        $rgb = Utils::hexToRGB($this->options['color']);

        $color = imagecolorallocate($img, $rgb['r'], $rgb['g'], $rgb['b']);
        imagesetthickness($img, $this->options['thickness']);

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