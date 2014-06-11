<?php
echo $this->Html->css("booking_receipt", null, array("inline"=>true));
date_default_timezone_set($appointment['Appointment']['time_zone']); 
$appointmentLocalTime = CalendarDate::convertFromUTC($appointment['Appointment']['start_date'], $client['Profile']['time_zone']);

?>
<tr>
<td height="0" colspan="2" >
	<table width="630" border="0" cellspacing="0" cellpadding="0" style="width: 100%;background-color: #fff;" >
		<tr>	
		<td align="left" style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 20px; color: #666666; padding-top: 10px; padding-right: 30px; padding-bottom: 10px; padding-left: 10px;">
		<h2><?php __('Thank you for purchasing an Expert Insight consultation')?></h2>
		<p>
		Dear <?php echo $client['Profile']['first_name']?> <?php echo $client['Profile']['last_name']?>,
		</p><p>
		Thank you for booking your appointment with Expert Insight.
		</p><p>
		Please note that <?php echo $expert['Profile']['first_name']?> <?php echo $expert['Profile']['last_name']?> 
		will have to confirm your appointment date and time. If for any reason
		the requested date and time are unavailable you will be able to reschedule
		at a time that is convenient for both you and the expert or receive a refund.
		</p><p>
		We have saved this information to <?php echo $this->Html->link(__('your account', true),$accountUrl)?>.
		</p>
		<h3><?php __('For your appointment')?>:</h3>
		<p>
		1. To start your appointment, login to <?php echo $this->Html->link(__('your account', true), $accountUrl)?>
		and visit the page for <?php echo $this->Html->link(__('this appointment', true),$viewAppointmentUrl)?>
		at the appointment start time (<?php echo date('m-d-Y', strtotime($appointmentLocalTime))?>
		 <?php echo date('g:i T (\G\M\T P)', strtotime($appointmentLocalTime))?>).
		</p><p>
		2. If you need to discuss anything in preperation for your appointment you may login and
		visit the <?php echo $this->Html->link(__('appointment', true),$viewAppointmentUrl)?> page
		at anytime. After the appointment email communication will be disabled unless a follow-up
		appointment is created.
		</p>
		<?php echo $this->element('appointments/receipt_attending_datetime_email')?>
		
		<h3><?php __('Please retain for your records')?>.</h3>
		<p>
		Please see our <?php echo $this->Html->link('Terms and Conditions',$termsAndConditionsUrl);?>
		 pertaining to this order.
		</p>
		<h3><?php __('Need help?')?></h3>
		<p>
		Please see our frequently asked questions, or add a new question at our 
		<?php echo $this->Html->link(__('community help forum', true),$forumUrl) ?>.
		</p>
		</td>
		</tr>
	</table>
</td>
</tr>