<h2><?php echo __('Customers'); ?></h2>
<table>
  <tr>
    <th><?php echo $this->Paginator->sort('id'); ?></th>
    <th><?php echo $this->Paginator->sort('FirstName'); ?></th>
    <th><?php echo $this->Paginator->sort('LastName'); ?></th>
    <th><?php echo $this->Paginator->sort('Email'); ?></th>
     <th><?php echo $this->Paginator->sort('Phone'); ?></th>
     <th><?php echo $this->Paginator->sort('Group'); ?></th>
     <th><?php echo $this->Paginator->sort('Division'); ?></th>
  </tr>
  <?php foreach ($customers as $customer): ?>
    <tr>
      <td><?php echo $customer['Customer']['id']; ?></td>
      
      <td>
        <?php
        echo $this->Html->link($customer['Customer']['FirstName'], array('controller' => 'customers', 'action' => 'view', $customer['Customer']['id']));
        ?>
      </td>
      <td><?php
        echo $this->Html->link($customer['Customer']['LastName'], array('controller' => 'customers', 'action' => 'view', $customer['Customer']['id']));
        ?></td>
        <td><?php
        echo $this->Html->link($customer['Customer']['Email'], array('controller' => 'customers', 'action' => 'view', $customer['Customer']['id']));
        ?></td>
        <td><?php
        echo $this->Html->link($customer['Customer']['Phone'], array('controller' => 'customers', 'action' => 'view', $customer['Customer']['id']));
        ?></td>
        <td><?php
        echo $this->Html->link($customer['Customer']['Group'], array('controller' => 'customers', 'action' => 'view', $customer['Customer']['id']));
        ?></td>
        <td><?php
        echo $this->Html->link($customer['Customer']['Division'], array('controller' => 'customers', 'action' => 'view', $customer['Customer']['id']));
        ?></td>
    </tr>
 <?php endforeach; ?>
</table>
<div>
  <?php echo $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}'))); ?>
</div>
<div>
  <?php
  echo $this->Paginator->prev(__('< previous'), array(), null, array('class' => 'prev disabled'));
  echo $this->Paginator->numbers(array('separator' => ''));
  echo $this->Paginator->next(__('next >'), array(), null, array('class' => 'next disabled'));
  ?>
</div>