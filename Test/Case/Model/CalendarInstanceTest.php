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
 * Test cases for calendar instance model api
 * @author Lyubomir R Dimov <ldimov@microtrain.net>
 */
App::import('Model', 'CalendarInstance');

class CalendarInstanceTestCase extends CakeTestCase {
    public $fixtures = array('app.calendar_instance', 'app.calendar_recursion');

    function startTest() {
        $this->CalendarInstance =& ClassRegistry::init('CalendarInstance');
    }

    function endTest() {
        unset($this->CalendarInstance);
        ClassRegistry::flush();
    }


}
?>