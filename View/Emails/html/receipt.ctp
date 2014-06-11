<table style="width: 550px; background: #ffffff; color: #444444; margin: auto; font-family: Helvetica, sans-serif;">
	<tr>
		<td style="padding: 5px">
			<img width="150" style="float: left" src="http://newsroom.unl.edu/announce/files/file18749.jpg" />
		</td>
	</tr>
	<tr>
		<td>
			<table style=" box-shadow: 0 2px 2px rgba(0,0,0,0.3);  width: 100%">
				<tr style="background: #444444; color: #fff; text-align: center; text-shadow: 0 1px 1px rgba(0,0,0,0.3)">
					<td colspan="2" style="padding: 5px;">Customer Info</td>
				</tr>
				<tr style="font-size: 14px">
					<td colspan="2">
						<table style="color: #444444; font-size: 12px; width: 100%">
							<tr>
								<td style="font-weight: 700; padding: 5px; text-align: right; width: 50%">Customer Name:</td>
								<td style="padding: 5px; text-align: left;"><?php echo $name; ?></td>
							</tr>
							<?php if(!empty($job_name)){ ?>
							<tr>
								<td style="font-weight: 700; padding: 5px; text-align: right;">Job Name:</td>
								<td style="padding: 5px; text-align: left;"><?php echo $job_name; ?></td>
							</tr>
							<?php } ?>
						</table>	
					</td>
				<tr style="background: #444444; color: #fff; text-align: center; text-shadow: 0 1px 1px rgba(0,0,0,0.3)">
					<td colspan="2"  style="padding: 5px;">Billing Information</td>
				</tr>
				<tr>
					<td colspan="2">
						<table style="color: #444444; font-size: 12px; width: 100%">
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Transaction ID:</td>
								<td style="padding: 3px; text-align: left"><?php echo $transaction_id; ?></td>
							</tr>
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Billed to:</td>
								<td style="padding: 3px; text-align: left"><?php echo $billinginfo['fname']; ?> <?php echo $billinginfo['lname']; ?></td>
							</tr>
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Card Information:</td>
								<td style="padding: 3px; text-align: left"><?php echo $response['52']; ?> <?php echo $response['51']; ?></td>
							</tr>
						</table>	
					</td>
				</tr>
				<?php if(!empty($orders)){ ?>
					<tr style="background: #444444; color: #fff; text-align: center; text-shadow: 0 1px 1px rgba(0,0,0,0.3)">
						<td colspan="2"  style="padding: 5px;">Individual Order Information</td>
					</tr>
				<?php } else { ?>
					<tr style="background: #444444; color: #fff; text-align: center; text-shadow: 0 1px 1px rgba(0,0,0,0.3)">
						<td colspan="2"  style="padding: 5px;">Order Information</td>
					</tr>
				<?php } ?>
				<?php if(!empty($orders)){ ?>
					<?php foreach ($orders as $key => $order) { ?>
						<tr>	
							<td colspan="2">
								<table style="color: #444444; font-size: 12px; width: 100%">
									<tr>
										<td style="font-weight: 700; padding: 3px; text-align: right; width: 50%">Invoice:</td>
										<td style="padding: 3px; text-align: left; width: 50%">
											<a href="https://my.undergroundshirts.com/orders/view/<?php echo $order['Order']['id']; ?>"><?php echo $order['Order']['id']; ?></a>
										</td>
									</tr>
									<tr>
										<td style="font-weight: 700; padding: 3px; text-align: right; width: 50%">Job Name:</td>
										<td style="padding: 3px; text-align: left; width: 50%"><?php echo $order['Order']['job_name']; ?></td>
									</tr>
									<tr>
										<td style="font-weight: 700; padding: 3px; text-align: right; width: 50%">Total</td>
										<td style="padding: 3px; text-align: left; width: 50%">$<?php echo $order['Order']['total']; ?></td>
									</tr>
								</table>
							</td>
						</tr>
					<?php } ?>
				<?php } else { ?>
				<tr>	
					<td colspan="2">
						<table style="color: #444444; font-size: 12px; width: 100%">
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right; width: 50%">Product Subtotal</td>
								<td style="padding: 3px; text-align: left; width: 50%">$<?php echo $prod_subtotal; ?></td>
							</tr>
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Discount</td>
								<td style="padding: 3px; text-align: left">$<?php echo $discount; ?></td>
							</tr>
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Shipping</td>
								<td style="padding: 3px; text-align: left">$<?php echo $shipping; ?></td>
							</tr>
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Royalty</td>
								<td style="padding: 3px; text-align: left">$<?php echo $royalty; ?></td>
							</tr>
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Additional</td>
								<td style="padding: 3px; text-align: left">$<?php echo $additional; ?></td>
							</tr>
							
							
						</table>
					</td>
				</tr>
				<?php } ?>
				<?php if(!empty($orders)){ ?>
					<tr style="background: #444444; color: #fff; text-align: center; text-shadow: 0 1px 1px rgba(0,0,0,0.3)">
						<td colspan="2"  style="padding: 5px;">All Order Totals</td>
					</tr>
				<?php } else { ?>	
				<tr>
					<td colspan="2" style="height: 1px; background: #f2f2f2"></td>
				</tr>
				<?php } ?>
				<tr>
					<td colspan="2">
						<table style="color: #444444; font-size: 12px; width: 100%">
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right; width: 50%">Subtotal</td>
								<td style="padding: 3px; text-align: left; width: 50%">$<?php echo number_format($subtotal, 2); ?></td>
							</tr>
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Tax</td>
								<td style="padding: 3px; text-align: left">$<?php echo number_format($tax, 2); ?></td>
							</tr>
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Total</td>
								<td style="padding: 3px; text-align: left">$<?php echo number_format($total, 2); ?></td>
							</tr>
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Amount Paid</td>
								<td style="padding: 3px; text-align: left">$<?php echo number_format($response['10'], 2); ?></td>
							</tr>
							<tr>
								<td style="font-weight: 700; padding: 3px; text-align: right">Amount Due</td>
								<td style="padding: 3px; text-align: left">$<?php echo number_format($amount_due, 2); ?></td>
							</tr>
						</table>
					</td>
				</tr>
				
			</table>
		</td>
	</tr>
	<tr>
		<td style="padding: 15px; text-align: center; font-size: 12px">Thank you for your payment.  Please save this email for your records.</td>
	</tr>
</table>
