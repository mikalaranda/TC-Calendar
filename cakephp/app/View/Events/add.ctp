<h1>Add Event</h1>
<?php
echo $this->Form->create('Event');
echo $this->Form->input('title');
echo $this->Form->input('start');
echo $this->Form->input('end');
echo $this->Form->input('allDay');
echo $this->Form->input('url');
echo $this->Form->end('Save Event');
?>