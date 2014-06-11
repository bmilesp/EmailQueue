<?php
App::import('Model', 'EmailQueue.EmailQueue');

class TestEmailQueue extends EmailQueue {
	
	public $useTable ='email_queue';
	
	protected $_postPaths = array(
		'fruit' => array(
			'banana'     => '/Tree/banana',
			'watermelon' => '/Ground/watermelon',
			'orange'     => '/Tree/orange',
		),
	);
}

class EmailQueueTestCase extends CakeTestCase {
	
	public $fixtures = array('plugin.email_queue.email_queue');
/**
 * Plugin name for fixtures autoloading
 *
 * @var string
 */
	public $plugin = 'app';

/**
 * Model being tested
 *
 * @var Invite
 */
	public $EmailQueue;

/**
 * Test to run for the test case (e.g array('testFind', 'testView'))
 * If this attribute is not empty only the tests from the list will be executed
 *
 * @var array
 */
	protected $_testsToRun = array();


	public function startTest($method) {
		parent::startTest($method);
		$this->EmailQueue = ClassRegistry::init('TestEmailQueue');
	}

	public function endTest($method) {
		parent::endTest($method);
		unset($this->EmailQueue);
		ClassRegistry::flush();
	}

	public function testInstance() {
		$this->assertTrue(is_a($this->EmailQueue, 'EmailQueue'));
	}

	public function testTemplate() {
		//$result = $this->EmailQueue->template(null, array());
		//$this->assertEquals($result, array(false, false));

		$result = $this->EmailQueue->template('4d6b7522-2430-434d-9fdb-57aeadcb5c22', array());//debug($result);die;
		$expected = array(
			'/Users/jose/Sites/work/expert_insight/app/tmp/cache/views/email-0-96562500-1301506956.ctp',
			array()
		);
		$this->assertInternalType('string',$result[0]);
		$this->assertEquals($result[1], array());

		$data = array(
			'TestEmailQueue' => array(
				'vars' => '{"true": "15""}',
			),
		);
		//$result = $this->EmailQueue->template(null, $data);
		//$this->assertEquals($result, array(false, false));

		$data = array(
			'TestEmailQueue' => array(
				'vars' => '{"true": "15"}',
				'template' => 'data',
			),
		);
		$result = $this->EmailQueue->template(null, $data);
		$this->assertEqual(count($result), 2);

		$this->assertInternalType('string',$result[0]);
		$this->assertEquals($result[1], array('true' => '15'));

	}

	public function testFindEdit() {
		$result = $this->EmailQueue->find('edit');
		$this->assertEquals($result, array(false, false));

		$expected = array(
			array('TestEmailQueue' => array('template_vars' => '[]', 'template' => 'EmailQueue.cancel')),
			'/Users/jose/Sites/work/expert_insight/app/views/elements/email/html/cancel.ctp'
		);
		$result = $this->EmailQueue->find('edit','4d6b7522-2430-434d-9fdb-57aeadcb5c22');
		
		$this->assertEquals($result[0], $expected[0]);
		$this->assertInternalType('string',$result[1]);

		$result = $this->EmailQueue->find('edit', array('id' => '4d6b7522-2430-434d-9fdb-57aeadcb5c22'));
		$this->assertEquals($result[0], $expected[0]);
		$this->assertInternalType('string',$result[1]);
	}

	public function testJsonUnwrap() {
		$result = $this->EmailQueue->jsonUnwrap(array());
		$this->assertEquals($result, array());

		$result = $this->EmailQueue->jsonUnwrap(array('key' => 'value'));
		$this->assertEquals($result, array('key' => 'value'));

		$result = $this->EmailQueue->jsonUnwrap(array('key' => array('k' => 'v')));
		$this->assertEquals($result, array('key' => array('k' => 'v')));

		$result = $this->EmailQueue->jsonUnwrap(array('key' => (object) array('k' => 'v')));
		$this->assertEquals($result, array('key' => array('k' => 'v')));
	}

	public function testDataToNamed() {
		$result = $this->EmailQueue->dataToNamed(array(), array('apple' => '/apple/banana'));
		$this->assertEquals($result, array());

		$result = $this->EmailQueue->dataToNamed(array(), 'notset');
		$this->assertEquals($result, array());

		$data = array(
			'Tree' => array('banana' => 'yes')
		);
		
		$result = $this->EmailQueue->dataToNamed($data, 'notset');
		
		$this->assertEquals($result, array());

		$result = $this->EmailQueue->dataToNamed($data, array('apple' => '/apple/banana'));
		$this->assertEquals($result, array());

		$data = array(
			'Tree' => array('banana' => 'yes')
		);
		$result = $this->EmailQueue->dataToNamed($data, 'fruit');
		$this->assertEquals($result, array('banana' => base64_encode('yes')));
	}

	public function testNamedToData() {
		$result = $this->EmailQueue->namedToData(array(), array('apple' => 'apple.banana'));
		$this->assertEquals($result, array());

		$result = $this->EmailQueue->namedToData(array(), 'notset');
		$this->assertEquals($result, array());

		$named = array(
			'banana' => 'yes',
			'watermelon' => 'yes',
			'potato' => 'no',
		);

		$result = $this->EmailQueue->namedToData($named, 'notset');
		$this->assertEquals($result, array());

		$result = $this->EmailQueue->namedToData($named, 'fruit');
		$expected = array(
			'Tree' => array('banana' => base64_decode('yes')),
			'Ground' => array('watermelon' => base64_decode('yes')),
		);
		$this->assertEquals($result, $expected);
	}

}