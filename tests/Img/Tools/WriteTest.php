<?php
/*
 * Part of ImageProcessingTools.
 */

namespace Img\Tools;

class WriteTest extends \PHPUnit_Framework_TestCase
{
    protected $img;
    protected $obj;

    protected function setUp()
    {
        parent::setUp();
        $this->img = imagecreate(100,100);
        $this->obj = new Write();
    }

    public function testFontException()
    {
        try{
            $this->obj->manipulate($this->img);
        } catch (\Exception $e) {
            return;
        }

        $this->fail('Exception have not been raised!');
    }

    public function testWrite()
    {
        $font = 'Img/Fixtures/backtobay.ttf';
        $this->obj->setOptions(array('font'=>$font));
        $img = $this->obj->manipulate($this->img);
        $this->assertEquals('gd', get_resource_type($img));
    }

    protected function tearDown()
    {
        imagedestroy($this->img);
        unset($this->obj);
    }
}