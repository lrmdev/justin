<h2><?php echo __('Register'); ?></h2>
<?php
echo $this->Form->create('User');
echo $this->Form->inputs();
echo $this->Form->end(__('Register'));