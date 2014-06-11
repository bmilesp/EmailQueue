<?php
	$loginUrl       = Router::url(array('controller' => 'users', 'action' => 'login'), true);
	$contactUrl     = Router::url(array('controller' => 'pages', 'action' => 'display', 'contact'), true);
	$appointmentUrl = Router::url(array('controller' => 'appointments', 'action' => 'view', $appointment['Appointment']['id']), true);

	// All users but us
	$otherAttendees = Set::extract("/Attendee/User/Profile[user_id!=".$user['User']['id']."]", $appointment);
	
	// Us, we could probably just use $user here and deprecate this.
	$userTo         = Set::extract("/Attendee/User/Profile[user_id=".$user['User']['id']."]", $appointment);

	// The local time for whoever we are sending this to.
	$appointmentLocalTime = CalendarDate::convertFromUTC($appointment['Appointment']['start_date'], $user['Profile']['time_zone']);
	
	// For now there is only one other person
	$otherParty = $otherAttendees[0];
?>
					<!-- START module / top head info navi -->
					<tr>
					<td bgcolor="#505050" height="0" colspan="2" >
						<table width="630" border="0" cellspacing="0" cellpadding="0" >
							<tr>
							<!-- table column with web version link -->
							<td align="left" style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 20px; color: #999999; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 30px;">
							&nbsp;
							</td>	
							<!-- table column with unsubscribe link -->
							<td align="right" style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 20px; color: #999999; padding-top: 10px; padding-right: 30px; padding-bottom: 10px; padding-left: 10px;">
							Login to Expert Insight <?php echo $this->Html->link('here', $loginUrl, array('style' => 'style="color: #0aaaad; text-decoration: none;')); ?>.
							</td>
							</tr>
						</table>
					</td>
					</tr>
					<!-- END module -->
					<!-- START module / header logo -->
					<!-- END module -->
					<!-- START module / colored spliter-->
					<!-- END module -->
					<!-- START module / wide text 570px -->
					<tr>
					<td bgcolor="#FFFFFF"  colspan="2" style="border-top: none; border-right: none; border-bottom: none; border-left: none;" >
						<table width="630" border="0" cellspacing="0" cellpadding="30" >
							<tr>
							<!-- table row with text -->
							<td width="570" align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #888888;">
							<!--here goes title --><span style="font-size: 18px; line-height: 22px; font-weight: bold; color: #18BBBE;">Your Appointment is Tomorrow</span><br/><br/>
							<!--here goes regular text --><span style="font-weight: bold; color: #646464;">Login to Expert Insight tomorrow at <?php echo $appointmentLocalTime; ?> to begin your appointment with <?php echo $otherParty['Profile']['full_name'] ?>.</span><br/><br/>
							Get the most out of your appointment by making sure you are on a high speed internet connection. If possible, avoid a wireless connection. If you want to check your bandwidth, go on Google and search "bandwidth test" or you can use one that we like on <a href="http://bandwidth.com/tools/speedTest/" title="" target="_blank" style="color: #0aaaad; text-decoration: none;">Bandwidth.com</a>. Your minimum UPLOAD speed should be CONSISTENTLY above 512kbps to avoid quality problems and closer to 1Mbps for good quality.							</td>
							</tr>
						</table>
					</td>
					</tr>
					<!-- END module -->
					<!-- START module / wide list 570px-->
										<tr>
										<td bgcolor="#FFFFFF" colspan="2" style="border-top: none; border-right: none; border-bottom: 1px solid #E1E1DC; border-left: none;" >
											<table width="630" border="0" cellspacing="0" cellpadding="30">
												<tr>
												<!-- table row with list style table-->
												<td width="570" align="left" valign="top">
													<table width="570" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #646464;">
														<!-- table row with title of table--><tr><td height="30" align="left" valign="middle" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: bold; line-height: 20px; color: #646464;border-bottom: 1px dotted #D3D3CE;">We thought you might find these links useful:</td></tr>
														<tr><td height="30" align="left" valign="middle" style="border-bottom: 1px dotted #D3D3CE;">&#8226; 
															<a href="<?php echo $appointmentUrl ?>" title="" target="_blank" style="color: #0aaaad; text-decoration: none;">View this appointment</a>
														</td></tr>
														<tr><td height="30" align="left" valign="middle" style="border-bottom: 1px dotted #D3D3CE;">&#8226; 
															<a href="http://getsatisfaction.com/expert_insight" title="" target="_blank" style="color: #0aaaad; text-decoration: none;">Review our FAQ</a>
														</td></tr>
														<tr><td height="30" align="left" valign="middle" style="border-bottom: 1px dotted #D3D3CE;">&#8226; 
															<a href="<?php echo $contactUrl ?>" title="" target="_blank" style="color: #0aaaad; text-decoration: none;">Contact Us</a>
														</td></tr>
													</table>
												</td>
												</tr>
											</table>
										</td>
										</tr>
					<!-- END module -->
					<!-- START module / footer -->
					<tr>
					<td colspan="2">
						<table width="630" border="0" cellspacing="0" cellpadding="30">
							<tr>
							<!-- table column with logo image -->
							<td align="left" valign="top">
								&nbsp;
							</td>
							<!-- table column with contact data -->
							<td align="right" valign="top" style="margin:0px; padding: 30px; font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #888888;">
							<span style="font-weight: bold; color: #646464;">Expert Insight, LLC</span><br/>
							175 SW 7th St, Miami, FL 33130<br/>
							<a href="" title="" target="_blank" style="color: #0aaaad; text-decoration: none;">contactus@expertinsight.com</a> / <a href="" title="" target="_blank" style="color: #0aaaad; text-decoration: none;">www.expertinsight.com</a>
							</td>
							</tr>
						</table>
					</td>
					</tr>
					<!-- END module -->