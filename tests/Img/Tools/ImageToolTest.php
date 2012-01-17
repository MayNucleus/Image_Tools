<?php
/*
 * Part of ImageProcessingTools.
 */

namespace Img\Tools;

class ImageToolTest extends \PHPUnit_Framework_TestCase
{
    protected $obj;

    protected function setUp()
    {
        $this->obj = $this->getMockForAbstractClass(__NAMESPACE__.'\ImageTool');
    }

    /**
     * @dataProvider ImageDataProvider
     */
    public function testCreateImage($data)
    {
        $img = $this->obj->createImage($data);
        $this->assertEquals('gd', get_resource_type($img));
    }

    public function ImageDataProvider()
    {
         $string = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
       . 'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
       . 'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
       . '8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';
         $string = base64_decode($string);

        return array(
            array('Img/Fixtures/ng.com.jpg'),
            array($string),
            array(imagecreate(50,50))
        );

    }

    public function testCreateImageException()
    {
        try {
            $this->obj->createImage();
        } catch (\Exception $e) {
            return;
        }
        $this->fail('Exception have not been raised!');
    }

    /**
     * @TODO implement test for setOptions method
     */

    protected function tearDown()
    {
        unset($this->obj);
    }
}