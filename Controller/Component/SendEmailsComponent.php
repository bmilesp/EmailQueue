<?php
App::uses('CakeEmail', 'Network/Email');
App::uses('Component', 'Controller');
App::uses('Validation', 'Utility');

class SendEmailsComponent extends Component {
	var $cakeEmailConfig = array();
	var $delimiters = array(',',';');
	
	var $escapeChars = array(58, 38); // ':', '&'
	
	function checkAndFireLock(){
		if (file_exists(TMP . 'email_queue_sending')) {
			echo 'Apparently another process of EmailQueue is running';
			die;
		}
		touch(TMP . 'email_queue_sending');
	}
	
	/**
 * main method, sends queued emails
 *
 * @access public
 */
	function run_queue() {
		$this->Email = new CakeEmail();
		$this->cakeEmailConfig = Configure::read('EmailQueue.Email.cakeEmailConfig');
		if(!empty($this->cakeEmailConfig)){
			$this->Email->config($this->cakeEmailConfig);
		}

		App::build(array(
			'View' => array(APP . 'View' . DS)
		));
		
		$this->EmailQueue = ClassRegistry::init('EmailQueue.EmailQueue');
		$batchMax = Configure::read('EmailQueue.Email.batchMax');
		$emails = $this->EmailQueue->getBatch($batchMax);
		foreach ($emails as $email) {
			if(!empty($email['EmailQueue']['cakeEmailConfig'])){
				$cfg = array_merge($cakeEmailConfig, $email['EmailQueue']['cakeEmailConfig']);
				$this->Email->config($cfg);	
			}
			$sent = $this->email($email['EmailQueue']); 
			if ($sent) {
				$this->EmailQueue->success($email['EmailQueue']['id']);
				echo 'Email '.$email['EmailQueue']['id'].' sent to: '.$email['EmailQueue']['to'].' successfully.<br>';
			} else {
				$this->EmailQueue->fail($email['EmailQueue']['id']);
			}
		}
		$this->_shutdown();
	}
	

	/**
	 * postfix doesn't like special chrs defined in $this->escapeChars in the name of the sender- so we'll escape them here:
	 * @return [type] [description]
	 */
	function escapeSpecialCharacters($to){
		foreach ($this->escapeChars as $chr){
			if(is_array($to)){

				foreach($to as &$emailTo){
					if(strstr($emailTo, chr($chr))){
						$emailTo = str_replace(chr($chr), chr(92).chr($chr), $emailTo);
					}
				}
			}else{
				if(strstr($to, chr($chr))){
					$to = str_replace(chr($chr), chr(92).chr($chr), $to);
				}
			}
		}
		return $to;
	}

	
	/**
 * Sends the email. Pass in an EmailQueue data object array
 *
 * @param string $to Receiver email address
 * @return boolean
 */
	function email($emailQueueObj = array(), $dontEmail_outputData = false) {
		if(!isset($this->Email)){
			$this->Email = new CakeEmail();
		}
		$this->Email->reset();
		$this->Email->config($this->cakeEmailConfig);
		
		if(!empty($emailQueueObj['template_vars']['email'])){
			array_merge($emailQueueObj,$emailQueueObj['template_vars']['email']);
			unset($emailQueueObj['template_vars']['email']);
		}
		//to
		if(!empty($emailQueueObj['template_vars']['to'])){
			$emailQueueObj['to'] = $this->split_and_sanitize($emailQueueObj['template_vars']['to']);
		}		
		elseif(is_string($emailQueueObj['to']) && strpos($emailQueueObj['to'], ",") !== false){
			$emailQueueObj['to'] = $this->split_and_sanitize($emailQueueObj['to']);
		}


		$emailQueueObj['to'] = $this->escapeSpecialCharacters($emailQueueObj['to']);


		if(!empty($emailQueueObj['to'])){
			try{
				$this->Email->to($emailQueueObj['to']);
			}catch (Exception $e) {
				//TODO log email error
				debug('error to field');
				return false;
			}
		}
		
		//from
		if (!empty($emailQueueObj['template_vars']['from'])) {
			try{
				if(is_string($emailQueueObj['template_vars']['from'])){
					$emailQueueObj['template_vars']['from'] = trim($emailQueueObj['template_vars']['from']);
				}
				if(!empty($emailQueueObj['template_vars']['from'])){
					$this->Email->sender($emailQueueObj['template_vars']['from']);
					$this->Email->replyTo($emailQueueObj['template_vars']['from']);
					$this->Email->from($emailQueueObj['template_vars']['from']);	
				}
			}catch (Exception $e) {
				//TODO log email error
				debug('error from field');
				return false;
			}
			
			
		} else {
			$this->Email->from(Configure::read('EmailQueue.Email.from'));
		}
		
		//cc
		
		if(!empty($emailQueueObj['template_vars']['cc'])){
				//trim and check again
				if(is_string($emailQueueObj['template_vars']['cc'])){
					$emailQueueObj['template_vars']['cc'] = trim($emailQueueObj['template_vars']['cc']);
				}
				if(!empty($emailQueueObj['template_vars']['cc'])){
					$emailQueueObj['cc'] = $this->split_and_sanitize($emailQueueObj['template_vars']['cc']);
				}
				
				if(!empty($emailQueueObj['cc'])){
					try{
						$this->Email->cc($emailQueueObj['cc']);
					}catch (Exception $e) {
						//TODO log email error
						debug('error cc field');
						return false;
					}
				}
			
		}
		
		//bcc
		if(!empty($emailQueueObj['template_vars']['bcc'])){
			if(is_string($emailQueueObj['template_vars']['bcc'])){
				$emailQueueObj['template_vars']['bcc'] = trim($emailQueueObj['template_vars']['bcc']);
			}
			
			if(!empty($emailQueueObj['template_vars']['bcc'])){
				$emailQueueObj['bcc'] = $this->split_and_sanitize($emailQueueObj['template_vars']['bcc']);
				if(!empty($emailQueueObj['bcc'])){
					try{
						$this->Email->bcc($emailQueueObj['bcc']);
					}catch (Exception $e) {
						//TODO log email error
						debug('error bcc field');
						return false;
					}
				}
			}
		}		
		//subject
		if (!empty($emailQueueObj['template_vars']['subject'])) {
			$this->Email->subject($emailQueueObj['template_vars']['subject']);
		} else {
			$this->Email->subject('Automated Message');
		}
		
		if (!empty($emailQueueObj['emailFormat'])) {
			$this->Email->subject($emailQueueObj['emailFormat']);
		} else {
			$this->Email->emailFormat(Configure::read('EmailQueue.Email.emailFormat'));
		}

		if (!empty($emailQueueObj['template_vars']['template'])) {
			$this->Email->template($emailQueueObj['template_vars']['template']);
		} else if(!empty($emailQueueObj['template'])) {
			$this->Email->template($emailQueueObj['template']);
		}else{
			$this->Email->template('EmailQueue.raw_body');
		}
		$this->Email->viewVars($emailQueueObj['template_vars']);
		
		/* for testing */
		if($dontEmail_outputData === true){
			$data = array();
			$data['to'] = $this->Email->to();
			$data['from'] = $this->Email->from();
			$data['cc'] = $this->Email->cc();
			$data['bcc'] = $this->Email->bcc();
			$data['subject'] = $this->Email->subject();
			$data ['template'] = $this->Email->template();
			$data['viewVars'] = $this->Email->viewVars();
			return $data;
		}
		
		try{
			$this->Email->send();
		}catch (Exception $e) {
			//TODO log email error
			debug('Error send failed: '.$e);
			return false;
		}
		
		return true;
	} 

	function split_and_sanitize($string = null){
		$delimiters = $this->delimiters;
		$retData = false;
		$allEmpty = false;
		if(is_string($string)){
			$string = trim($string);
			
			
			$delems = array();
			foreach ($delimiters as $d){
				if(strpos($string, $d) !== false){
					$delems[] = $d;
				}
			}
			$retData = $this->multiExplode($delems, $string);
			foreach ($retData as $key=>&$eTo){
				$eTo = trim($eTo);
				if(!Validation::email($retData[$key])){
					unset($retData[$key]);
				}
			}
			//check if nothing was exploded, and assign string as email
			if($retData === false){
				$retData = array($string);
			}else{
				//remove empty's and 'sort' to reorder numeric keys
				$retData = array_filter($retData);
				sort($retData);
			}
		}else{
			$retData = array_filter($string);	
		}
		return $retData;
	}
	
	function _shutdown() {
		
		if(file_exists(TMP . 'email_queue_sending')){
			unlink(TMP . 'email_queue_sending');
		}
		echo 'Email Queue Complete.';
	}
	
	public function multiExplode($needles = array(), $input = ''){
		if(count($needles) == 0){
			return array($input);
		}
		if(count($needles) == 1){
			return explode($needles[0],$input);
		}
		
		$delems = implode('',$needles);
		return preg_split( "/([{$delems}]+)/", $input );
	}
	
}