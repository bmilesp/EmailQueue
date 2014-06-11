<?php
$charity = 'None';

if (!empty($appointment['Event']['Calendar']['User']['CharityOrganization'])) {
	$charity = $appointment['Event']['Calendar']['User']['CharityOrganization']['name'];
}

?>
				
					<tr>
					<td bgcolor="#505050" height="0" colspan="2" >
						<table width="630" border="0" cellspacing="0" cellpadding="0" >
							<tr>
							<td align="left" style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 20px; color: #999999; padding-top: 10px; padding-right: 10px; padding-bottom: 10px; padding-left: 30px;">
							&nbsp;
							</td>	
							<td align="right" style="font-family: Arial,Helvetica,sans-serif; font-size: 11px; line-height: 20px; color: #999999; padding-top: 10px; padding-right: 30px; padding-bottom: 10px; padding-left: 10px;">
							Login to Expert Insight
							<?php
								echo $this->Html->link(
									'here',
									$this->Html->url($loginUrl, true),
									array('style' => 'color: #0aaaad; text-decoration: none;')
								);
							?>
							</td>
							</tr>
						</table>
					</td>
					</tr>
					<tr>
					<td bgcolor="#FFFFFF"  colspan="2" style="border-top: none; border-right: none; border-bottom: none; border-left: none;" >
						<table width="630" border="0" cellspacing="0" cellpadding="30" >
							<tr>
							<td width="570" align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #888888;">
							<span style="font-size: 18px; line-height: 22px; font-weight: bold; color: #18BBBE;">Request For a New Appointment</span><br/><br/>
							<span style="font-weight: bold; color: #646464;">Verify the date and time, then confirm you want to participate in this appointment.</span>
							</td>
							</tr>
						</table>
					</td>
					</tr>
					<tr>
					<td bgcolor="#FFFFFF" colspan="2" style="border-top: none; border-right: none; border-bottom: none; border-left: none;">
						<table width="630" border="0" cellspacing="0" cellpadding="30">
							<tr>
							<td width="570" align="left" valign="top" >
								<table width="570" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #999999;">
									<tr>
									<td height="50" align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 18px; line-height: 22px; font-weight: bold; color: #646464;">Details</td>
									</tr>
									<tr>
									<td colspan="5" height="30" align="left" valign="top" style="font-weight: bold; color: #646464;">User summary: <?php echo $appointment['Event']['Appointment']['summary']; ?></td>
									</tr>
									<tr>
									<td height="30" width="170" align="left" valign="middle" style="font-weight: bold; line-height: 22px; text-align: left; color: #18BBBE; border-bottom: 1px dotted #D3D3CE;">Date</td>
									<td height="30" width="100" align="left" valign="middle" style="font-weight: bold; line-height: 22px; text-align: left; color: #18BBBE; border-bottom: 1px dotted #D3D3CE;">Time</td>
									<td height="30" width="100" align="center" valign="middle" style="font-weight: bold; line-height: 22px; text-align: center; color: #18BBBE; border-bottom: 1px dotted #D3D3CE;">With</td>
									<td height="30" width="100" align="right" valign="middle" style="font-weight: bold; line-height: 22px; text-align: right; color: #18BBBE; border-bottom: 1px dotted #D3D3CE;">Charity Donation</td>
									<td height="30" width="100" align="right" valign="middle" style="font-weight: bold; line-height: 22px; text-align: right; color: #18BBBE; border-bottom: 1px dotted #D3D3CE;">Your Fee</td>
									</tr>
									<tr>
									<td height="30" width="170" align="left" valign="middle" style="text-align: left; border-bottom: 1px dotted #D3D3CE;"><?php echo $this->Time->format('F jS, Y', $expertAppointmentTime); ?></td>
									<td height="30" width="100" align="left" valign="middle" style="text-align: left; border-bottom: 1px dotted #D3D3CE;"><?php echo $this->Time->format('g:iA', $expertAppointmentTime); ?></td>
									<td height="30" width="100" align="center" valign="middle" style="text-align: center; border-bottom: 1px dotted #D3D3CE;"><?php echo $requester['Profile']['full_name']; ?></td>
									<td height="30" width="100" align="right" valign="middle" style="text-align: right; border-bottom: 1px dotted #D3D3CE;"><?php echo $charity; ?></td>
									<td height="30" width="100" align="right" valign="middle" style="text-align: right; border-bottom: 1px dotted #D3D3CE;"><?php echo $this->Number->currency($expert['ExpertProfile']['rate']); ?></td>
									</tr>
									<tr>
									<td height="30" width="170" align="left" valign="middle" style="text-align: left;"></td>
									<td height="30" width="100" align="left" valign="middle" style="text-align: left;"></td>
									<td height="30" width="100" align="center" valign="middle" style="text-align: center;"></td>
									<td height="30" width="100" align="left" valign="middle" style="color: #646464; font-weight: bold; text-align: left;">Total:</td>
									<td height="30" width="100" align="right" valign="middle" style="color: #646464; font-weight: bold; text-align: right;"><?php echo $this->Number->currency($expert['ExpertProfile']['rate']); ?></td>
									</tr>
								</table>
							</td>
							</tr>
							</table>
					</td>
					</tr>
					<tr>
					<td bgcolor="#FFFFFF" colspan="2" style="border-top: none; border-right: none; border-bottom: 1px solid #E1E1DC; border-left: none;">
						<table width="630" border="0" style="border-spacing: 30px 15px;" cellpadding="0">
							<tr>
							<td width="240" align="left" valign="top" >
								<table width="240" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #646464;">
									<tr><td height="30" align="left" valign="middle"  style="font-family: Arial,Helvetica,sans-serif; font-weight: bold; font-size: 12px; line-height: 20px; color: #646464; border-bottom: 1px dotted #D3D3CE;">I would like to...</td></tr>
									<tr><td height="30" align="left" valign="middle" style="border-bottom: 1px dotted #D3D3CE;">&#8226;
										<?php
											echo $this->Html->link('Confirm this appointment time', $this->Html->url($confirmUrl, true), array('style' => 'color: #0AAAAD; text-decoration: none;'));
										?>
									</td></tr>
									<tr><td height="30" align="left" valign="middle" style="border-bottom: 1px dotted #D3D3CE;">&#8226;
										<?php
											echo $this->Html->link('Let the user know I cannot make it', $this->Html->url($deferUrl, true), array('style' => 'color: #0AAAAD; text-decoration: none;'));
										?>
									</td></tr>
								</table>
							</td>
							<td width="310" align="left" valign="top" >
								<table width="310" border="0" cellspacing="0" cellpadding="0" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #999999;">
									<tr><td height="30" align="left" valign="middle"  style="font-family: Arial,Helvetica,sans-serif; font-weight: bold; font-size: 12px; line-height: 20px; color: #646464; border-bottom: 1px dotted #D3D3CE;">What will happen?</td></tr>
									<tr><td height="30" align="left" valign="middle" style="border-bottom: 1px dotted #D3D3CE;">The appointment will be confirmed for both parties</td></tr>
									<tr><td height="30" align="left" valign="middle" style="border-bottom: 1px dotted #D3D3CE;">You can select a reason why and proceed accordingly</td></tr>
								</table>
							</td>
							</tr>
						</table>
					</td>
					</tr>
                                        <?php echo $this->element('email/html/layout/footer'); ?>
