<?php

class GoogleCalendarsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'RequestHandler');

    public function index() {
        $this->set('google_calendars', $this->GoogleCalendar->find('all'));
    }

    public function submit(){
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            $this->GoogleCalendar->create();
            if ($this->GoogleCalendar->save($this->request->data)) {
                $gc = $this->GoogleCalendar->findById($this->GoogleCalendar->id)['GoogleCalendar'];
                echo json_encode($gc);
            }
            else 
                $this->response->statusCode(400);
        }
    }
}
?>