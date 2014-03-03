<?php

class EventsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session');
    public $components = array('Session', 'RequestHandler');

    public function index() {
        $this->set('events', $this->Event->find('all'));
    }

    public function view($id = null) {
        if (!$id) {
            throw new NotFoundException(__('Invalid event'));
        }

        $event = $this->Event->findById($id);
        if (!$event) {
            throw new NotFoundException(__('Invalid event'));
        }
        $this->set('event', $event);
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Event->create();
            if ($this->Event->save($this->request->data)) {
                $this->Session->setFlash(__('Your event has been saved.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(__('Unable to add your event.'));
        }
    }
}
?>