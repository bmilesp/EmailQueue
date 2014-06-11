<?php

/*
Configure::read('EmailQueue.options', array(
	'sendToDefault' => 'IT@site.com',
	'batchMax' => 50,
	'from'     => 'system@site.com',
	'emailFormat'   => 'html',
	'replyTo'  => 'no-reply@site.com',
	'cakeEmailConfig' => array(
		'host' => 'ssl://smtp.gmail.com',
        'port' => 465,
        'username' => 'system@site.com',
        'password' => 'password',
        'transport' => 'Smtp'
	)
);
*/
/* set EmailQueue.usePosfix in core on servers to use local mail server
 * (google will not allow send 'From' address to change, forcing the From address to be overwritten
 * by the logged in account email address)
 * 
 */

$options = Configure::read('EmailQueue.options');

$usePosfix = Configure::read('EmailQueue.usePosfix');
if (!empty($usePosfix)){
	unset($options['cakeEmailConfig']);
}

Configure::write('EmailQueue.Email', $options);
