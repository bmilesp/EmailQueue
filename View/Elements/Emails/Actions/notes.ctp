<br />
<br />
<table width="630" border="0" cellspacing="0" cellpadding="0">
	<?php
		foreach($data['order'] as $key => $value){
	?>
				<tr>
					<td align="left" style="text-align:right; font-weight:bold;">
						<?php echo $key; ?>: &nbsp; 
					</td>						
					<td align="left" style="text-align:left;">
						<?php echo $value; ?>					
					</td>	
				</tr>
	<?php
		}
	?>
				<tr/><td colspan="2"><h3 style="text-align:center; margin-top:30px; text-decoration:underline;">Note Sent to You</h3></td><tr>
				<tr>
					<td align="left" colspan="2" style="margin:30px;">
						<?php 
							echo $data['message'];
						?> 
					</td>						
				</tr>
</table>