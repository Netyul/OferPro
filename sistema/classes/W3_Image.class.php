<?php
/**
 * This class is a workaround for PHP images
 * Consult the documentation: http://leandrovieira.com/projects/php/w3image
 *
 * @category W3invent
 * @package W3_Image
 * @author Leandro Vieira Pinho
 * @copyright Leandro Vieira Pinho
 * @license FREE
 * @link http://leandrovieira.com/projects/php/w3image
 * @version 0.1
 */
class W3_Image {
	
	/**
	 * Image´s path
	 *
	 * @var string
	 */
	public $imagePath = '';
	
	/**
	 * Image´s name, if what name an image should be saved
	 *
	 * @var string
	 */
	protected $_imageName = '';
	
	/**
	 * Constructor
	 *
	 * @param string $imagePath
	 */
	function __construct($imagePath = '')
	{
		$this->imagePath = $imagePath;
	}
	
	/**
	 * Define the image´s path
	 *
	 * @param string $imagePath image´s path
	 */
	public function set_image($imagePath = '')
	{
		if ( !empty($imagePath) ) :
			$this->imagePath = $imagePath;
		endif;
	} 
	
	/**
	 * Dfine the image´s name, used in some method like filter, rotate, ...
	 *
	 * @param string $_imageName image´s name
	 */
	public function set_image_name($_imageName)
	{
		if ( !empty($_imageName) ) :
			$this->_imageName = $_imageName;
		endif;
		return $this;
	}
	
	/**
	 * Get the image´s mime type
	 *
	 * @param string $imagePath image´s path
	 * @return string image´s mime type
	 */
	public function get_mime_type($imagePath = '')
	{
		return $this->_get_image_info($imagePath,'mime');
	}
	
	/**
	 * Get the image´s extension
	 *
	 * @param string $imagePath image´s path
	 * @return string image´s extension
	 */
	public function get_extension($imagePath = '')
	{
		return $this->_get_image_info($imagePath,'extension');
	}
	
	/**
	 * Get the image´s width and height
	 *
	 * @param string $imagePath image´s path
	 * @return array image´s width and height
	 */
	public function get_sizes($imagePath = '')
	{
		return $this->_get_image_info($imagePath,'sizes');
	}

	/**
	 * Get the image´s width
	 *
	 * @param string $imagePath image´s path
	 * @return integer image´s width
	 */
	public function get_sizex($imagePath = '')
	{
		return $this->_get_image_info($imagePath,'sizex');
	}

	/**
	 * Get the image´s height
	 *
	 * @param string $imagePath image´s path
	 * @return integer image´s height
	 */
	public function get_sizey($imagePath = '')
	{
		return $this->_get_image_info($imagePath,'sizey');
	}
	
	/**
	 * Get attributes (width and height) of the image and wrap it in a right way to use in HTML tag
	 *
	 * @param string $imagePath image´s path
	 * @return string image´s attributes: width="xxx" height="yyy"
	 */
	public function get_attr($imagePath = '')
	{
		return $this->_get_image_info($imagePath,'attr');
	}

	/**
	 * Show an especified image in the browser
	 *
	 * @param string $imagePath image´s path
	 */
	public function show($imagePath = '')
	{
		// If the image path was not informed, use the image path defined in constructor
		$imagePath = ( !empty($imagePath) ) ? $imagePath : $this->imagePath;
		$this->_get_image_info($imagePath,'mime');
		header('Content-type: ' . $this->_get_image_info($imagePath,'mime'));
		readfile($imagePath);
		exit();
	}
	
	/**
	 * Force the browser download the especified image
	 * 
	 * @param string $imagePath image´s path
	 */
	public function download($imagePath = '')
	{
		// If the image path was not informed, use the image path defined in constructor
		$imagePath = ( !empty($imagePath) ) ? $imagePath : $this->imagePath;
		header('Content-type: ' . $this->_get_image_info($imagePath,'mime'));
		header('Content-Disposition: attachment; filename="' . $this->_get_image_name($imagePath) . '"');
		header('Content-Transfer-Encoding: binary');
		readfile($imagePath);
		exit();
	}
	
	/**
	 * Save an especified image to a current directory with the same name
	 *
	 * @param string $imagePath image´s path
	 */
	public function save($imagePath = '',$imageNewPath = '')
	{
		// If the image path was not informed, use the image path defined in constructor
		$imagePath = ( !empty($imagePath) ) ? $imagePath : $this->imagePath;
		// If the new image path was not informed, use the directory where the file is running
		$imageNewPath = ( !empty($imageNewPath) ) ? $imageNewPath : getcwd() . '/' . $this->_get_image_name($imagePath);
		return @copy($imagePath,$imageNewPath);
	}
	
	/**
	 * Rename an especified image
	 *
	  * @param string $imagePath image´s path
	 */
	public function rename($imagePath = '',$imageNewPath = '')
	{
		// If the image path was not informed, use the image path defined in constructor
		$imagePath = ( !empty($imagePath) ) ? $imagePath : $this->imagePath;
		return rename($imagePath,$imageNewPath);
	}

	/**
	 * Delete an especified image
	 *
	 * @param string $imagePath image´s path
	 */
	public function delete($imagePath = '')
	{
		// If the image path was not informed, use the image path defined in constructor
		$imagePath = ( !empty($imagePath) ) ? $imagePath : $this->imagePath;
		return @unlink($imagePath);
	}

	/**
	 * Create an image starting from a file or a URL
	 *
	 * If the frist parameter, $imagePath, was not informed, the funcion will get the image´s path defined in the constructor
	 * If the third parameter, $strImageName, was not informed, the image will showed in the browser with a header in agreement with the image´s type
	 *
	 * @param string $imagePath image´s path
	 * @param integer $intWidthMax the max width the image can have
	 * @param integer $intHeightMax the max height the image can have
	 * @param string $strImageName the new path and name of the image
	 * @param integer $intQuality the quality of the image will have. For GIF and JPEG inform a number from 0 to 100; for PNG inform from 0 to 9
	 */
	public function create($imagePath = '',$intWidthMax,$intHeightMax,$strImageName = '',$intQuality = 75)
	{
		// If the image path was not informed, use the image path defined in constructor
		$imagePath = ( !empty($imagePath) ) ? $imagePath : $this->imagePath;
		
		// Get the original image´s size
		$arrImageSizes = $this->get_sizes($imagePath);
		
		// If the width was taller than height, get how many percent it was
		if ( $arrImageSizes[0] > $arrImageSizes[1] ) :
			$intPercent = (100 * $intWidthMax) / $arrImageSizes[0];
		// If the height was taller than width, get how many percent it was
		else :
			$intPercent = (100 * $intHeightMax) / $arrImageSizes[1];
		endif;
		
		// Calcula the new image´s size
		$intNewImageSizeX = $arrImageSizes[0] * ($intPercent / 100);
		$intNewImageSizeY = $arrImageSizes[1] * ($intPercent / 100);
		$resourceImage = imagecreatetruecolor($intNewImageSizeX,$intNewImageSizeY);
		
		// Verify the image´s type and work in agreement with
		switch($this->_get_image_info($imagePath,'extension')) :
			case 'gif' :
				$image = imagecreatefromgif($imagePath);
				imagecopyresampled($resourceImage,$image,0,0,0,0,$intNewImageSizeX,$intNewImageSizeY,$arrImageSizes[0],$arrImageSizes[1]);
				$strImageName = ( !empty($strImageName) ) ? $this->_avoid_extension_different_of_type($strImageName,'gif') : $this->_get_image_name($imagePath);
				return imagegif($resourceImage,$strImageName,$intQuality);
			break;
			case 'jpeg' :
				$image = imagecreatefromjpeg($imagePath);
				imagecopyresampled($resourceImage,$image,0,0,0,0,$intNewImageSizeX,$intNewImageSizeY,$arrImageSizes[0],$arrImageSizes[1]);
				$strImageName = ( !empty($strImageName) ) ? $this->_avoid_extension_different_of_type($strImageName,'jpg') : $this->_get_image_name($imagePath);
				return imagejpeg($resourceImage,$strImageName,$intQuality);
			break;
			case 'png' :
				$image = imagecreatefrompng($imagePath);
				imagecopyresampled($resourceImage,$image,0,0,0,0,$intNewImageSizeX,$intNewImageSizeY,$arrImageSizes[0],$arrImageSizes[1]);
				$strImageName = ( !empty($strImageName) ) ? $this->_avoid_extension_different_of_type($strImageName,'png') : $this->_get_image_name($imagePath);
				return imagepng($resourceImage,$strImageName,$intQuality{0});
			break;
		endswitch;		
	}

	/**
	 * Rotate an image with a given angle
	 *
	 * @param string $imagePath image´s path
	 * @param integer $intDegreess angle number
	 */
	public function rotate($imagePath = '', $intDegrees)
	{
		// If the image path was not informed, use the image path defined in constructor
		$imagePath = ( !empty($imagePath) ) ? $imagePath : $this->imagePath;
		
		// If the method set_image_name wasn´t used to define a image name, get the original image´s name
		if ( empty($this->_imageName) ) :
			$this->_imageName = $this->_get_image_name($imagePath);
		endif;
		
		// Verify the image´s type and work in agreement with
		switch ( $this->_get_image_info($imagePath,'extension' ) ) :
			case 'gif' :
				$sourceImage = imagecreatefromgif($imagePath);
				$imageRotated = imagerotate($sourceImage,$intDegrees,0);
				return imagegif($imageRotated,$this->_imageName);
			break;
			case 'jpeg' :
				$sourceImage = imagecreatefromjpeg($imagePath);
				$imageRotated = imagerotate($sourceImage,$intDegrees,0);
				return imagejpeg($imageRotated,$this->_imageName);
			break;
			case 'png' :
				$sourceImage = imagecreatefrompng($imagePath);
				$imageRotated = imagerotate($sourceImage,$intDegrees,0);
				return imagepng($imageRotated,$this->_imageName);
			break;
		endswitch;
	}

	/**
	 * Apply a filter in an especified image
	 *
	 * @param string $imagePath image´s path
	 * @param string $filterType filter´s name
	 * @param integer $param1 argument one from some filters
	 * @param integer $param2 argument tow from some filters
	 * @param integer $param3 argument three from some filters
	 * @return the image´s source
	 */
	public function filter($imagePath = '', $filterType, $param1 = 0, $param2 = 0, $param3 = 0)
	{
		// If the image path was not informed, use the image path defined in constructor
		$imagePath = ( !empty($imagePath) ) ? $imagePath : $this->imagePath;

		// Verify the image´s extension and work in agreement with
		switch( $this->_get_image_info($imagePath,'extension') ) :
			case 'gif' :
				$imageSource = imagecreatefromgif($imagePath);
				$this->_set_image_filter($imageSource,$filterType,$param1,$param2,$param3);
				return imagegif($imageSource,$this->_imageName);
				imagedestroy($imageSource);
			break;
			case 'jpeg' :
				$imageSource = imagecreatefromjpeg($imagePath);
				$this->_set_image_filter($imageSource,$filterType,$param1,$param2,$param3);
				return imagejpeg($imageSource,$this->_imageName);
				imagedestroy($imageSource);
			break;
			case 'png' :
				$imageSource = imagecreatefrompng($imagePath);
				$this->_set_image_filter($imageSource,$filterType,$param1,$param2,$param3);
				return imagepng($imageSource,$this->_imageName);
				imagedestroy($imageSource);
			break;
		endswitch;
	}

	/**
	 * Define the filter type, apply the parameters and filter in the image
	 *
	 * @param string $imagePath image´s path
	 * @param string $filterType filter´s name
	 * @param integer $param1 argument one from some filters
	 * @param integer $param2 argument tow from some filters
	 * @param integer $param3 argument three from some filters
	 * @return the image´s source with filter applyed
	 */
	protected function _set_image_filter($imageSource,$filterType,$param1,$param2,$param3)
	{
		// Array with the available filters
		$arrFilters = array (
			'negate'		=> IMG_FILTER_NEGATE,
			'grayscale'		=> IMG_FILTER_GRAYSCALE,
			'brightness'	=> IMG_FILTER_BRIGHTNESS,
			'contrast'		=> IMG_FILTER_CONTRAST,
			'colorize'		=> IMG_FILTER_COLORIZE,
			'edgedetect'	=> IMG_FILTER_EDGEDETECT,
			'emboss'		=> IMG_FILTER_EMBOSS,
			'gaussianblur'	=> IMG_FILTER_GAUSSIAN_BLUR,
			'selectiveblur'	=> IMG_FILTER_SELECTIVE_BLUR,
			'meanremoval'	=> IMG_FILTER_MEAN_REMOVAL,
			'smooth'		=> IMG_FILTER_SMOOTH
		);
		// Verify if the filter needs more than two parameters
		switch ( $filterType ) :
			// These effects no need parameters
			case 'negate' :
			case 'grayscale' :
			case 'edgedetect' :
			case 'emboss' :
			case 'gaussianblur' :
			case 'selectiveblur' :
			case 'meanremoval' :
				return imagefilter($imageSource,$arrFilters[$filterType]);
			break;
			// These effects no need parameters
			case 'brightness' :
			case 'contrast' :
			case 'smooth' :
				return imagefilter($imageSource,$arrFilters[$filterType],$param1);
			break;
			// This effects needs 3 parameters
			case 'colorize' :
				return imagefilter($imageSource,$arrFilters[$filterType],$param1,$param2,$param3);
			break;
			// This a specific effect - http://www.php.net/manual/en/function.imagefilter.php#73944
			case 'sepia' :
				imagefilter($imageSource,IMG_FILTER_GRAYSCALE);
				return imagefilter($imageSource,IMG_FILTER_COLORIZE,90,60,40);
			break;
		endswitch;
	}

	/**
	 * Get informations about an image
	 *
	 * @param string $imagePath image´s path
	 * @param string $strInfo what info do you want?
	 */
	protected function _get_image_info($imagePath = '',$strInfo)
	{
		// If the image path was not informed, use the image path defined in constructor
		$arrImageInfo = ( !empty($imagePath) ) ? getimagesize($imagePath) : getimagesize($this->imagePath);
		switch($strInfo) :
			// Return an array with width and height of the image
			case 'sizes' :
				return array($arrImageInfo[0], $arrImageInfo[1], 'width' => $arrImageInfo[0], 'height' => $arrImageInfo[1]);
			break;
			// Return the width of the image
			case 'sizex' :
				return $arrImageInfo[0];
			break;
			// Return the height of the image
			case 'sizey' :
				return $arrImageInfo[1];
			break;
			// Return image´s attribute: width="xxx" height="yyy"
			case 'attr' :
				return $arrImageInfo[3];
			break;
			// Return the image´s mime type
			case 'mime' :
				return $arrImageInfo['mime'];
			break;
			// Return the image´s extension
			case 'extension' :
				return end(explode('/',$arrImageInfo['mime']));
			break;
		endswitch;
	}

	/**
	 * Get the image´s name
	 *
	 * @param string $imagePath image´s path
	 */
	protected function _get_image_name($imagePath = '')
	{
		// If the image path was not informed, use the image path defined in constructor
		$imagePath = ( !empty($imagePath) ) ? $imagePath : $this->imagePath;
		// If has TMP extension, means that the file are in local computer and was uploaded
		if ( preg_match('#.tmp#',$imagePath) ) :
			return 'W3_Image.' . substr(md5(date('Y-m-d H:i:s')),0,12) . '.' . $this->_get_image_info($imagePath,'extension');
		// Instedad, the file are somewhere (http:// or in local directory)
		else :
			return end(explode('/',$imagePath));
		endif;
	}

	/**
	 * Avoid the image´s name has a differente extension of your type
	 * Some images needs your type to maintain certain features. Like, gif animator, PNG alpha transparency.
	 *
	 * @param string $strImageName the image´s name
	 * @param string $strImageType the image´s type
	 */
	protected function _avoid_extension_different_of_type($strImageName,$strImageType)
	{
		if ( !empty($strImageName) and !empty($strImageType) ) :
			// Original type
			$_strImageType = end(explode('.',$strImageName));
			$arrImageName = explode($_strImageType,$strImageName);
			// Check the original image´s type with informed image´s type
			if ( $_strImageType == $strImageType ) :
				return $strImageName;
			else :
				return $arrImageName[0] . $strImageType;
			endif;
		endif;
	}
	
	/**
	 * Lista de funções para um futuro que só Deus sabe quando
	 * - crop
	 * - watermarking
	 * - write
	 * - draw
	 * - log de erros
	 * verificar perfomance
	 * verificar GD e funções
	 */
}
?>