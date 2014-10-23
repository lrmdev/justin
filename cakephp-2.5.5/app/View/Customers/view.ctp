<h2><?php echo h($customer['Customer']['FirstName']);
echo ' ';
 echo h($customer['Customer']['LastName']);?></h2>

<dl>
 
  <dt><?php echo __('EMail'); ?></dt>
  <dd><?php echo $this->Html->tag('span',$customer['Customer']['Email']); ?></dd>
  <dt><?php echo __('DOB'); ?></dt>
  <dd><?php echo $this->Html->tag('span',$customer['Customer']['DOB']); ?></dd>
  <dt><?php echo __('Inches'); ?></dt>
  <dd><?php echo $this->Html->tag('span',$customer['Customer']['Inches']); ?></dd>
  <dt><?php echo __('Weight'); ?></dt>
  <dd><?php echo $this->Html->tag('span',$customer['Customer']['Weight']); ?></dd>
  <dt><?php echo __('Phone'); ?></dt>
  <dd><?php echo $this->Html->tag('span',$customer['Customer']['Phone']); ?></dd>
  <dt><?php echo __('Group'); ?></dt>
  <dd><?php echo $this->Html->tag('span',$customer['Customer']['Group']); ?></dd>
  <dt><?php echo __('Division'); ?></dt>
  <dd><?php echo $this->Html->tag('span',$customer['Customer']['Division']); ?></dd>
  <dt><?php echo __('SeasonLength'); ?></dt>
  <dd><?php echo $this->Html->tag('span',$customer['Customer']['SeasonLength']); ?></dd>
  
  
</dl>