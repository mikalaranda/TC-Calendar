<?php

class EventsController extends AppController {
	public $helpers = array('Html', 'Form', 'Session', 'Js' => array('Jquery'));
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

    public function submit() {
        if ($this->request->is('ajax')) {
            $this->autoRender = false;
            if($this->data['Event']['update_id'] == '0'){
                $this->Event->create();
                if ($this->Event->save($this->request->data)) {
                    $event = $this->Event->findById($this->Event->id)['Event'];
                    $event['update'] = false;
                    echo json_encode($event);
                }
                else 
                    $this->response->statusCode(400);
            }else{
                $event = $this->Event->findById($this->data['Event']['update_id']);
                if(!$event){
                    $this->response->statusCode(400); 
                }
                $this->Event->id = $this->data['Event']['update_id'];
                if ($this->Event->save($this->request->data)) {
                    $event = $this->Event->findById($this->Event->id)['Event'];
                    $event['update'] = true;
                    echo json_encode($event);
                }
            }
        }
    }

    public function getEvent($id = null){
        if ($this->request->is('ajax')) {   
            $this->autoRender = false;
            $event = $this->Event->findById($this->data['Edit']['hidden_id'])['Event'];
            if ($event) {
                echo json_encode($event);
            }else{
                $this->response->statusCode(400);
            }
        }
    }
}
?>