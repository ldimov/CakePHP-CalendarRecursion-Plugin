<?php
/* Activity Fixture generated on: 2012-02-29 13:50:30 : 1330545030 */
class ActivityFixture extends CakeTestFixture {
    var $name = 'Activity';
    
    public $actsAs = array(
        'CalendarRecursion.CreateCalendarInstance' => array(
            'start' => 'start_date',
            'end' => 'end_date',
            'auto' => true
        ),
        'CalendarRecursion.CalendarDayDateSync' => array(
            'start' => 'start_date',
            'end' => 'end_date'
        )
    );
    
    var $fields = array(
        'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'start_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => 'Datetime on which the activity will start'),
        'end_date' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => 'Datetime on which the activity will end'),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
}