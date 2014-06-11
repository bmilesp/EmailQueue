<?php 
	$element = (!empty($element))? $element : 'Emails/default'; 
	$data = (!empty($data))? $data : array(); 
	$plugin = (!isset($plugin))? $plugin : 'EmailQueue'; 
?>
<table cellpadding="0" cellspacing="0" style="font-family:'Helvetica Neue', Helvetica, Arial, Verdana, sans-serif; color:#222222;">
	<?php echo $this->element('Emails/Layout/header', array('plugin' => 'EmailQueue')); ?>
	<tr>
		<td bgcolor="#FFFFFF"  colspan="2" style="border-top: none; border-right: none; border-bottom: none; border-left: none;" >
			<?php
					echo $this->element($element, array("data"=>$data,'plugin' =>$plugin)); 
			?>		
		</td>
	</tr>
	<?php echo $this->element('Emails/Layout/footer', array('plugin' => 'EmailQueue')); ?>
</table>