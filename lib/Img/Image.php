<?php
/**
 * Main file in ImageProcessingTools package
 *
 * @category  Image
 * @package   ImageProcessingTools
 * @author    Marina Lagun <mari.lagun@gmail.com>
 * @copyright Marina Lagun 2011
 * @license   http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @link      Image.php
 */

namespace Img;
use Img\Tools\Thumbnail;
use Img\Tools\Border;
use Img\Tools\Watermark;
use Img\Tools\ImageTool;

/**
 * Class Image implements several basic image processing methods, such as image
 * resource creation, result image outputting into browser, saving image on the disk.
 * Also it allows to load different image processing tools on the runtime.
 *
 * @category Image
 * @package  ImageProcessingTools
 * @author   Marina Lagun <mari.lagun@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @version  0.1
 * @link     Image
 * @since    0.1
 */
class Image
{
    /**
     *
     * Contains object of ImageTools class, which implements image
     * manipulation methods.
     *
     * @var    object
     * @access protected
     */
    protected $tool = null;

    /**
     *
     * Contains image's GD resource
     *
     * @var    resource
     * @access protected
     */
    protected $src = null;

    /**
     *
     * Constructor
     *
     * expects an instance of the ImageTool and (optional) tool's options array.
     *
     * @param ImageTool $tool    ImageTool subclass
     * @param array     $options optional
     */
    public function __construct(ImageTool $tool, array $options = array())
    {
        $this->setTool($tool, $options);
        //$this->tool = $tool;
    }

    /**
     * Set image processing tool's options
     *
     * typical $options array :
     * ('foo' => 'foo',
     *  'bar' => 1)
     *
     * @access public
     * @param  array  $options contains tool's options
     * @return bool
     */
    public function setOptions(array $options = array())
    {
        if ($this->tool->setOptions($options)) {
            return true;
        }
        return false;
    }

    /**
     * Publish result image into browser
     *
     * it is possible to select image type, by default image's type is png.
     *
     * @access public
     * @param  const   $type default: IMAGETYPE_PNG (IMAGETYPE_(GIF|JPEG|WBMP))
     * @return image
     */
    public function display($type = IMAGETYPE_PNG)
    {

        //if (headers_sent()) {
        //	throw new RuntimeException('Could not display image: headers have already been sent!');
        //}

        //$ctype = image_type_to_mime_type($type);
        //header('Content-Type:'.$ctype);

        switch ($type) {
            case IMAGETYPE_GIF:
                return imagegif($this->src);
                break;

            case IMAGETYPE_PNG:
                return imagepng($this->src);
                break;

            case IMAGETYPE_JPEG:
                return imagejpeg($this->src);
                break;

            case IMAGETYPE_WBMP:
                return imagewbmp($this->src);
                break;

            default:
                throw new \UnexpectedValueException('Unknown image extention!');
                break;
        } //end switch
    }

    /**
     * Save result image into file
     *
     * method expects path to file and optional parameter image type. Specified file
     * should be writable.
     *
     * @access public
     * @param  string  $filename path to file
     * @param  const   $type     default: IMAGETYPE_PNG (IMAGETYPE_(GIF|JPEG|WBMP))
     * @return image
     */
    public function save($filename, $type = IMAGETYPE_PNG)
    {

        if (!is_writable(dirname($filename))) {
            throw new \Exception('Could not save image in a given directory!');
        }

        switch ($type) {
            case IMAGETYPE_GIF:
                return imagegif($this->src, $filename);
                break;

            case IMAGETYPE_PNG:
                return imagepng($this->src, $filename);
                break;

            case IMAGETYPE_JPEG:
                return imagejpeg($this->src, $filename);
                break;

            case IMAGETYPE_WBMP:
                return imagewbmp($this->src, $filename);
                break;

            default:
                throw new \UnexpectedValueException('Unknown image extention!');
                break;
        } //end switch
        //return false;
    }

    /**
     * Sends gd image to image processing tool and checks the returned result.
     *
     * @access protected
     * @param  string    $img image file, string or resource
     * @return resource
     */
    public function manipulate($img)
    {
        if (! $this->setImage($img)) {
            throw new \Exception("Could not create image resource from given file!");
        }

        $this->src = $this->tool->manipulate($this->src);

        return $this->src;
    }

    /**
     *
     * Method allows to change image processing tool and its options
     * at the runtime.
     *
     * @access public
     * @param  ImageTool $tool    ImageTool's class object
     * @param  array     $options Tool's options array
     * @return boolean
     */
    public function setTool(ImageTool $tool, array $options = array())
    {
        $this->tool = $tool;
        if (!empty($options)) {
            $this->setOptions($options);
        }

        return true;
    }

    /**
     * Method allows to set new image.
     *
     * @param  string  $img image file, string or resource
     * @return boolean
     */
    public function setImage($img)
    {
        $this->src = $this->tool->createImage($img);
        if (!$this->src) {
            return false;
        }

        return true;
    }

    /**
     * Method return current image resource.
     *
     * @return resource
     */
    public function getResource()
    {
        return $this->src;
    }
}