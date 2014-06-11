<?php 

App::uses('Controller', 'Controller');
App::uses('ComponentCollection', 'Controller');
App::uses('CakeRequest', 'Network');
App::uses('CakeResponse', 'Network');
App::import('EmailQueue.Controller/Component', 'EmailSenderComponent');

// A fake controller to test against
class EmailQueueController extends Controller {
    public $paginate = null;
}

class EmailSenderComponentTest extends CakeTestCase {
    public $EmailSender = null;
    public $Controller = null;

    public function setUp() {
        parent::setUp();
        // Setup our component and fake test controller
        $Collection = new ComponentCollection();
        $this->EmailSender = new EmailSenderComponent($Collection);
        $CakeRequest = new CakeRequest();
        $CakeResponse = new CakeResponse();
        $this->Controller = new EmailQueueController($CakeRequest, $CakeResponse);
        $this->EmailSender->startup($this->Controller);
    }

    public function testSplit_and_sanitize() {
    	
		$result = $this->EmailSender->split_and_sanitize(',, , ,  ,,');
        $this->assertEquals($result, array());
		
		$result = $this->EmailSender->split_and_sanitize(',, ;;;, ,; ; ,,');
        $this->assertEquals($result, array());
		
		$result = $this->EmailSender->split_and_sanitize(',, person@gmail.com ,  ,,');
        $this->assertEquals($result, array('person@gmail.com'));
		
		$result = $this->EmailSender->split_and_sanitize('person@gmail.com ;,');
        $this->assertEquals($result, array('person@gmail.com'));
		
		$result = $this->EmailSender->split_and_sanitize('person@gmail.com');
		$this->assertEquals($result, array('person@gmail.com'));
		
		$result = $this->EmailSender->split_and_sanitize(' person@gmail.com , test@test.com');
        $this->assertEquals($result, array('person@gmail.com','test@test.com'));
		
		$result = $this->EmailSender->split_and_sanitize(' person@gmail.com ; test@test.com');
        $this->assertEquals($result, array('person@gmail.com','test@test.com'));
		
		$result = $this->EmailSender->split_and_sanitize(' ;person@gmail.com , test@test.com');
        $this->assertEquals($result, array('person@gmail.com','test@test.com'));
		
		$result = $this->EmailSender->split_and_sanitize(',;,test@test2.com ;person@gmail.com , test@test.com');
        $this->assertEquals($result, array('person@gmail.com','test@test.com','test@test2.com'));
		
		$result = $this->EmailSender->split_and_sanitize('test@test2.com,person@gmail.com,test@test.com');
        $this->assertEquals($result, array('person@gmail.com','test@test.com','test@test2.com'));
		
		//test sanatize email key
		$result = $this->EmailSender->split_and_sanitize(array(' test@test.com' => array('bp')));
        $this->assertEquals($result, array('test@test.com' => array('bp')));
		
		$result = $this->EmailSender->split_and_sanitize(array(' test@test.com  ' => array('b p ')));
        $this->assertEquals($result, array('test@test.com' => array('b p ')));
		
    }
	

	 public function testemail() {
	 	
		$emailQueueObj = array();
		$emailQueueObj['template_vars']['to'] = 'bp@bp.com';
		$emailQueueObj['template_vars']['from'] = '  system@company.com  ';
		$emailQueueObj['template_vars']['cc'] = 'person@gmail.com';
		$emailQueueObj['template_vars']['bcc'] = 'person@yahoo.com, person@company.com';
		$emailQueueObj['template_vars']['subject'] = 'test';
		$emailQueueObj['template_vars']['body'] = 'test test test';
		
		$expected = array ( 'to' => array ( 'bp@bp.com' => 'bp@bp.com', ), 'from' => array ( 'system@company.com' => 'system@company.com', ), 'cc' => array ( 'person@gmail.com' => 'person@gmail.com', ), 'bcc' => array ( 'person@yahoo.com' => 'person@yahoo.com', 'person@company.com' => 'person@company.com', ), 'subject' => 'test', 'template' => array ( 'template' => 'EmailQueue.raw_body', 'layout' => 'default', ), 'viewVars' => array ( 'to' => 'bp@bp.com', 'from' => 'system@company.com', 'cc' => 'person@gmail.com', 'bcc' => 'person@yahoo.com, person@company.com', 'subject' => 'test', 'body' => 'test test test', ), );
	 	$result = $this->EmailSender->email($emailQueueObj,true);
		$this->assertEquals($result, $expected);
		
		$emailQueueObj['template_vars']['to'] = array('bp@bp.com' => array('Brandon Plasters'));
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => array ( 0 => 'Brandon Plasters'));
		$this->assertEquals($result['to'], $expected);
		
		$emailQueueObj['template_vars']['to'] = 'bp@bp.com, person@gmail.com';
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => 'bp@bp.com', 'person@gmail.com' => 'person@gmail.com');
		$this->assertEquals($result['to'], $expected);
		
		$emailQueueObj['template_vars']['to'] = 'bp@bp.com,,, ; person@gmail.com';
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => 'bp@bp.com', 'person@gmail.com' => 'person@gmail.com');
		$this->assertEquals($result['to'], $expected);
		
		$emailQueueObj['template_vars']['to'] = 'bp@bp.com; person';
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => 'bp@bp.com');
		$this->assertEquals($result['to'], $expected);
		
		//test cc
		$emailQueueObj['template_vars']['cc'] = array('bp@bp.com' => array('Brandon Plasters'));
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => array ( 0 => 'Brandon Plasters'));
		$this->assertEquals($result['cc'], $expected);
		
		$emailQueueObj['template_vars']['cc'] = 'bp@bp.com, person@gmail.com';
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => 'bp@bp.com', 'person@gmail.com' => 'person@gmail.com');
		$this->assertEquals($result['cc'], $expected);
		
		$emailQueueObj['template_vars']['cc'] = 'bp@bp.com,,, ; person@gmail.com';
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => 'bp@bp.com', 'person@gmail.com' => 'person@gmail.com');
		$this->assertEquals($result['cc'], $expected);
		
		$emailQueueObj['template_vars']['cc'] = 'bp@bp.com; person';
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => 'bp@bp.com');
		$this->assertEquals($result['cc'], $expected);
		
		
		//test bcc
		$emailQueueObj['template_vars']['bcc'] = array('bp@bp.com' => array('Brandon Plasters'));
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => array ( 0 => 'Brandon Plasters'));
		$this->assertEquals($result['bcc'], $expected);
		
		$emailQueueObj['template_vars']['bcc'] = 'bp@bp.com, person@gmail.com';
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => 'bp@bp.com', 'person@gmail.com' => 'person@gmail.com');
		$this->assertEquals($result['bcc'], $expected);
		
		$emailQueueObj['template_vars']['bcc'] = 'bp@bp.com,,, ; person@gmail.com';
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => 'bp@bp.com', 'person@gmail.com' => 'person@gmail.com');
		$this->assertEquals($result['bcc'], $expected);
		
		$emailQueueObj['template_vars']['bcc'] = 'bp@bp.com; person';
		$result = $this->EmailSender->email($emailQueueObj,true);
		$expected = array ( 'bp@bp.com' => 'bp@bp.com');
		$this->assertEquals($result['bcc'], $expected);
	 }


    public function tearDown() {
        parent::tearDown();
        // Clean up after we're done
        unset($this->EmailSender);
        unset($this->Controller);
    }
}
