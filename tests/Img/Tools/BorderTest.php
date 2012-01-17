<?php
/**
 *Part of ImageProcessingTools.
 */

namespace Img\Tools;

class BorderTest extends \PHPUnit_Framework_TestCase
{
    protected $obj;
    protected $img;

    protected function setUp()
    {
        parent::setUp();
        $this->img = imagecreate(100, 100);
        $this->obj = new Border();
    }

    public function testDrawBorders()
    {
        $img = $this->obj->manipulate($this->img);
        $this->assertEquals('gd', get_resource_type($img));
    }

    protected function tearDown()
    {
        imagedestroy($this->img);
        unset($this->obj);
    }
}
