<div id='calendar'></div>
<?php 
    echo $this->element('event-view-modal');
    echo $this->element('event-submit-modal');
    echo $this->element('google-calendar-submit-modal');
    echo $this->element('registration-modal');
?>
<br> <button type="button" class="btn btn-default" id="google-calendar-button">Link Google Calendar</button>