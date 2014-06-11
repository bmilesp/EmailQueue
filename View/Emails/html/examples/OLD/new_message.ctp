<?php echo sprintf(__('New message with subject "%s" received.', true), $subject);?>
<?php $url = Router::url(array('controller' => 'appointments', 'action' => 'messages', $appointment_id), true);?>
<?php echo $this->Html->link(__('View message', true), $url);?>