<?php

App::uses('AppShell', 'Console/Command');
App::import('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::import('Model', 'EmailQueue.EmailQueue');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::uses('ClassRegistry', 'Utility');
App::uses('View', 'View');
App::uses('Helper', 'View');

//App::uses('Config', 'EmailQueue.Config');
//App::uses('Email', 'EmailQueue.Config');

class EmailQueueController extends EmailQueueAppController {

	var $components = array('Search.Prg','EmailQueue.SendEmails'); 
	var $helpers = array('Time');
	
	public function beforeFilter(){
		if(!empty($this->Auth)){
			$this->Auth->allow('start_queue','force_unlock','api_email','mail_analyser','test_email');
		}
		parent::beforeFilter();
	}

	public function index() {
		$this->Prg->commonProcess();
		$this->request->data['EmailQueue'] = $this->passedArgs;
		$this->paginate = array(null, 'conditions' => $this->EmailQueue->parseCriteria($this->passedArgs));
		$this->set('emailQueues', $this->paginate());
	}


	public function edit($id) {
		list($emailQueue, $path) = $this->EmailQueue->find('edit', $id);
		if (!$emailQueue || !$path) {
			$this->redirect(array('action' => 'index'));
		}
		App::import('Utility', 'File');
		$File = new File($path);
		$template = $File->read();
		$this->redirect(array('action' => 'preview', $id));
		$this->set(compact('emailQueue', 'template','id'));
	}
	
	public function preview($id = null) {
		Configure::write("debug", 0);
		//list($emailQueue, $path) = $this->EmailQueue->find('edit', $id);
		list($emailQueue, $path) = $this->EmailQueue->find('edit', $id);
		$this->request->data['EmailQueue']['template'] = $emailQueue['EmailQueue']['template'];
		$this->request->data['EmailQueue']['vars'] = $emailQueue['EmailQueue']['template_vars'];
	
		try {
			list($file, $viewVars) = $this->EmailQueue->template($id, $this->request->data);
		} catch (Exception $e) {
			$this->Session->setFlash($e->getMessage());
			$this->redirect(array('action' => 'index'));
		}
		$this->layout = false;
		$this->set($viewVars);
		$this->autoRender=false;
		$this->render($file);
	}
	
	
/**
 * Checks existance of mutex and exits if present, otherwise it creates the mutex
 *
 * @access protected
 */
	public function start_queue($bypassAuthKey = null){
		$this->autoRender = false;
		$baKeyMatch = Configure::read('bypassAuthKey');
		if($bypassAuthKey == $baKeyMatch){
			$this->SendEmails->checkAndFireLock();
			$this->SendEmails->run_queue();
			
		}else{
			$this->redirect(array('action' => 'index'));
		}
	}



/**
 * External Email Call. Post the EmailQueue data object as you would to $this->email
 *
 * 
 * first cp /{path to cake app folder}/Plugin/EmailQueue/Lib/pflogsumm.pl /usr/sbin/pflogsumm
 * p /{path to cake app folder}/Plugin/EmailQueue/Lib/postfix_log_analyzer.sh /usr/sbin/postfix_log_analyzer.sh
 * set 775 permissions on both of these files
 * 
 * in /etc/sudoers add these lines:
 *  www-data ALL = NOPASSWD: /usr/sbin/pflogsumm
	www-data ALL = NOPASSWD: /usr/sbin/postfix_log_analyzer.sh
 * 
 * be sure to change the email address in the script to your email
 * now you can run this action with the haskKey passed to execute the postfix analyzer script
 * 
 * set email to address as Configure::write EmailQueue.Email.sendToDefault in bootstrap 
 */ 
 function mail_analyser($key = null){
 	$this->autoRender = false;	
	$compareKey = Configure::read('bypassAuthKey');
	if($compareKey == $key){
		$emailTo = Configure::read('EmailQueue.Email.sendToDefault');
		echo 'script start<br>';
 		echo shell_exec('sudo /usr/sbin/postfix_log_analyzer.sh '. $emailTo);
	}
 }
 
 
 function api_email($key = null){
 	$this->autoRender = false;	
 	$compareKey = Configure::read('bypassAuthKey');
	if($compareKey == $key){
	 	$data = !empty($this->request->data['EmailQueue'])? $this->request->data['EmailQueue'] : array();
		$data = (empty($data) && !empty($this->request->data))? $this->request->data : array();
		if (!empty($data)){
			$data['template'] = !empty($data['template'])?$data['template']:'EmailQueue.email_template';
			$data['time'] = !empty($data['time'])?$data['time']:null;
			if($this->EmailQueue->enqueue(null,$data,$data['template'],$data['time'])){
				return '1'; 
			}else{
				return 'Error: Email failed to queue.';
			}
		}
		return 'Error: Post data is empty.';
	}else{
		echo 'Error: Incorrect Key.';
	}
 }

/**
 * Deletes the mutex
 *
 * @access protected
 */

	public function force_unlock($bypassAuthKey = null) {
		$this->autoRender = false;
		$baKeyMatch = Configure::read('bypassAuthKey');
		if($bypassAuthKey == $baKeyMatch){
			unlink(TMP . 'email_queue_sending');
			echo 'removed lock file.';
			die;
		}else{
			$this->redirect(array('action' => 'index'));
		}
	}

	
}
