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

/**
 * Utils class contains special method used by other image processing classes.
 *
 * @category Image
 * @package  ImageProcessingTools
 * @author   Marina Lagun <mari.lagun@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @version  0.1
 * @link     Utils
 * @since    0.1
 */
class Utils
{
	/**
 	 *
 	 * Method converts hexademical value in a RGB array.
 	 *
 	 * @param string $hex hexademical value in string
     * @return array
 	 */
 	public static function hexToRGB($hex)
 	{
        if (preg_match('/^(0x)|(x)/i', $hex, $match)) {
            $hex = substr($hex, count($match));
        }

 	    return array('r' => hexdec(substr($hex, 0, 2)),
 	                 'g' => hexdec(substr($hex, 2, 2)),
 	                 'b' => hexdec(substr($hex, 4, 2)));
 	}
}