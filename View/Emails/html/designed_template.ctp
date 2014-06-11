<?php $image_domain = !empty($image_domain) ? $image_domain : 'https://admin.undergroundshirts.com'; ?>
<table style="width: 600px; margin: auto; border-spacing: 0" cellpadding="0" cellspacing="0">
	<tr>
		<td colspan="5" cellpadding="0" cellspacing="0" style="width: 600px; height: 104px"><?php echo $this->Html->image($image_domain . '/c2/email_queue/img/header2.png', array('style' => 'display:block')); ?></td>
	</tr>
	<tr>
		<td colspan="5" style="padding: 20px"><?php echo $body; ?></td>
	</tr>
	<tr>
		<td cellpadding="0" cellspacing="0" style="width: 270px; height: 59px">
			<?php echo $this->Html->image($image_domain . '/c2/email_queue/img/email_bottom_01.png', array('style' => 'display:block')); ?>
		</td>
		<td cellpadding="0" cellspacing="0" style="width: 125px; height: 59px">
			<?php 
				$image = $this->Html->image($image_domain . '/c2/email_queue/img/email_bottom_02.png', array('style' => 'display:block')); 
				echo $this->Html->link($image, 'http://undergroundshirts.com/locations', array('escape' => false));
			?>
		</td>
		<td cellpadding="0" cellspacing="0" style="width: 20px; height: 59px">
			<?php echo $this->Html->image($image_domain . '/c2/email_queue/img/email_bottom_03.png', array('style' => 'display:block')); ?>
		</td>
		<td cellpadding="0" cellspacing="0" style="width: 96px; height: 59px">
			<?php 
				$image = $this->Html->image($image_domain . '/c2/email_queue/img/email_bottom_04.png', array('style' => 'display:block'));
				echo $this->Html->link($image, 'http://undergroundshirts.com', array('escape' => false)); 
			?>
		</td>
		<td cellpadding="0" cellspacing="0" style="width: 20px; height: 59px">
			<?php echo $this->Html->image($image_domain . '/c2/email_queue/img/email_bottom_05.png', array('style' => 'display:block')); ?>
		</td>
	</tr>
</table>

