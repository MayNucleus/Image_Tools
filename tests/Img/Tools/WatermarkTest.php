<?php
/*
 * Part of ImageProcessingTools.
 */

namespace Img\Tools;

class WatermarkTest extends \PHPUnit_Framework_TestCase
{
    protected $stamp;
    protected $img;
    protected $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->stamp = imagecreate(50, 50);
        $this->img   = imagecreate(100,100);
        $this->obj   =  new Watermark();
    }

    public function testWatermark()
    {
        $this->obj->setOptions(array('stamp'=>$this->stamp));
        $img = $this->obj->manipulate($this->img);
        $this->assertEquals('gd', get_resource_type($img));
    }

    protected function tearDown()
    {
        imagedestroy($this->img);
        imagedestroy($this->stamp);
        unset($this->obj);
    }
}