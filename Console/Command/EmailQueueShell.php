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
 * Email Queue shell
 *
 * @package blazon
 * @subpackage blazon.vendors.shells
 */
 
App::uses('AppShell', 'Console/Command');
App::import('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::import('Model', 'EmailQueue.EmailQueue');
App::import('COnfig', 'EmailQueue.Config');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ClassRegistry', 'Utility');
App::uses('View', 'View');
App::uses('Helper', 'View');
App::uses('CakeEmail', 'Network/Email');

//App::uses('Config', 'EmailQueue.Config');
//App::uses('Email', 'EmailQueue.Config');

class EmailQueueController extends Controller {


	public $name = 'EmailQueue';
	public $uses = null;
	public $components = array('Session', 'Email');

	public function __construct($request = null, $response = null) {
		parent::__construct($request, $response);
		
		$this->constructClasses();
		$this->startupProcess();

	}


	public function beforeRender() {
		parent::beforeRender();
		foreach ($this->viewVars as $key => $value) {
			if (!is_object($value)) {
				$this->viewVars[$key] = h($value);
			}
		}
	}

} 
 
class EmailQueueShell extends AppShell {


/**
 * Checks existance of mutex and exits if present, otherwise it creates the mutex
 *
 * @access protected
 */
	public function startup() {
		if($this->command != 'force_unlock'){
			if (file_exists(TMP . 'email_queue_sending')) {
				$this->err(__d('blazon', 'Apparently another process of EmailQueue is running'));
				$this->_stop();
			}
			touch(TMP . 'email_queue_sending');
		}
	}


/**
 * Shell main method, sends queued emails
 *
 * @access public
 */
	public function run_queue() {
        $this->Controller = new EmailQueueController();
		$this->Controller->Components->init($this->Controller);
		$this->Email = new CakeEmail();
		$cakeEmailConfig = Configure::read('EmailQueue.Email.cakeEmailConfig');
		if(!empty($cakeEmailConfig)){
			$this->Email->config($cakeEmailConfig);
		}

		App::build(array(
			'View' => array(APP . 'View' . DS)
		));
		
		$this->EmailQueue = ClassRegistry::init('EmailQueue.EmailQueue');
		
		$batchMax = Configure::read('EmailQueue.Email.batchMax');
		$emails = $this->EmailQueue->getBatch();
		foreach ($emails as $email) {
			if(!empty($email['EmailQueue']['cakeEmailConfig'])){
				$cfg = array_merge($cakeEmailConfig, $email['EmailQueue']['cakeEmailConfig']);
				$this->Email->config($cfg);	
			}
			
			$sent = $this->email($email['EmailQueue']); 
			if ($sent) {
				$this->EmailQueue->success($email['EmailQueue']['id']);
				$this->out('Email '.$email['EmailQueue']['id'].' sent to: '.$email['EmailQueue']['to'].' successfully.');
			} else {
				$this->EmailQueue->fail($email['EmailQueue']['id']);
			}
		}
		$this->_shutdown();
	}
	
	/**
 * Sends the verification email. Pass in an EmailQueue data object array
 *
 * @param string $to Receiver email address
 * @return boolean
 */
	public function email($emailQueueObj = array()) {
		
		if(!empty($emailQueueObj['template_vars']['email'])){
			array_merge($emailQueueObj,$emailQueueObj['template_vars']['email']);
			unset($emailQueueObj['template_vars']['email']);
		}
		if(strpos($emailQueueObj['to'], ",") !== false){
			$emailQueueObj['to'] = explode(",", $emailQueueObj['to']);
		}
		$this->Email->to($emailQueueObj['to']);

		
		if (!empty($emailQueueObj['from'])) {
			$this->Email->from($emailQueueObj['from']);
		} else {
			$this->Email->from(Configure::read('EmailQueue.Email.from'));
		}
		
		if (!empty($emailQueueObj['subject'])) {
			$this->Email->subject($emailQueueObj['subject']);
		} else {
			$this->Email->subject('Automated Message');
		}
		
		if (!empty($emailQueueObj['emailFormat'])) {
			$this->Email->subject($emailQueueObj['emailFormat']);
		} else {
			$this->Email->emailFormat(Configure::read('EmailQueue.Email.emailFormat'));
		}

		if (!empty($emailQueueObj['template'])) {
			$this->Email->template($emailQueueObj['template']);
		} else {
			$this->Email->template('EmailQueue.default');
		}
		$this->Email->viewVars($emailQueueObj['template_vars']);
		return $this->Email->send();
	} 

/**
 * Deletes the mutex
 *
 * @access protected
 */
	protected function _shutdown() {
		unlink(TMP . 'email_queue_sending');
	}
	
	public function force_unlock() {
		unlink(TMP . 'email_queue_sending');
		$this->out('removed lock file.');
	}
 
 	public function tearDown() {
		parent::tearDown();
		App::build();
	}
	
	
	
}