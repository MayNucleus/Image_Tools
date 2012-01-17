<?php

/*
 * Part of ImageProcessingTools.
 */
namespace Img\Tools;

class ResizeTest extends \PHPUnit_Framework_TestCase
{
    protected $obj;
    protected $img;

    protected function setUp()
    {
        parent::setUp();
        $this->obj = new Resize();
        $this->img = imagecreate(500, 500);
    }

    /**
     * @dataProvider OptionsProvider
     */
    public function testResizeByCertainNumber($options)
    {
        $this->obj->setOptions($options);
        $img = $this->obj->manipulate($this->img);
        $this->assertLessThanOrEqual($options['width'], imagesx($img));
        $this->assertLessThanOrEqual($options['height'], imagesy($img));
    }

    public function Optionsprovider()
    {
        return array(array(array('width' => 100, 'height' => 100)),
                     array(array('width' => 100, 'height' => 50)));
    }

    public function testResizeByPercent()
    {
        $percent = 50;
        $width   = 250;
        $height  = 250;
        $this->obj->setOptions(array('percent'=>$percent));
        $img = $this->obj->manipulate($this->img);
        $this->assertLessThanOrEqual($width, imagesx($img));
        $this->assertLessThanOrEqual($height, imagesy($img));
    }
}