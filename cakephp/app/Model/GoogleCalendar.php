<?php

class GoogleCalendar extends AppModel {
	public $validate = array(
        'url' => array(
            'rule' => 'notEmpty',
            'rule' => array('url', true)
        )
    );
}

?>