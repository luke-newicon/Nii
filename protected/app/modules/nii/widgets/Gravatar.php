<?php
/**
 * @package Yii Framework < http://yiiframework.com >
 * @subpackage Widgets
 * @author Vadim Gabriel , http://vadimg.com/ < vadimg88@gmail.com >
 * @copyright
 *
 *
 * Usage:
 * ---------------
 * Inside your view file just paste the following code:
 *
 * $this->widget('nii.Gravatar.', array(
 *		// email to display the gravatar belonging to it
 *		'email' => 'myemail@mydomain.com',
 *
 *		// if the email provided above is already md5 hashed then set this property to true, defaults to false
 *		'hashed' => false,
 *
 *		// if an email is not associated with a gravatar this image will be displayed,
 *		// by default this is omitted so the Blue Gravatar icon will be displayed you can also set this to
 *		// "identicon" "monsterid" and "wavatar" which are default gravatar icons
 *		'default' => 'http://www.mysite.com/default_gravatar_image.jpg',
 *
 *		// the gravatar icon size in px defaults to 40
 *		'size' => 50,
 *
 *		// the Gravatar ratings, Can be G, PG, R, X, Defaults to G
 *		'rating' => 'PG',
 *
 *		// Html options that will be appended to the image tag
 * 		'htmlOptions' => array( 'alt' => 'Gravatar Icon' ),
 * ));
 *
 * @property string  $email        email to display the gravatar belonging to it
 * @property boolean $hashed       if the email provided above is already md5 hashed then set this property to true, defaults to false
 * @property string  $default      default image if no image found defaults to "mm" also can be set to: "identicon" "monsterid" and "wavatar"
 *								   http://www.mysite.com/default_gravatar_image.jpg
 * @property int     $size         the gravatar icon size in px defaults to 40
 * @property string  $rating       the Gravatar ratings, Can be G, PG, R, X, Defaults to G
 * @property array   $htmlOptions  Html options that will be appended to the image tag
 *
 *
 */
class Gravatar extends CWidget
{
	/**
	 * @var string - Email we will use to generate the Gravatar Image
	 */
	public $email = '';

	/**
	 * @var boolean - set this to true if the email is already md5 hashed
	 */
	public $hashed = false;

	/**
	 * @var string - Enter the default image displayed if the
	 * Email provided to display the Gravatar does not have one.
	 * There are "special" values that you may pass to this parameter which produce dynamic default images.
	 * These are "identicon" "monsterid" and "wavatar".
	 * If omitted we will serve up our default image, the blue G.
	 * A new parameter, 404, has been added to allow the return of an HTTP 404 error instead of any
	 * image or redirect if an image cannot be found for the specified email address.
	 *
	 */
	public $default = 'mm';

	/**
	 * @var int - Gravatar Size in px, Defaults to 40px
	 */
	public $size = 40;

	/**
	 * @var string - the Gravatar default rating
	 * Can be G, PG, R, X
	 *
	 * G rated gravatar is suitable for display on all websites with any audience type.
 	 *
	 * PG rated gravatars may contain rude gestures, provocatively dressed individuals, the lesser swear words, or mild violence.
	 *
	 * R rated gravatars may contain such things as harsh profanity, intense violence, nudity, or hard drug use.
	 *
	 * X rated gravatars may contain hardcore sexual imagery or extremely disturbing violence.
	 *
	 */
	public $rating = 'G';

	/**
	 * @var array - any HTML options that will be passed to the IMG tag
	 */
	public $htmlOptions = array();

	/**
	 * Gravatar Url
	 */
	const GRAVATAR_URL = 'http://www.gravatar.com/avatar/';

	/**
	 * @var string - the final constructed URL
	 */
	protected $url = '';

	/**
	 * @var array - url params
	 */
	protected $params = array();

	/**
	 * Widget Constructor
	 */
	public function init()
	{
		// Email
		$this->url .= $this->hashed ? strtolower( $this->email ) . '?' : md5( strtolower( $this->email ) ) . '?';

		// Size
		$this->params['s'] = (int) $this->size;

		// Rating
		$this->params['r'] = $this->rating;

		// Default
		if( $this->default != '' )
		{
			$this->params['d'] = $this->default;
		}

		if(!array_key_exists('alt', $this->htmlOptions)){
			$this->htmlOptions['alt'] = '';
		}

		$array = array();
		foreach( $this->params as $key => $value )
		{
			$array[] = $key . '=' . $value;
		}

		$this->url .= implode('&', $array);
	}

	/**
	 * Run Widget and display
	 */
	public function run()
	{
		echo CHtml::image($this->getUrl(), $this->htmlOptions['alt'], $this->htmlOptions);
	}
	
	public function getUrl(){
		return self::GRAVATAR_URL . $this->url;
	}

}