<?php



$config = array();

/*
|--------------------------------------------------------------------------
| REST Format
|--------------------------------------------------------------------------
|
| What format should the data be returned in by default?
|
|	Default: xml
|
*/
$config['rest_default_format'] = 'xml';

/*
|--------------------------------------------------------------------------
| Enable emulate request
|--------------------------------------------------------------------------
|
| Should we enable emulation of the request (e.g. used in Mootools request)?
|
|	Default: false
|
*/
$config['enable_emulate_request'] = TRUE;


/*
|--------------------------------------------------------------------------
| REST Realm
|--------------------------------------------------------------------------
|
| Name for the password protected REST API displayed on login dialogs
|
|	E.g: My Secret REST API
|
*/
$config['rest_realm'] = 'REST API';

/*
|--------------------------------------------------------------------------
| REST Login
|--------------------------------------------------------------------------
|
| Is login required and if so, which type of login?
|
|	'' = no login required, 'basic' = unsecure login, 'digest' = more secure login
|
*/
$config['rest_auth'] = false;

/*
|--------------------------------------------------------------------------
| Override auth types for specific class/method
|--------------------------------------------------------------------------
|
| Set specific authentication types for methods within a class (controller)
|
| Set as many config entries as needed.  Any methods not set will use the default 'rest_auth' config value.
|
| example:  
| 
|			$config['auth_override_class_method']['deals']['view'] = 'none';
|			$config['auth_override_class_method']['deals']['insert'] = 'digest';
|			$config['auth_override_class_method']['accounts']['user'] = 'basic'; 
|
| Here 'deals' and 'accounts' are controller names, 'view', 'insert' and 'user' are methods within. (NOTE: leave off the '_get' or '_post' from the end of the method name)
| Acceptable values are; 'none', 'digest' and 'basic'.  
|
*/
// $config['auth_override_class_method']['deals']['view'] = 'none';
// $config['auth_override_class_method']['deals']['insert'] = 'digest';
// $config['auth_override_class_method']['accounts']['user'] = 'basic';

/*
|--------------------------------------------------------------------------
| REST Login usernames
|--------------------------------------------------------------------------
|
| Array of usernames and passwords for login
|
|	array('admin' => '1234')
|
*/
$config['rest_valid_logins'] = array('admin' => '1234');

/*
|--------------------------------------------------------------------------
| REST Database Group
|--------------------------------------------------------------------------
|
| Connect to a database group for keys, logging, etc. It will only connect
| if you have any of these features enabled.
|
|	'default'
|
*/
$config['rest_database_group'] = 'default';

/*
|--------------------------------------------------------------------------
| REST API Keys Table Name
|--------------------------------------------------------------------------
|
| The table name in your database that stores API Keys.
|
|	'keys'
|
*/
$config['rest_keys_table'] = 'keys';

/*
|--------------------------------------------------------------------------
| REST Enable Keys
|--------------------------------------------------------------------------
|
| When set to true REST_Controller will look for a key and match it to the DB.
| If no key is provided, the request will return an error.
|
|	FALSE

	CREATE TABLE `keys` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `key` varchar(40) NOT NULL,
	  `level` int(2) NOT NULL,
	  `ignore_limits` tinyint(1) NOT NULL DEFAULT '0',
	  `date_created` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
|
*/
$config['rest_enable_keys'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST Key Length
|--------------------------------------------------------------------------
|
| How long should created keys be? Double check this in your db schema.
|
|	Default: 32
|	Max: 40
|
*/
$config['rest_key_length'] = 40;

/*
|--------------------------------------------------------------------------
| REST API Key Variable
|--------------------------------------------------------------------------
|
| Which variable will provide us the API Key
|
| Default: X-API-KEY
|
*/
$config['rest_key_name'] = 'X-API-KEY';

/*
|--------------------------------------------------------------------------
| REST API Logs Table Name
|--------------------------------------------------------------------------
|
| The table name in your database that stores logs.
|
|	'logs'
|
*/
$config['rest_logs_table'] = 'logs';

/*
|--------------------------------------------------------------------------
| REST Enable Logging
|--------------------------------------------------------------------------
|
| When set to true REST_Controller will log actions based on key, date,
| time and IP address. This is a general rule that can be overridden in the
| $this->method array in each controller.
|
|	FALSE
|
	CREATE TABLE `logs` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uri` varchar(255) NOT NULL,
	  `method` varchar(6) NOT NULL,
	  `params` text NOT NULL,
	  `api_key` varchar(40) NOT NULL,
	  `ip_address` varchar(15) NOT NULL,
	  `time` int(11) NOT NULL,
	  `authorized` tinyint(1) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
|
*/
$config['rest_enable_logging'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST API Limits Table Name
|--------------------------------------------------------------------------
|
| The table name in your database that stores limits.
|
|	'logs'
|
*/
$config['rest_limits_table'] = 'limits';

/*
|--------------------------------------------------------------------------
| REST Enable Limits
|--------------------------------------------------------------------------
|
| When set to true REST_Controller will count the number of uses of each method
| by an API key each hour. This is a general rule that can be overridden in the
| $this->method array in each controller.
|
|	FALSE
|
	CREATE TABLE `limits` (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uri` varchar(255) NOT NULL,
	  `count` int(10) NOT NULL,
	  `hour_started` int(11) NOT NULL,
	  `api_key` varchar(40) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=MyISAM DEFAULT CHARSET=utf8;
|
*/
$config['rest_enable_limits'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST Ignore HTTP Accept
|--------------------------------------------------------------------------
|
| Set to TRUE to ignore the HTTP Accept and speed up each request a little.
| Only do this if you are using the $this->rest_format or /format/xml in URLs
|
|	FALSE
|
*/
$config['rest_ignore_http_accept'] = FALSE;

/*
|--------------------------------------------------------------------------
| REST AJAX Only
|--------------------------------------------------------------------------
|
| Set to TRUE to only allow AJAX requests. If TRUE and the request is not 
| coming from AJAX, a 505 response with the error message "Only AJAX 
| requests are accepted." will be returned. This is good for production 
| environments. Set to FALSE to also accept HTTP requests. 
|
|	FALSE
|
*/
$config['rest_ajax_only'] = FALSE;

/* End of file config.php */
/* Location: ./system/application/config/rest.php */


/**
 * This is a controller to serve rest requests
 */
Class RestController extends AController
{
	
	
	
	
	
	public function createAction($actionID){
		
		// overrides default action to provide a model (resource) specific action implementation
		if(isset($_REQUEST['model'])){
			$model = $_REQUEST['model'];
			$overideActionID = $model.'_'.$actionID;
			if(method_exists($this, 'action'.$overideActionID)){
				return new CInlineAction($this,$overideActionID);
			}
		}
		
		return parent::createAction($actionID);
	}
	
	
	
	


	
}


class REST_Controller extends NController {

	protected $rest_format = NULL; // Set this in a controller to use a default format
	protected $methods = array(); // contains a list of method properties such as limit, log and level
	protected $request = NULL; // Stores accept, language, body, headers, etc
	protected $response = NULL; // What is gonna happen in output?
	protected $rest = NULL; // Stores DB, keys, key level, etc
	protected $_get_args = array();
	protected $_post_args = array();
	protected $_put_args = array();
	protected $_delete_args = array();
	protected $_args = array();
	protected $_allow = TRUE;

	// List all supported methods, the first will be the default format
	protected $_supported_formats = array(
		'xml' => 'application/xml',
		'rawxml' => 'application/xml',
		'json' => 'application/json',
		'jsonp' => 'application/javascript',
		'serialize' => 'application/vnd.php.serialized',
		'php' => 'text/plain',
		'html' => 'text/html',
		'csv' => 'application/csv'
	);

	// Constructor function
	public function __construct()
	{
		parent::__construct();

		// Lets grab the config and get ready to party
		$this->load->config('rest');

		// How is this request being made? POST, DELETE, GET, PUT?
		$this->request->method = $this->_detect_method();

		// Set up our GET variables
		$this->_get_args = array_merge($this->_get_args, $this->uri->ruri_to_assoc());

		$this->load->library('security');

		// This library is bundled with REST_Controller 2.5+, but will eventually be part of CodeIgniter itself
		$this->load->library('format');

		// Try to find a format for the request (means we have a request body)
		$this->request->format = $this->_detect_input_format();

		// Some Methods cant have a body
		$this->request->body = NULL;

		switch ($this->request->method)
		{
			case 'get':
				// Grab proper GET variables
				parse_str(parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY), $get);

				// If there are any, populate $this->_get_args
				empty($get) OR $this->_get_args = $get;
				break;

			case 'post':
				$this->_post_args = $_POST;

				$this->request->format and $this->request->body = file_get_contents('php://input');
				break;

			case 'put':
				// It might be a HTTP body
				if ($this->request->format)
				{
					$this->request->body = file_get_contents('php://input');
				}

				// If no file type is provided, this is probably just arguments
				else
				{
					parse_str(file_get_contents('php://input'), $this->_put_args);
				}

				break;

			case 'delete':
				// Set up out DELETE variables (which shouldn't really exist, but sssh!)
				parse_str(file_get_contents('php://input'), $this->_delete_args);
				break;
		}

		// Now we know all about our request, let's try and parse the body if it exists
		if ($this->request->format and $this->request->body)
		{
			$this->request->body = $this->format->factory($this->request->body, $this->request->format)->to_array();
		}

		// Merge both for one mega-args variable
		$this->_args = array_merge($this->_get_args, $this->_put_args, $this->_post_args, $this->_delete_args);

		// Which format should the data be returned in?
		$this->response->format = $this->_detect_output_format();

		// Which format should the data be returned in?
		$this->response->lang = $this->_detect_lang();

		// Check if there is a specific auth type for the current class/method
		$this->auth_override = $this->_auth_override_check();

		// When there is no specific override for the current class/method, use the default auth value set in the config
		if ( $this->auth_override !== TRUE )
		{
			if ($this->config->item('rest_auth') == 'basic')
			{
				$this->_prepare_basic_auth();
			}
			elseif ($this->config->item('rest_auth') == 'digest')
			{
				$this->_prepare_digest_auth();
			}
		}

		// Load DB if its enabled
		if (config_item('rest_database_group') AND (config_item('rest_enable_keys') OR config_item('rest_enable_logging')))
		{
			$this->rest->db = $this->load->database(config_item('rest_database_group'), TRUE);
		}

		// Checking for keys? GET TO WORK!
		if (config_item('rest_enable_keys'))
		{
			$this->_allow = $this->_detect_api_key();
		}

		// only allow ajax requests
		if ( ! $this->input->is_ajax_request() AND config_item('rest_ajax_only') )
		{
			$this->response( array('status' => false, 'error' => 'Only AJAX requests are accepted.'), 505 );
		}
	}

	/*
	 * Remap
	 *
	 * Requests are not made to methods directly The request will be for an "object".
	 * this simply maps the object and method to the correct Controller method.
	 */
	public function _remap($object_called, $arguments)
	{
		$pattern = '/^(.*)\.(' . implode('|', array_keys($this->_supported_formats)) . ')$/';
		if (preg_match($pattern, $object_called, $matches))
		{
			$object_called = $matches[1];
		}

		$controller_method = $object_called . '_' . $this->request->method;

		// Do we want to log this method (if allowed by config)?
		$log_method = ! (isset($this->methods[$controller_method]['log']) AND $this->methods[$controller_method]['log'] == FALSE);

		// Use keys for this method?
		$use_key = ! (isset($this->methods[$controller_method]['key']) AND $this->methods[$controller_method]['key'] == FALSE);

		// Get that useless shitty key out of here
		if (config_item('rest_enable_keys') AND $use_key AND $this->_allow === FALSE)
		{
			$this->response(array('status' => false, 'error' => 'Invalid API Key.'), 403);
		}

		// Sure it exists, but can they do anything with it?
		if ( ! method_exists($this, $controller_method))
		{
			$this->response(array('status' => false, 'error' => 'Unknown method.'), 404);
		}

		// Doing key related stuff? Can only do it if they have a key right?
		if (config_item('rest_enable_keys') AND ! empty($this->rest->key))
		{
			// Check the limit
			if (config_item('rest_enable_limits') AND ! $this->_check_limit($controller_method))
			{
				$this->response(array('status' => false, 'error' => 'This API key has reached the hourly limit for this method.'), 401);
			}

			// If no level is set use 0, they probably aren't using permissions
			$level = isset($this->methods[$controller_method]['level']) ? $this->methods[$controller_method]['level'] : 0;

			// If no level is set, or it is lower than/equal to the key's level
			$authorized = $level <= $this->rest->level;

			// IM TELLIN!
			if (config_item('rest_enable_logging') AND $log_method)
			{
				$this->_log_request($authorized);
			}

			// They don't have good enough perms
			$authorized OR $this->response(array('status' => false, 'error' => 'This API key does not have enough permissions.'), 401);
		}

		// No key stuff, but record that stuff is happening
		else if (config_item('rest_enable_logging') AND $log_method)
		{
			$this->_log_request($authorized = TRUE);
		}

		// And...... GO!
		call_user_func_array(array($this, $controller_method), $arguments);
	}

	/*
	 * response
	 *
	 * Takes pure data and optionally a status code, then creates the response
	 */
	public function response($data = array(), $http_code = null)
	{
		// If data is empty and not code provide, error and bail
		if (empty($data) && $http_code === null)
    	{
    		$http_code = 404;
    	}

		// Otherwise (if no data but 200 provided) or some data, carry on camping!
		else
		{
			is_numeric($http_code) OR $http_code = 200;

			// If the format method exists, call and return the output in that format
			if (method_exists($this, '_format_'.$this->response->format))
			{
				// Set the correct format header
				header('Content-Type: '.$this->_supported_formats[$this->response->format]);

				$output = $this->{'_format_'.$this->response->format}($data);
			}

			// If the format method exists, call and return the output in that format
			elseif (method_exists($this->format, 'to_'.$this->response->format))
			{
				// Set the correct format header
				header('Content-Type: '.$this->_supported_formats[$this->response->format]);

				$output = $this->format->factory($data)->{'to_'.$this->response->format}();
			}

			// Format not supported, output directly
			else
			{
				$output = $data;
			}
		}

		header('HTTP/1.1: ' . $http_code);
		header('Status: ' . $http_code);
		header('Content-Length: ' . strlen($output));

		exit($output);
	}

	/*
	 * Detect input format
	 *
	 * Detect which format the HTTP Body is provided in
	 */
	protected function _detect_input_format()
	{
		if ($this->input->server('CONTENT_TYPE'))
		{
			// Check all formats against the HTTP_ACCEPT header
			foreach ($this->_supported_formats as $format => $mime)
			{
				if (strpos($match = $this->input->server('CONTENT_TYPE'), ';'))
				{
					$match = current(explode(';', $match));
				}

				if ($match == $mime)
				{
					return $format;
				}
			}
		}

		return NULL;
	}

	/*
	 * Detect format
	 *
	 * Detect which format should be used to output the data
	 */
	protected function _detect_output_format()
	{
		$pattern = '/\.(' . implode('|', array_keys($this->_supported_formats)) . ')$/';

		// Check if a file extension is used
		if (preg_match($pattern, $this->uri->uri_string(), $matches))
		{
			return $matches[1];
		}

		// Check if a file extension is used
		elseif ($this->_get_args AND ! is_array(end($this->_get_args)) AND preg_match($pattern, end($this->_get_args), $matches))
		{
			// The key of the last argument
			$last_key = end(array_keys($this->_get_args));

			// Remove the extension from arguments too
			$this->_get_args[$last_key] = preg_replace($pattern, '', $this->_get_args[$last_key]);
			$this->_args[$last_key] = preg_replace($pattern, '', $this->_args[$last_key]);

			return $matches[1];
		}

		// A format has been passed as an argument in the URL and it is supported
		if (isset($this->_get_args['format']) AND array_key_exists($this->_get_args['format'], $this->_supported_formats))
		{
			return $this->_get_args['format'];
		}

		// Otherwise, check the HTTP_ACCEPT (if it exists and we are allowed)
		if ($this->config->item('rest_ignore_http_accept') === FALSE AND $this->input->server('HTTP_ACCEPT'))
		{
			// Check all formats against the HTTP_ACCEPT header
			foreach (array_keys($this->_supported_formats) as $format)
			{
				// Has this format been requested?
				if (strpos($this->input->server('HTTP_ACCEPT'), $format) !== FALSE)
				{
					// If not HTML or XML assume its right and send it on its way
					if ($format != 'html' AND $format != 'xml')
					{

						return $format;
					}

					// HTML or XML have shown up as a match
					else
					{
						// If it is truely HTML, it wont want any XML
						if ($format == 'html' AND strpos($this->input->server('HTTP_ACCEPT'), 'xml') === FALSE)
						{
							return $format;
						}

						// If it is truely XML, it wont want any HTML
						elseif ($format == 'xml' AND strpos($this->input->server('HTTP_ACCEPT'), 'html') === FALSE)
						{
							return $format;
						}
					}
				}
			}
		} // End HTTP_ACCEPT checking

		// Well, none of that has worked! Let's see if the controller has a default
		if ( ! empty($this->rest_format))
		{
			return $this->rest_format;
		}

		// Just use the default format
		return config_item('rest_default_format');
	}

	/*
	 * Detect method
	 *
	 * Detect which method (POST, PUT, GET, DELETE) is being used
	 */
	protected function _detect_method()
	{
		$method = strtolower($this->input->server('REQUEST_METHOD'));

		if ($this->config->item('enable_emulate_request') && $this->input->post('_method'))
		{
			$method =  $this->input->post('_method');
		}

		if (in_array($method, array('get', 'delete', 'post', 'put')))
		{
			return $method;
		}

		return 'get';
	}

	/*
	 * Detect API Key
	 *
	 * See if the user has provided an API key
	 */
	protected function _detect_api_key()
	{
		// Work out the name of the SERVER entry based on config
		$key_name = 'HTTP_' . strtoupper(str_replace('-', '_', config_item('rest_key_name')));

		$this->rest->key = NULL;
		$this->rest->level = NULL;
		$this->rest->ignore_limits = FALSE;

		// Find the key from server or arguments
		if ($key = isset($this->_args['API-Key']) ? $this->_args['API-Key'] : $this->input->server($key_name))
		{
			if ( ! $row = $this->rest->db->where('key', $key)->get(config_item('rest_keys_table'))->row())
			{
				return FALSE;
			}

			$this->rest->key = $row->key;

			isset($row->level) AND $this->rest->level = $row->level;
			isset($row->ignore_limits) AND $this->rest->ignore_limits = $row->ignore_limits;

			return TRUE;
		}

		// No key has been sent
		return FALSE;
	}

	/*
	 * Detect language(s)
	 *
	 * What language do they want it in?
	 */
	protected function _detect_lang()
	{
		if ( ! $lang = $this->input->server('HTTP_ACCEPT_LANGUAGE'))
		{
			return NULL;
		}

		// They might have sent a few, make it an array
		if (strpos($lang, ',') !== FALSE)
		{
			$langs = explode(',', $lang);

			$return_langs = array();
			$i = 1;
			foreach ($langs as $lang)
			{
				// Remove weight and strip space
				list($lang) = explode(';', $lang);
				$return_langs[] = trim($lang);
			}

			return $return_langs;
		}

		// Nope, just return the string
		return $lang;
	}

	/*
	 * Log request
	 *
	 * Record the entry for awesomeness purposes
	 */
	protected function _log_request($authorized = FALSE)
	{
		return $this->rest->db->insert(config_item('rest_logs_table'), array(
			'uri' => $this->uri->uri_string(),
			'method' => $this->request->method,
			'params' => serialize($this->_args),
			'api_key' => isset($this->rest->key) ? $this->rest->key : '',
			'ip_address' => $this->input->ip_address(),
			'time' => function_exists('now') ? now() : time(),
			'authorized' => $authorized
		));
	}

	/*
	 * Log request
	 *
	 * Record the entry for awesomeness purposes
	 */
	protected function _check_limit($controller_method)
	{
		// They are special, or it might not even have a limit
		if (!empty($this->rest->ignore_limits) OR !isset($this->methods[$controller_method]['limit']))
		{
			// On your way sonny-jim.
			return TRUE;
		}

		// How many times can you get to this method an hour?
		$limit = $this->methods[$controller_method]['limit'];

		// Get data on a keys usage
		$result = $this->rest->db
						->where('uri', $this->uri->uri_string())
						->where('api_key', $this->rest->key)
						->get(config_item('rest_limits_table'))
						->row();

		// No calls yet, or been an hour since they called
		if (!$result OR $result->hour_started < time() - (60 * 60))
		{
			// Right, set one up from scratch
			$this->rest->db->insert(config_item('rest_limits_table'), array(
				'uri' => $this->uri->uri_string(),
				'api_key' => isset($this->rest->key) ? $this->rest->key : '',
				'count' => 1,
				'hour_started' => time()
			));
		}

		// They have called within the hour, so lets update
		else
		{
			// Your luck is out, you've called too many times!
			if ($result->count > $limit)
			{
				return FALSE;
			}

			$this->rest->db
					->where('uri', $this->uri->uri_string())
					->where('api_key', $this->rest->key)
					->set('count', 'count + 1', FALSE)
					->update(config_item('rest_limits_table'));
		}

		return TRUE;
	}

	/*
	 * Auth override check
	 *
	 * Check if there is a specific auth type set for the current class/method being called
	 */
	protected function _auth_override_check()
	{

		// Assign the class/method auth type override array from the config
		$this->overrides_array = $this->config->item('auth_override_class_method');

		// Check to see if the override array is even populated, otherwise return false
		if ( empty($this->overrides_array) )
		{
			return false;
		}

		// Check to see if there's an override value set for the current class/method being called
		if ( empty($this->overrides_array[$this->router->class][$this->router->method]) )
		{
			return false;
		}

		// None auth override found, prepare nothing but send back a true override flag
		if ($this->overrides_array[$this->router->class][$this->router->method] == 'none')
		{
			return true;
		}

		// Basic auth override found, prepare basic
		if ($this->overrides_array[$this->router->class][$this->router->method] == 'basic')
		{
			$this->_prepare_basic_auth();
			return true;
		}

		// Digest auth override found, prepare digest
		if ($this->overrides_array[$this->router->class][$this->router->method] == 'digest')
		{
			$this->_prepare_digest_auth();
			return true;
		}

		// Return false when there is an override value set but it doesn't match 'basic', 'digest', or 'none'.  (the value was misspelled)
		return false;
	}


	// INPUT FUNCTION --------------------------------------------------------------

	public function get($key = NULL, $xss_clean = TRUE)
	{
		if ($key === NULL)
		{
			return $this->_get_args;
		}

		return array_key_exists($key, $this->_get_args) ? $this->_xss_clean($this->_get_args[$key], $xss_clean) : FALSE;
	}

	public function post($key = NULL, $xss_clean = TRUE)
	{
		if ($key === NULL)
		{
			return $this->_post_args;
		}

		return $this->input->post($key, $xss_clean);
	}

	public function put($key = NULL, $xss_clean = TRUE)
	{
		if ($key === NULL)
		{
			return $this->_put_args;
		}

		return array_key_exists($key, $this->_put_args) ? $this->_xss_clean($this->_put_args[$key], $xss_clean) : FALSE;
	}

	public function delete($key = NULL, $xss_clean = TRUE)
	{
		if ($key === NULL)
		{
			return $this->_delete_args;
		}

		return array_key_exists($key, $this->_delete_args) ? $this->_xss_clean($this->_delete_args[$key], $xss_clean) : FALSE;
	}

	protected function _xss_clean($val, $bool)
	{
		if (CI_VERSION < 2)
		{
			return $bool ? $this->input->xss_clean($val) : $val;
		}
		else
		{
			return $bool ? $this->security->xss_clean($val) : $val;
		}
	}

	public function validation_errors()
	{
		$string = strip_tags($this->form_validation->error_string());

		return explode("\n", trim($string, "\n"));
	}

	// SECURITY FUNCTIONS ---------------------------------------------------------

	protected function _check_login($username = '', $password = NULL)
	{
		if (empty($username))
		{
			return FALSE;
		}

		$valid_logins = & $this->config->item('rest_valid_logins');

		if (!array_key_exists($username, $valid_logins))
		{
			return FALSE;
		}

		// If actually NULL (not empty string) then do not check it
		if ($password !== NULL AND $valid_logins[$username] != $password)
		{
			return FALSE;
		}

		return TRUE;
	}

	protected function _prepare_basic_auth()
	{
		$username = NULL;
		$password = NULL;

		// mod_php
		if ($this->input->server('PHP_AUTH_USER'))
		{
			$username = $this->input->server('PHP_AUTH_USER');
			$password = $this->input->server('PHP_AUTH_PW');
		}

		// most other servers
		elseif ($this->input->server('HTTP_AUTHENTICATION'))
		{
			if (strpos(strtolower($this->input->server('HTTP_AUTHENTICATION')), 'basic') === 0)
			{
				list($username, $password) = explode(':', base64_decode(substr($this->input->server('HTTP_AUTHORIZATION'), 6)));
			}
		}

		if (!$this->_check_login($username, $password))
		{
			$this->_force_login();
		}
	}

	protected function _prepare_digest_auth()
	{
		$uniqid = uniqid(""); // Empty argument for backward compatibility
		// We need to test which server authentication variable to use
		// because the PHP ISAPI module in IIS acts different from CGI
		if ($this->input->server('PHP_AUTH_DIGEST'))
		{
			$digest_string = $this->input->server('PHP_AUTH_DIGEST');
		}
		elseif ($this->input->server('HTTP_AUTHORIZATION'))
		{
			$digest_string = $this->input->server('HTTP_AUTHORIZATION');
		}
		else
		{
			$digest_string = "";
		}

		/* The $_SESSION['error_prompted'] variabile is used to ask
		  the password again if none given or if the user enters
		  a wrong auth. informations. */
		if (empty($digest_string))
		{
			$this->_force_login($uniqid);
		}

		// We need to retrieve authentication informations from the $auth_data variable
		preg_match_all('@(username|nonce|uri|nc|cnonce|qop|response)=[\'"]?([^\'",]+)@', $digest_string, $matches);
		$digest = array_combine($matches[1], $matches[2]);

		if (!array_key_exists('username', $digest) OR !$this->_check_login($digest['username']))
		{
			$this->_force_login($uniqid);
		}

		$valid_logins = & $this->config->item('rest_valid_logins');
		$valid_pass = $valid_logins[$digest['username']];

		// This is the valid response expected
		$A1 = md5($digest['username'] . ':' . $this->config->item('rest_realm') . ':' . $valid_pass);
		$A2 = md5(strtoupper($this->request->method) . ':' . $digest['uri']);
		$valid_response = md5($A1 . ':' . $digest['nonce'] . ':' . $digest['nc'] . ':' . $digest['cnonce'] . ':' . $digest['qop'] . ':' . $A2);

		if ($digest['response'] != $valid_response)
		{
			header('HTTP/1.0 401 Unauthorized');
			header('HTTP/1.1 401 Unauthorized');
			exit;
		}
	}

	protected function _force_login($nonce = '')
	{
		if ($this->config->item('rest_auth') == 'basic')
		{
			header('WWW-Authenticate: Basic realm="' . $this->config->item('rest_realm') . '"');
		}
		elseif ($this->config->item('rest_auth') == 'digest')
		{
			header('WWW-Authenticate: Digest realm="' . $this->config->item('rest_realm') . '" qop="auth" nonce="' . $nonce . '" opaque="' . md5($this->config->item('rest_realm')) . '"');
		}

		$this->response(array('status' => false, 'error' => 'Not authorized'), 401);
	}

	// Force it into an array
	protected function _force_loopable($data)
	{
		// Force it to be something useful
		if ( ! is_array($data) AND ! is_object($data))
		{
			$data = (array) $data;
		}

		return $data;
	}

	// FORMATING FUNCTIONS ---------------------------------------------------------

	// Many of these have been moved to the Format class for better separation, but these methods will be checked too

	// Encode as JSONP
	protected function _format_jsonp($data = array())
	{
		return $this->get('callback') . '(' . json_encode($data) . ')';
	}
}



///**
// * Format class
// *
// * Help convert between various formats such as XML, JSON, CSV, etc.
// *
// * @author		Phil Sturgeon
// * @license		http://philsturgeon.co.uk/code/dbad-license
// */
//class Format {
//
//	// Array to convert
//	protected $_data = array();
//
//	// View filename
//	protected $_from_type = null;
//
//	/**
//	 * Returns an instance of the Format object.
//	 *
//	 *     echo $this->format->factory(array('foo' => 'bar'))->to_xml();
//	 *
//	 * @param   mixed  general date to be converted
//	 * @param   string  data format the file was provided in
//	 * @return  Factory
//	 */
//	public function factory($data, $from_type = null)
//	{
//		// Stupid stuff to emulate the "new static()" stuff in this libraries PHP 5.3 equivilent
//		$class = __CLASS__;
//		return new $class($data, $from_type);
//	}
//
//	/**
//	 * Do not use this directly, call factory()
//	 */
//	public function __construct($data = null, $from_type = null)
//	{
//		get_instance()->load->helper('inflector');
//
//		// If the provided data is already formatted we should probably convert it to an array
//		if ($from_type !== null)
//		{
//			if (method_exists($this, '_from_' . $from_type))
//			{
//				$data = call_user_func(array($this, '_from_' . $from_type), $data);
//			}
//
//			else
//			{
//				throw new Exception('Format class does not support conversion from "' . $from_type . '".');
//			}
//		}
//
//		$this->_data = $data;
//	}
//
//	// FORMATING OUTPUT ---------------------------------------------------------
//
//	public function to_array($data = null)
//	{
//		// If not just null, but nopthing is provided
//		if ($data === null and ! func_num_args())
//		{
//			$data = $this->_data;
//		}
//
//		$array = array();
//
//		foreach ((array) $data as $key => $value)
//		{
//			if (is_object($value) or is_array($value))
//			{
//				$array[$key] = $this->to_array($value);
//			}
//
//			else
//			{
//				$array[$key] = $value;
//			}
//		}
//
//		return $array;
//	}
//
//	// Format XML for output
//	public function to_xml($data = null, $structure = null, $basenode = 'xml')
//	{
//		if ($data === null and ! func_num_args())
//		{
//			$data = $this->_data;
//		}
//
//		// turn off compatibility mode as simple xml throws a wobbly if you don't.
//		if (ini_get('zend.ze1_compatibility_mode') == 1)
//		{
//			ini_set('zend.ze1_compatibility_mode', 0);
//		}
//
//		if ($structure === null)
//		{
//			$structure = simplexml_load_string("<?xml version='1.0' encoding='utf-8'?___><$basenode />");
//		}
//
//		// Force it to be something useful
//		if ( ! is_array($data) AND ! is_object($data))
//		{
//			$data = (array) $data;
//		}
//
//		foreach ($data as $key => $value)
//		{
//			// no numeric keys in our xml please!
//			if (is_numeric($key))
//            {
//                // make string key...           
//                $key = (singular($basenode) != $basenode) ? singular($basenode) : 'item';
//            }
//
//			// replace anything not alpha numeric
//			$key = preg_replace('/[^a-z_\-0-9]/i', '', $key);
//
//            // if there is another array found recrusively call this function
//            if (is_array($value) || is_object($value))
//            {
//                $node = $structure->addChild($key);
//
//                // recrusive call.
//                $this->to_xml($value, $node, $key);
//            }
//
//            else
//            {
//                // add single node.
//				$value = htmlspecialchars(html_entity_decode($value, ENT_QUOTES, 'UTF-8'), ENT_QUOTES, "UTF-8");
//
//				$structure->addChild($key, $value);
//			}
//		}
//
//		return $structure->asXML();
//	}
//
//	// Format HTML for output
//	public function to_html()
//	{
//		$data = $this->_data;
//
//		// Multi-dimentional array
//		if (isset($data[0]))
//		{
//			$headings = array_keys($data[0]);
//		}
//
//		// Single array
//		else
//		{
//			$headings = array_keys($data);
//			$data = array($data);
//		}
//
//		$ci = get_instance();
//		$ci->load->library('table');
//
//		$ci->table->set_heading($headings);
//
//		foreach ($data as &$row)
//		{
//			$ci->table->add_row($row);
//		}
//
//		return $ci->table->generate();
//	}
//
//	// Format HTML for output
//	public function to_csv()
//	{
//		$data = $this->_data;
//
//		// Multi-dimentional array
//		if (isset($data[0]))
//		{
//			$headings = array_keys($data[0]);
//		}
//
//		// Single array
//		else
//		{
//			$headings = array_keys($data);
//			$data = array($data);
//		}
//
//		$output = implode(',', $headings).PHP_EOL;
//		foreach ($data as &$row)
//		{
//			$output .= '"'.implode('","', $row).'"'.PHP_EOL;
//		}
//
//		return $output;
//	}
//
//	// Encode as JSON
//	public function to_json()
//	{
//		return json_encode($this->_data);
//	}
//
//	// Encode as Serialized array
//	public function to_serialized()
//	{
//		return serialize($this->_data);
//	}
//
//	// Output as a string representing the PHP structure
//	public function to_php()
//	{
//	    return var_export($this->_data, TRUE);
//	}
//
//	// Format XML for output
//	protected function _from_xml($string)
//	{
//		return $string ? (array) simplexml_load_string($string, 'SimpleXMLElement', LIBXML_NOCDATA) : array();
//	}
//
//	// Format HTML for output
//	// This function is DODGY! Not perfect CSV support but works with my REST_Controller
//	protected function _from_csv($string)
//	{
//		$data = array();
//
//		// Splits
//		$rows = explode("\n", trim($string));
//		$headings = explode(',', array_shift($rows));
//		foreach ($rows as $row)
//		{
//			// The substr removes " from start and end
//			$data_fields = explode('","', trim(substr($row, 1, -1)));
//
//			if (count($data_fields) == count($headings))
//			{
//				$data[] = array_combine($headings, $data_fields);
//			}
//		}
//
//		return $data;
//	}
//
//	// Encode as JSON
//	private function _from_json($string)
//	{
//		return json_decode(trim($string));
//	}
//
//	// Encode as Serialized array
//	private function _from_serialize($string)
//	{
//		return unserialize(trim($string));
//	}
//
//}