<?php
/**
 * ApiShellTest file
 *
 * PHP 5
 *
 * CakePHP :  Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc.
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc.
 * @link          http://cakephp.org CakePHP Project
 * @package       Cake.Test.Case.Console.Command
 * @since         CakePHP v 1.2.0.7726
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('ShellDispatcher', 'Console');
App::uses('Shell', 'Console');
App::uses('EmailQueueShell', 'EmailQueue.Console/Command');
App::import('EmailQueue.Config', 'Config');

/**
 * ApiShellTest class
 *
 * @package       Cake.Test.Case.Console.Command
 */
class EmailQueueShellTest extends CakeTestCase {


	public $fixtures = array('plugin.email_queue.email_queue');
	
/**
 * setUp method
 *
 * @return void
 */
	public function setUp() {
		
		parent::setUp();
		$out = $this->getMock('ConsoleOutput', array(), array(), '', false);
		$in = $this->getMock('ConsoleInput', array(), array(), '', false);

		$this->EmailQueueShell = new EmailQueueShell();
	}

/**
 * Test that method names are detected properly including those with no arguments.
 *
 * @return void
 */
	public function testEmail() {
		$this->EmailQueueShell->main();
		debug($this->EmailQueueShell->Controller->View);
	}
	
}
		