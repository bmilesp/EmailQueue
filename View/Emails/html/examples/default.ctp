<?php
	$url = Router::url(array('admin' => false, 'plugin' => null, 'controller' => 'users', 'action' => 'index'), true);
	$loginUrl = Router::url(array('controller' => 'users', 'action' => 'login'), true);
	$contactUrl = Router::url(array('controller' => 'pages', 'action' => 'display', 'contact'), true);
?>
					<!-- START module / top head info navi -->
<table cellpadding="0" cellspacing="0">
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
			Login to Underground Shirts <a href="<?php echo $loginUrl ?>" title="" target="_blank" style="color: #0aaaad; text-decoration: none;">here</a>
			</td>
			</tr>
		</table>
	</td>
	</tr>
	<tr>
	<td bgcolor="#FFFFFF"  colspan="2" style="border-top: none; border-right: none; border-bottom: none; border-left: none;" >
		<table width="630" border="0" cellspacing="0" cellpadding="30" >
			<tr>
			<!-- table row with text -->
			<td width="570" align="left" valign="top" style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; line-height: 20px; color: #888888;">
			<!--here goes title --><span style="font-size: 18px; line-height: 22px; font-weight: bold; color: #18BBBE;">Activate Your Account</span><br/><br/>
			<!--here goes regular text --><span style="font-weight: bold; color: #646464;"><a href="<?php echo $url; ?>" title="" target="_blank" style="color: #0aaaad; text-decoration: none;">Click here</a> to activate your account.</span><br/><br/>
			Welcome To Company.
			</td>
			</tr>
		</table>
	</td>
	</tr>
	<tr>
	
	</tr>
	<!-- END module -->
	<?php echo $this->element('Emails/Layout/footer', array('plugin' => 'EmailQueue')); ?>
</table>