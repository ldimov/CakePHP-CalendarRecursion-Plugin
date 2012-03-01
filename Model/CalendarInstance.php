<?php
/**
 * PHP 5.3
 *
 * MicroTrain Technologies (tm) : MicroTrain Technologies (https://www.microtrain.com)
 * Copyright 2009-2011, MicroTrain Technologies (https://www.microtrain.com)
 *
 * @copyright     Copyright 2009-2011, MicroTrain Technologies (https://www.microtrain.com)
 * @link          https://www.microtrain.com MicroTrain Technologies(tm)
 */

/**
 * Handles calendar instances data
 * @author Lyubomir R Dimov <ldimov@microtrain.net>
 */

class CalendarInstance extends AppModel {
    
    /**
     * @var string
     * @access public 
     */
    public $name = 'CalendarInstance';

    /**
     * @var array
     * @access public 
     */
    public $actsAs = array(
        'Log',
        'CalendarRecursion.CalendarDayDateSync' => array(
            'start' => 'start_time',
            'end' => 'end_time'
        )
    );

    /**
     * @var array
     * @access public 
     */
    public $belongsTo = array(
        'CalendarRecursion' => array(
            'className' => 'CalendarRecursion',
            'foreignKey' => 'calendar_recursion_id'
        )
    );
    
}
?>