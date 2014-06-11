<?php $this->set('title_for_layout', __('Email Queue', true)); ?>
<div class="emailQueues index">
	<h2><?php echo __('Email Queue');?></h2>
	<?php echo $this->Form->create('EmailQueue'); ?>
		<?php echo $this->Form->input('EmailQueue.to'); ?>
		<?php echo $this->Form->input('EmailQueue.template'); ?>
		<?php echo $this->Form->submit('Filter'); ?>
	<?php echo $this->Form->end(); ?>
	<br /> 
	<table cellpadding="0" cellspacing="0" class=" index table">
	<tr class="header">
		<th>Subject</th>
		<th><?php echo $this->Paginator->sort('Template', 'template');?></th>
		<th><?php echo $this->Paginator->sort('To', 'to');?></th>
		<th><?php echo $this->Paginator->sort('Sent At', 'send_at');?></th>
		<th><?php echo $this->Paginator->sort('Created', 'created');?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php $i = 0; foreach ($emailQueues as $email) : ?>
		<tr<?php if ($i++ % 2 == 0) echo ' class="even"' ;?>>
			<td><?php echo (!empty($email['EmailQueue']['template_vars']['subject'])) ? $email['EmailQueue']['template_vars']['subject'] : $email['EmailQueue']['template']; ?></td>
			<td><?php echo $email['EmailQueue']['template']; ?></td>
			<td><?php echo $email['EmailQueue']['to']; ?></td>
			<td><?php echo $this->Time->format('Y-m-d', $email['EmailQueue']['send_at']); ?></td>
			<td><?php echo $this->Time->format('Y-m-d', $email['EmailQueue']['created']); ?></td>
			<td class="actions">
				<?php echo $this->element('layout/view/toolbar', array(
					'display_field'=>'id',
					'plugin' => 'email_queue',  
					'data'=> $email['EmailQueue'],
					'singularHumanName'=>'Queued Email',
					'pluralHumanName'=>'Queued Emails',
					'show_add'=>false,
					'show_list'=>false,
					'mysql'=>true,
				   )); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
	<div class="paging">
	<?php
		echo $this->Paginator->prev('< ' . __('previous'), array('url' => array('plugin' => 'email_queue', )), null, array('plugin' => 'email_queue', 'class' => 'prev disabled'));
		echo $this->Paginator->numbers(array('separator' => ''));
		echo $this->Paginator->next(__('next') . ' >', array('plugin' => 'email_queue', ), null, array('plugin' => 'email_queue', 'class' => 'next disabled'));
	?>
	</div>
</div>


