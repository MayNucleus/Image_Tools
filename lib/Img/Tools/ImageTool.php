<?php
/**
 * @category  Image
 * @package   ImageProcessingTools
 * @author    Marina Lagun <mari.lagun@gmail.com>
 * @copyright 2011, Marina Lagun
 * @license   http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @link      ImageTool.php
 */

namespace Img\Tools;

/**
 * Abstract class ImageTool
 *
 * defines common interface for child classes, that implement image manipulation
 * tools.
 *
 * @category Image
 * @package  ImageProcessingTools
 * @author   Marina Lagun <mari.lagun@gmail.com>
 * @license  http://www.gnu.org/copyleft/gpl.html Freely available under GPL
 * @version  0.1
 * @link     ImageTool
 * @since    0.1
 */
 abstract class ImageTool
 {
 	/**
 	 * Contains available options of a subclass. Index of the array is options name.
 	 * For example:
 	 * $options = array('width'     => 100,
 	 * 					'signature' => 'Marina Lagun')
 	 *
 	 * @var    array
 	 * @access protected
 	 */
 	protected $options = array();

 	/**
 	 * Has to contain all available options of a subclass and their correct types
 	 * e.g. ('width'     => 'int',
 	 * 'signature' => 'string') etc. setOptions method supports following data types:
 	 * <ul>
 	 *  <li>bool | boolean</li>
 	 *  <li>[signed | unsigned] int | integer</li>
 	 *  <li>float</li>
 	 *  <li>numeric</li>
 	 *  <li>string</li>
 	 *  <li>mixed</li>
 	 * </ul>
 	 *
 	 * @var    array
 	 * @access protected
 	 */
 	protected $availableOptions = array();

 	/**
 	 * Contains processing image's GD resource
 	 *
 	 * @var resource
 	 * @access protected
 	 */
 	protected $src = null;

 	/**
 	 * Contains result image's GD resource
 	 *
 	 * @var    resource
 	 * @access protected
 	 */
 	protected $resultImage = null;

 	/**
 	 * Abstract method, must be implemented by a child class.
 	 *
 	 * @abstract
 	 * @access public
 	 * @param  resource $img image resource
 	 */
 	abstract public function manipulate($img);

 	/**
 	 * Method takes $options array and checks if given properties and values are
 	 * correct. Method return true if given array is empty.
 	 * Possible data types:
 	 * <ul>
 	 * <li>bool/boolean</li>
 	 * <li>[signed/unsigned] int/integer</li>
 	 * <li>float</li>
 	 * <li>numeric</li>
 	 * <li>image</li>
 	 * <li>gd resource</li>
 	 * <li>string</li>
 	 * <li>mixed</li>
 	 * </ul>
 	 *
 	 *
 	 * @access public
 	 * @param  array $options tool's properties
 	 */
 	public function setOptions(array $options = array())
 	{
 	    if (empty($options)) {
			return true;
		}

 	    // filter for unsigned integers
 	    $unsignedFilter = array('options' => array(
                                    'default' => 0,
 	                                'min_range' => 0));

		foreach ($options as $key => $value) {
		    $availableOption = @$this->availableOptions[$key];
		    if (!isset($availableOption)) {
		        continue;
		    }

			//case insensitive switch
			switch(strtolower($availableOption)) {
			    case 'int':
			    case 'integer':
			    case 'signed int':
			    case 'signed integer':
			        if (!filter_var($value, FILTER_VALIDATE_INT)) {
			            throw new \LengthException("$key value type should be signed integer!");
			        }
			        $this->options[$key] = $value;
			        break;

			    case 'unsigned int':
			    case 'unsigned integer':
                    $this->options[$key] = filter_var($value, FILTER_VALIDATE_INT, $unsignedFilter);
			        break;

			    case 'bool':
			    case 'boolean':
			        $this->options[$key] = filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
			        break;

			    case 'numeric':
			    case 'float':
			        if (!filter_var($value, FILTER_VALIDATE_FLOAT)) {
			            throw new \InvalidArgumentException("$key value type should be float");
			        }
			        $this->options[$key] = $value;
                    break;

			    case 'image':
			        $this->options[$key] = $this->createImage($value);
			        break;

			    case 'gd resource':
			        $this->options[$key] = $this->isGDSource($value);
			        break;

			    // mixed or string data types
			    default:
			        $this->options[$key] = $value;
                    break;
			}
		}
		return true;
 	}

 	/**
 	 * Creates a GD resource
 	 *
 	 * GD resource creation is possible from a file (supported image types: jpeg,
 	 * gif, png, wbmp, xbm), a string or image resource can be directly
 	 * transmitted to the method.
 	 *
 	 *  @access public
 	 *  @param  mixed    $img filename, string or resource
 	 *  @return resource
 	 */
 	public function createImage($img)
 	{
 		if (is_file($img)) {

 			return $this->createImageFromFile($img);

 		} elseif (is_string($img)) {

 			return $this->createImageFromString($img);

 		} else {
 			if (!$this->isGDSource($img)) {
 				throw new \Exception('Invalid image source!');
 			}

 			return $img;
 		}
 		throw new \InvalidArgumentException('Could not create an image resource from a given input!');
 	}

 	/**
 	 * Create image resource from a given filename
 	 *
 	 * Method creates image resource from a $filename. Possible image types are jpeg,
 	 * gif, png, wbmp and xbm.
 	 *
 	 * @access protected
 	 * @param  string    $filename filename
 	 * @return resource
 	 */
 	protected function createImageFromFile($filename)
 	{
 		if (is_file($filename) && is_readable($filename)) {
 			list(,, $type) = getImageSize($filename);
 			switch($type) {
 				case IMAGETYPE_JPEG:
 					return imagecreatefromjpeg($filename);
 					break;

 				case IMAGETYPE_GIF:
 					return imagecreatefromgif($filename);
 					break;

 				case IMAGETYPE_PNG:
 					return imagecreatefrompng($filename);
 					break;

 				case IMAGETYPE_WBMP:
 					return imagecreatefromwbmp($filename);
 					break;

 				case IMAGETYPE_XBM:
 					return imagecreatefromxbm($filename);
 					break;

 				default:
 					throw new \InvalidArgumentException('Unsupported file format!');
 					break;
 			} // end switch
 		} // end if
 		throw new \Exception('Unable to access file!');
 	}

 	/**
 	 * Create image resource from image stream
 	 *
 	 * method expects image stream.
 	 *
 	 * @access protected
 	 * @param  string    $data image stream in the string
 	 * @return resource
 	 */
	protected function createImageFromString($data)
	{
		if (!is_string($data) || empty($data)) {
			throw new \DomainException('Invalid data value!');
		}

		$img = imagecreatefromstring($data);

		if (!$img) {
			throw new \InvalidArgumentException('Unable to create image from a given string!');
		}
		return $img;
	}

	/**
	 * Method checks if given variable is GD resource.
	 *
	 * @access protected
	 * @param  mixed     $source gd resource
	 * @return bool
	 */
	protected function isGDSource($source)
	{
		if (is_resource($source)) {
            if (get_resource_type($source) == 'gd') {
                return true;
            }
            return false;
        }
		return false;
	}
 }