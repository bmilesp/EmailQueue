<?php $resetLink = Router::url(array('admin' => false, 'plugin' => 'users', 'controller' => 'users', 'action' => 'reset_password', $token), true); ?>

<!-- START module / wide text 570px -->
					<tr>
					<td bgcolor="#FFFFFF" colspan="2" style="border-top: none; border-right: none; border-bottom: 1px solid #E1E1DC; border-left: none;" >
						<table width="630" border="0" cellspacing="0" cellpadding="30" >
							<tr>
							<!-- table row with text -->
							<td width="570" align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #999999;">
							<!--here goes title --><span style="font-size: 18px; line-height: 22px; font-weight: bold; color: #18BBBE;">Reset Your Password</span><br/><br/>
							<!--here goes subtitle -->
							<span style="font-weight: bold; color: #646464;"><a href="<?php echo $resetLink; ?>" title="" target="_blank" style="color: #0aaaad; text-decoration: none;">Click here</a> to reset your password.</span><br/>
							<!--here goes regular text -->For security reasons you must reset your password from the email address we have stored for your account.<br/>
							</td>
							</tr>
						</table>
					</td>
					</tr>
<!-- END module -->
