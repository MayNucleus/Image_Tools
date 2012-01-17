<?php
/*
 * Part of ImageProcessingTools.
 */

namespace Img\Tools;

class UtilsTest extends \PHPUnit_Framework_TestCase
{
    /**
     *@dataProvider hexStringProvider
     */
    public function testHexToRGB($hex, $equals)
    {
        $rgb = Utils::hexToRGB($hex);
        $this->assertEquals($equals['r'], $rgb['r']);
        $this->assertEquals($equals['g'], $rgb['g']);
        $this->assertEquals($equals['b'], $rgb['b']);
    }

    public function hexStringProvider()
    {
        return array(
            array('FF00CB',   array('r' => 255, 'g' => 0, 'b' => 203)),
            array('0xFFFFFF', array('r' => 255, 'g' => 255, 'b' => 255)),
            array('x000000',  array('r' => 0, 'g' => 0, 'b' => 0))
        );
    }
}
