<?php
/*
 * Part of ImageProcessingTools.
 */

namespace Img\Tools;

class CropTest extends \PHPUnit_Framework_TestCase
{
    protected $obj;
    protected $img;

    protected function setUp()
    {
        parent::setUp();
        $this->obj = new Crop();
        $this->img = imagecreate(300, 300);
    }

    /**
     * @dataProvider OptionsProvider
     */
    public function testCrop($options, $equal)
    {
        $this->obj->setOptions($options);
        $img = $this->obj->manipulate($this->img);
        $this->assertEquals($equal, imagesx($img));
        $this->assertEquals($equal, imagesy($img));
    }

    public function OptionsProvider()
    {
        return array(
            array(array('x' => 0,   'y' => 0,  'width' => 100, 'height' => 100), 100),
            array(array('x' => 300, 'y' => 300,'width' => 110, 'height' => 110), 1),
            array(array('x' => 0,   'y' => 0,  'width' => 310, 'height' => 310), 300),
            array(array('x' => 300, 'y'=> 300, 'width' => 300, 'height' => 300), 1)
        );
    }
}
