<?php
/*
 * Part of ImageProcessingTools.
 */

namespace Img;

use Img\Tools\Resize;

class ImageTest extends \PHPUnit_Framework_TestCase
{
    protected $obj;
    protected $temp = 'Img/Fixtures/temp.jpg';

    protected function setUp()
    {
        parent::setUp();
        $this->obj = new Image(new Resize());
    }

    public function testSetOptions()
    {
        $option = array('width'=>100);
        $this->assertTrue($this->obj->setOptions($option));
    }

    public function testSetTool()
    {
        $this->assertTrue($this->obj->setTool(new Resize()));
    }

    public function testSetImage()
    {
        $this->assertTrue($this->obj->setImage(imagecreate(50,50)));

    }

    public function testImageParameters()
    {
        $this->obj->setImage(imagecreate(50,50));
        $this->assertEquals('gd', get_resource_type($this->obj->getResource()));
        $this->assertEquals(50, $this->obj->getWidth());
        $this->assertEquals(50, $this->obj->getHeight());
    }

    public function testSave()
    {
        $img = 'Img/Fixtures/lighthouse.jpg';
        $this->obj->setImage($img);
        $this->obj->save($this->temp, IMAGETYPE_JPEG);
        $this->assertFileExists($this->temp);
    }

    public function testSaveDomainException()
    {
        try{
            $this->obj->save('JPEG');
        } catch (\DomainException $e) {
            return;
        }
        $this->fail('DomainException expected!');
    }

    public function testOutput()
    {
        $this->obj->setImage('Img/Fixtures/lighthouse.jpg');
        $this->assertTrue($this->obj->output());
    }

    public function testOutputWrongImageType()
    {
        try {
            $this->obj->output('JPEG');
        } catch (\DomainException $e) {
            return;
        }
        $this->fail('DomainException expected!');
    }

    public function testManipulate()
    {
        $img = 'Img/Fixtures/lighthouse.jpg';
        $src = $this->obj->manipulate($img);
        $this->assertEquals('gd', get_resource_type($src));
    }

    protected function tearDown()
    {
        if (file_exists($this->temp)) {
            unlink($this->temp);
        }
    }
}