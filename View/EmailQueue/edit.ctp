<?php $this->set('title_for_layout', __('Edit Email', true)); ?>
<h2><?php echo __('Edit Email');?></h2>
<?php echo $this->Form->create('EmailQueue', array(
	'url' => array('plugin'=>'email_queue', 'controller' => 'email_queue','action' => 'preview',$id),
	'target' => '_blank',
	'class' => 'email-fiddle-form')); ?>
	<fieldset class="information">
		<?php echo $this->Form->input('template', array(
			'type' => 'textarea',
			'value' => $template,
			'rows' => 30)); ?>
		<?php echo $this->Form->input('vars', array(
			'type' => 'textarea',
			'value' => $emailQueue['EmailQueue']['template_vars'])); ?>
		<?php echo $this->Form->submit('Preview', array('class' => 'preview-fiddle')); ?>
	</fieldset> 
<?php echo $this->Form->end(); ?>
