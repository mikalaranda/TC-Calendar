<?php

class Event extends AppModel {
	public $validate = array(
        'title' => array(
            'rule' => 'notEmpty'
        ),
        'start' => array(
            'rule' => 'notEmpty'
        )
    );
}

?>