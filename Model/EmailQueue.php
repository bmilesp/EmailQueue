<?php
/**
 * Copyright 2010, Cake Development Corporation (http://cakedc.com)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright 2010, Cake Development Corporation (http://cakedc.com)
 * @license MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * EmailQueue model
 *
 */
 
 
class EmailQueue extends EmailQueueAppModel {

	public $useTable = 'email_queue';
/**
 * Behaviors
 *
 * @var array
 * @access public
 */
	public $actsAs = array('Search.Searchable', 'Utils.Serializable' => array('field' => 'template_vars'));

/**
 * List of valid finder method options, supplied as the first parameter to find().
 *
 * @var array
 * @access protected
 */
	public $findMethods = array(
		'edit' => true,
		'index' => true,
	);

	protected $_postPaths = array(
		'index' => array(
			'email'    => '/User/email',
			'username' => '/User/username',
			'template' => '/EmailQueue/template',
		),
	);
	
	public $filterArgs = array(
         array('name' => 'to', 'type' => 'like'),
         array('name' => 'template', 'type'=>'like'),
    );

	/**
	 * string to send to 
	 * $data array list of data to pass to the template. also include ['cakeEmailConfig'] to
	 * override any config vars (see EmailQueue/Config/Config.php)
	 * 
	 * $template string define which template to use eg: EmailQueue.default
	 */

	 public $maxSendTries = 3;
	 
	public function enqueue($to = null, array $data, $template = 'EmailQueue.default', $time = null ) {
		if(empty($time)){
			$time = gmdate('Y-m-d H:i');
		}
		$email = array(
			'to' => $to,
			'template' => $template,
			'send_at' => $time,
			'template_vars' => $data
		);
		$this->create();
		return $this->save($email);
	}

/**
 * Returns a list of queued emails that needs to be sent
 *
 * @param integer $size, number of unset emails to return
 * @return array list of unsent emails
 * @access public
 */
	public function getBatch($size = 10) {
		if($size === null){
			$size = 10;
		}
		$conditions = array(
			'limit' => $size,
			'conditions' => array(
				'EmailQueue.sent' => 0,
				'EmailQueue.send_tries <=' => $this->maxSendTries,
				'EmailQueue.send_at <=' => gmdate('Y-m-d H:i')
			),
			'order' => array('EmailQueue.created' => 'ASC')
		);
		return $this->find('all', $conditions);
	}

/**
 * Marks an email from the queue as sent
 *
 * @param string $id, queued email id
 * @return boolean
 * @access public
 */
	public function success($id) {
		$this->id = $id;
		return $this->saveField('sent', true);
	}

/**
 * Marks an email from the queue as failed, and increments the number of tries
 *
 * @param string $id, queued email id
 * @return boolean
 * @access public
 */
	public function fail($id) {
		$this->id = $id;
		$tries = $this->field('send_tries');
		return $this->saveField('send_tries', $tries + 1);
	}

	public function _findIndex($state, $query, $results = array()) {
		if ($state == 'before') {
			$query['conditions'] = array();

			if (!empty($query['named'])) {
				$fields = array('template','to');
				$paths = array(
					'email'    => 'User.email',
					'username' => 'User.username',
					'template' => $this->alias . '.template',
				);
				foreach ($paths as $key => $value) {
					if (isset($query['named'][$key])) {
						$query['conditions'][$value . ' LIKE'] = '%' . base64_decode($query['named'][$key]) . '%';
					}
				}
				unset($query['named']);
			}
			$query['fields'] = array('id', 'to', 'sent', 'send_at', 'template', 'created', 'template_vars');

			if (isset($query['operation']) && $query['operation'] == 'count') {
				return $this->_findCount($state, $query, $results);
			}
			return $query;
		} else if ($state == 'after') {
			if (isset($query['operation']) && $query['operation'] == 'count') {
				return $this->_findCount($state, $query, $results);
			}
			$paths = array();
			foreach ($results as &$result) {
				if (!in_array($result[$this->alias]['template'], array_keys($paths))) {
					$exists = $this->_checkPath($result);
					$paths[$result[$this->alias]['template']] = $exists;
					$result[$this->alias]['exists'] = $exists;
				} else {
					$result[$this->alias]['exists'] = $paths[$result[$this->alias]['template']];
				}
			}
			return $results;
		}
	}

	public function _checkPath($record) {
		App::import('Utility', 'File');
		$path = implode(DS, array(
			APP . 'Plugin'. DS . 'View'. DS. 'Elements',
			'Emails',
			'html',
			$record[$this->alias]['template'] . '.ctp'
		));
		$File = new File($path);
		return (int) $File->exists();
	}

	public function _findEdit($state, $query, $results = array()) {
		if ($state == 'before') {
			$query['conditions'] = array();
			if (isset($query[0])) {
				$query['conditions'] = array($this->alias . '.id' => $query[0]);
			} else if (isset($query['id'])) {
				$query['conditions'] = array($this->alias . '.id' => $query['id']);
			}
			$query['fields'] = array('template_vars', 'template');
			$query['contain'] = false;
			return $query;
		} else if ($state == 'after') {
			if (empty($results) || count($results) != 1) {
				return array(false, false);
			}
			$results[0][$this->alias]['template_vars'] = json_encode($results[0][$this->alias]['template_vars']);
			
			$path =$this->parseTemplatePath($results[0][$this->alias]['template']);
			return array($results[0], $path);
		}
	}

/**
 * Caches a string to a a temporary email template
 * Decodes the data from json input
 *
 * @param array $data Data array containing template and view variables (as json)
 * @return array Array where the first index is the filename and the second is the decoded variables
 * @access public
 */
	public function template($id = null, $data) {
		if ($id) {
			$record = $this->find('first', array(
				'conditions' => array($this->alias . '.id' => $id)
			));
			if (!$record) return array(false, false);

			App::import('Utility', 'File');
			$templatePath = $this->parseTemplatePath($record[$this->alias]['template']);
			$File = new File($templatePath);

			$data[$this->alias] = array(
				'template' => $File->read(),
				'vars' => json_encode($record[$this->alias]['template_vars']),
			);
		}

		if (empty($data[$this->alias]))
			throw new Exception('Missing all tempate data');

		$data = array_merge(array(
			'template' => false,
			'vars' => false,
		), $data[$this->alias]);

		if (!$data['template'])
			throw new Exception("Missing template or template data");
		if (!$data['vars'])
			throw new Exception("Missing template variables");

		if (!class_exists('File')) App::import('Utility', 'File');

		$filename = array(
			TMP . 'cache',
			'views',
			'email-' . Inflector::slug(microtime(), '-') . '.ctp'
		);
		$file = new File(implode(DS, $filename));
		if (!$file->create())
			throw new Exception("Unable to create template file on disk");
		if (!$file->write($data['template']))
			throw new Exception("Unable to write template file to disk");
		if (!$file->close())
			throw new Exception("Unable to close template file on disk");

		return array(implode(DS, $filename), json_decode($data['vars'], true));
	}

/**
 * Recursively turns json_decoded objects into arrays
 *
 * @param mixed $data Array or Object to be transformed to array
 * @return array
 * 
 *  * WARNING: This can break your email, this function can create an array containing within it an
 * object AND and array sharing the same key. We've replaced the calling function with json_decode($data, true),
 * passing in true to force all objects to be arrays.
 * 
 *
	function jsonUnwrap($data) {
		$results = (array) $data;
		if (empty($data)) {
			return array();
		}
		foreach ($data as $key => $value) {
			if (is_object($value)) {
				$value = $this->jsonUnwrap($value);
			}
			if (is_array($value)) {
				$value = $this->jsonUnwrap($value);
			}
			$results[$key] = $value;
		}
		return $results;
	}
*/


/**
 * Translates a set of form data to named arguments
 *
 * @param array $data Array of posted data that can be empty
 * @param mixed $fields 
 *				string, points to a $_postPaths index,
 *				array, array of keys pointing to Set::extract paths
 * @return array named arguments
 */
	function dataToNamed($data, $fields = array()) {
		if (empty($data)) {
			return array();
		}

		if (is_string($fields)) {
			if (empty($this->_postPaths[$fields])) {
				return array();
			}

			$fields = $this->_postPaths[$fields];
		}

		$named = array();
		foreach ($fields as $key => $path) {
			$var = Set::extract($path, $data);
			if (isset($var[0])) {
				$named[$key] = base64_encode($var[0]);
			}
		}
		return $named;
	}

/**
 * Translates a set of named arguments to form data
 *
 * @param array $data Array of named data that can be empty
 * @param mixed $fields
 *				string, points to a $_postPaths index 
 *						that must be manged for Set::insert
 *				array, array of keys pointing to Set::insert paths
 * @return array form data
 */
	function namedToData($named, $fields = array()) {
		if (empty($named)) {
			return array();
		}

		if (is_string($fields)) {
			if (empty($this->_postPaths[$fields])) {
				return array();
			}

			$f = array();
			foreach ($this->_postPaths[$fields] as $key => $path) {
				$f[$key] = substr(str_replace('/', '.', $path), 1);
			}
			$fields = $f;
		}

		$data = array();
		foreach ($fields as $key => $path) {
			if (!isset($named[$key])) continue;
			$data = Set::insert($data, $path, base64_decode($named[$key]));
		}
		return $data;
	}
	
	function parseTemplatePath($templateStr){
		if(strpos($templateStr,'.') !== false){
			$splitPlugin = split('\.',$templateStr);
			$pluginName = $splitPlugin[0];
			$templateName = $splitPlugin[1];
			$templatePath = (APP . 'Plugin' . DS . $pluginName . DS . 'View' . DS . 'Emails' . DS . 'html' . DS . $templateName . '.ctp');
		}else{
			$templatePath = (APP . 'View' . DS . 'Emails' . DS . 'html' . DS . $templateStr . '.ctp');
		}
		return $templatePath;
	}

}