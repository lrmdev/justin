<h2><?php echo __('Login'); ?></h2>
<?php
echo $this->Session->flash('auth');
echo $this->Form->create('User');
echo $this->Form->inputs(array(
  'username',
  'password',
  'legend' => __('Login, please')
));
echo $this->Form->end(__('Sign In'));