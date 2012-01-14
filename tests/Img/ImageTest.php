<?php

namespace Img;

class ImageTest extends PHPUnit_Framework_TestCase
{
    protected $obj = null;

    protected function setUp()
    {
        parent::setUp();
        $this->obj = new Image(new Thumbnail());
    }

    public function testObject()
    {
        $this->assertTrue(is_object($this->obj));
    }

    /**
     * @dataProvider ImageTypesProvider
     */
    public function testCreateImage($img)
    {
        $src = $this->obj->createImage($img);
        $this->assertTrue(is_resource($src));
    }

    public function ImageTypesProvider()
    {
        $data = 'iVBORw0KGgoAAAANSUhEUgAAABwAAAASCAMAAAB/2U7WAAAABl'
        .'BMVEUAAAD///+l2Z/dAAAASUlEQVR4XqWQUQoAIAxC2/0vXZDr'
        .'EX4IJTRkb7lobNUStXsB0jIXIAMSsQnWlsV+wULF4Avk9fLq2r'
        .'8a5HSE35Q3eO2XP1A1wQkZSgETvDtKdQAAAABJRU5ErkJggg==';
        $data = base64_decode($data);

        return array(array(TEST_PATH.'/Fixtures/fail.png'),
        array(TEST_PATH.'/Fixtures/ng.com.jpg'),
        array(TEST_PATH.'/Fixtures/eclipse.gif'),
        array(TEST_PATH.'/Fixtures/Baboon.wbmp'),
        array($data));
    }

    /**
     * @dataProvider savePathesProvider
     */
    public function testSave($savepath, $type)
    {
        $img = TEST_PATH.'/Fixtures/ng.com.jpg';
        $this->obj->createImage($img);
        $this->obj->save($savepath, $type);
        $this->assertFileExists($savepath);
    }

    public function savePathesProvider()
    {
        $dir = TEST_PATH.'/Fixtures/';
        return array(array($dir.'ng.png', IMAGETYPE_PNG),
                     array($dir.'ng.jpg', IMAGETYPE_JPEG),
                     array($dir.'ng.gif', IMAGETYPE_GIF),
                     array($dir.'ng.bmp', IMAGETYPE_WBMP));
    }


   /* public function testDisplay($type)
    {
        $img = TEST_PATH.'/Fixtures/ng.com.jpg';
        $this->obj->createImage($img);
        $src = $this->obj->display($type);
        $this->assertInternalType('resource', $src);
    }

    public function imageExtensionsProvider()
    {
        return array(array(IMAGETYPE_PNG),
                     array(IMAGETYPE_JPEG),
                     array(IMAGETYPE_GIF),
                     array(IMAGETYPE_WBMP));
    }
*/
    public function testManipulate()
    {
        $img = TEST_PATH.'/Fixtures/ng.com.jpg';
        $this->obj->createImage($img);
        $src = $this->obj->manipulate();
        $this->assertInternalType('resource', $src);
    }
}