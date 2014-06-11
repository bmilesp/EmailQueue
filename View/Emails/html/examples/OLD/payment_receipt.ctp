<p>Keep this email for a record of your payment. <?php echo sprintf( '%s %s', $ExpertProfile['first_name'], $ExpertProfile['last_name'] ) ?> must approve the appointment before it is confirmed.</p>

<p>Payment Details:</p>

<p>
Appointment ID: <?php echo $Appointment['id'] ?><br/>
Amount Charged: <?php echo $Payment['amount'] ?><br/>
Card: <?php echo $Payment['account_number'] ?><br />
</p>
