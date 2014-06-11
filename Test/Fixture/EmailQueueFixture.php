<?php
/* EmailQueue Fixture generated on: 2011-03-30 15:03:02 : 1301498162 */
class EmailQueueFixture extends CakeTestFixture {
	var $name = 'EmailQueue';
	var $table = 'email_queue';

	var $fields = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'to' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'template' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'template_vars' => array('type' => 'text', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'sent' => array('type' => 'boolean', 'null' => false, 'default' => NULL),
		'send_tries' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'send_at' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'MyISAM')
	);

	var $records = array(
		array(
			'id' => '4d6b7522-2430-434d-9fdb-57aeadcb5c22',
			'to' => 'person@gmail.com',
			'template' => 'EmailQueue.cancel',
			'template_vars' => 'a:0:{}',
			'sent' => 1,
			'send_tries' => 0,
			'send_at' => '1969-12-31 23:00:00',
			'created' => '2011-02-28 10:12:50',
			'modified' => '2011-03-03 16:43:34'
		),
		array(
			'id' => '4d6b7522-e1e4-4845-ba95-57aeadcb5c22',
			'to' => 'person@gmail.com',
			'template' => 'EmailQueue.cancel',
			'template_vars' => 'a:7:{s:11:"appointment";N;s:6:"expert";a:7:{s:2:"id";s:1:"2";s:7:"user_id";s:36:"4d640c35-e1d0-4ebe-8f26-028dadcb5c22";s:10:"first_name";s:5:"David";s:9:"last_name";s:8:"Kullmann";s:5:"photo";s:46:"users/4d640c35-e1d0-4ebe-8f26-028dadcb5c22.jpg";s:9:"time_zone";s:16:"America/New_York";s:9:"full_name";s:14:"David Kullmann";}s:9:"requester";a:7:{s:2:"id";s:1:"5";s:7:"user_id";s:36:"4d64b6e3-8c18-49b9-973a-43aeadcb5c22";s:10:"first_name";s:5:"Vivek";s:9:"last_name";s:6:"Mishra";s:5:"photo";s:46:"users/4d64b6e3-8c18-49b9-973a-43aeadcb5c22.jpg";s:9:"time_zone";s:16:"America/New_York";s:9:"full_name";s:12:"Vivek Mishra";}s:21:"expertAppointmentTime";s:19:"2011-02-28 05:12:50";s:24:"requesterAppointmentTime";s:19:"2011-02-28 05:12:50";s:7:"subject";s:45:"Get Ready For Your Expert Insight Appointment";s:8:"template";s:17:"one_hour_reminder";}',
			'sent' => 0,
			'send_tries' => 0,
			'send_at' => '1969-12-31 23:00:00',
			'created' => '2011-02-28 10:12:50',
			'modified' => '2011-03-03 16:43:35'
		),
	);
}
?>