<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<body>

<style>
h1
{
  margin: 0;
  color: #A72D27;
  font-family: 'LeagueGothicRegular','Arial Narrow','Arial Narrow',Arial,San-serif;
  font-weight: normal;
  text-transform: uppercase;
}

#content
{
  width: 500px;
  margin: auto;
}

div.title
{
  background: #ccc;
  color: #fff;
  padding: .5em;
  font-weight: bold;
}

table
{
  width: 100%;
}

th
{
  text-align: left;
  padding: 5px 0;
}

td
{
  text-align: right;
}

span.left
{
  display: inline;
  float: left;
}

div.totals
{
  float: right;
  text-align: right;
  font-weight: bold;
}

div.message
{
  padding: .5em 0;
}

hr
{
  border: none;
  border-top:1px solid #999;
}

#sig_line
{
  font-weight: bold;
  clear: both;
  width: 100%;
  text-align: center;
  padding: 50px 0 0 0;
}
</style>
<?php
/**************************************** //Test Content
$data = array(
    "Payment" => array(
            "First Name" => "Ben",
            "Last Name" => "Talavera",
            "Payment Type" => "Visa",
            "Card Number" => "1234567890",
            "CVV" => "1234",
            "Expiration Month" => "01",
            "Expiration Year" => "2011",
            "Street Address" => "123 Somewhere",
            "Additional" => "Apt 1A",
            "City" => "Ann Arbor",
            "State" => "MI",
            "Zip Code" => "48103",
            "Country" => "US",
            "Home Phone" => "1234657890"),
    "Orders" => array(
            97949,
            97948,
            97946,
            97942,
            97941,
            97940,
            97939,
            97938,
            97937,
            97936,
            97934,
            97933,
            97932,
            97914,
            97913,
            97891,
            97890,
            97889,
            97888,
            97887,
            97886,
            97885,
            97884,
            97882,
            97880),
    "Total" => 2056.25)
$transaction_id = "293847652983746598237465";
$sig_line = true;
/************************************************/

$sig_line = isset($sig_line)?$sig_line:false;
?>
	<div id="content">
		<h1>Payment Confirmation</h1>
		<div class="message">Thank you for your payment.  Please save this email for your records.</div>
		<div class="title">Order Information</div>
		<table class="sub">
			<tr><th>Customer:</th><td><?php echo $data['Payment']['First Name'] . " " . $data['Payment']['Last Name']; ?></td></tr>
			<tr><th>Transaction ID:</th><td><?php echo $transaction_id; ?></td></tr>
		</table>
		<hr>
		<table class="sub">
<?php			
			foreach($orders as $order) 
			{
				echo "<tr><th>" . $order['Order']['id'] . "</th><th>" . $order['Order']['job_name'] . "</th><td>$" . number_format($order['Order']['amount_due'],2) . "</td></tr>";
			}
?>
		</table>
		<HR>
		<div class="totals">
			Total $<?php echo number_format($data['Total'], 2); ?><BR>
		</div>
	</div>
</body>
</html>