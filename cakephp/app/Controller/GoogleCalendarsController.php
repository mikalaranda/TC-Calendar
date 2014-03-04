<?php

class GoogleCalendarsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'RequestHandler');

    public function index() {
        $this->set('google_calendars', $this->GoogleCalendar->find('all'));
    }
}
?>