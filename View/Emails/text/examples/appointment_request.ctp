<?php //debug($appointment); ?>
<?php //debug($expert); ?>
<?php //debug($requester); ?>
<?php //debug($expertAppointmentTime); ?>
<?php //debug($requesterAppointmentTime); ?>
<?php //debug($subject); ?>
<?php //debug($user); // the email recipient?>
<?php echo $requester['full_name']; ?> has requested an appointment with you on <?php echo $expertAppointmentTime; ?>.
Please visit
<?php
	echo $this->Html->link($confirmUrl, $confirmUrl);
?>
to confirm this appointment.

