<h1>Blog posts</h1>
<?php echo $this->Html->link(
    'Add Event',
    array('controller' => 'events', 'action' => 'add')
); ?>
<table>
    <tr>
        <th>Id</th>
        <th>Title</th>
        <th>Created</th>
    </tr>

    <!-- Here is where we loop through our $posts array, printing out post info -->

    <?php foreach ($events as $event): ?>
    <tr>
        <td><?php echo $event['Event']['id']; ?></td>
        <td>
            <?php echo $this->Html->link($event['Event']['title'],
array('controller' => 'events', 'action' => 'view', $event['Event']['id'])); ?>
        </td>
        <td><?php echo $event['Event']['created']; ?></td>
    </tr>
    <?php endforeach; ?>
    <?php unset($post); ?>
</table>