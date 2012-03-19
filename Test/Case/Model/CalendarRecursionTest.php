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
 * Test cases for calendar recursion model api
 * @author Lyubomir R Dimov <ldimov@microtrain.net>
 */


/**
 * Model used in tests for Uuid.
 *
 */
class CalendarInstance extends CakeTestModel {
        var $name = 'CalendarInstance';
        public $actsAs = array();
} 

class CalendarRecursionTestCase extends CakeTestCase {
   /**
    * Fixtures associated with this test case
    *
    * @var array
    * @access public
    */
    public $fixtures = array(
        'plugin.calendar_recursion.calendar_recursion', 
        'plugin.calendar_recursion.calendar_instance', 
        'plugin.calendar_recursion.adaptive_activity'
    );

    /**
     * Method executed before each test
     *
     * @access public
     */
    function startTest() {
            $this->CalendarRecursion =& ClassRegistry::init('CalendarRecursion');
    }

    /**
     * Test for DigitizeDOW api call(converting days of the week to binary string)
     */
    function testDigitizeDOW()
    {
        $dow = $this->CalendarRecursion->digitizeDOW('tuesday, Thursday, monday');

        $this->assertEqual('1101000', $dow);
    }

    /**
     * Test for creating and expanding a calendar recursion 
     */
    function testCreatedRecusion()
    {
        $ids = array(12, 12, 12, 12, 12);
        
        $this->CalendarRecursion->createRecursion(
                           '02/01/2012 09:00:00','02/16/2012 11:00:00','Monday, wednesday', 'AdaptiveActivity', $ids,1);
        
        $createdData = $this->CalendarRecursion->find('first', array(
            'conditions' => array('CalendarRecursion.time_block' => 1)
        ));

        $supposedData = array(
            'CalendarRecursion' => array(
                'id' => $this->CalendarRecursion->getLastInsertId(),
                'start' => '2012-02-01 09:00:00',
                'end' => '2012-02-16 11:00:00',
                'dow' => '1010000',
                'time_block' => 1,
                'created' => $createdData['CalendarRecursion']['created'],
                'created_contact_id' => $createdData['CalendarRecursion']['created_contact_id'],
                'modified' => $createdData['CalendarRecursion']['modified'],
                'modified_contact_id' => $createdData['CalendarRecursion']['modified_contact_id'],
            ),
            'CalendarInstance' => array(
                0 => array(
                    'id' => $createdData['CalendarInstance'][0]['id'],
                    'start_time' => '2012-02-01 09:00:00',
                    'end_time' => '2012-02-01 11:00:00',
                    'model' => 'AdaptiveActivity',
                    'model_id' => '12',
                    'calendar_recursion_id' => $this->CalendarRecursion->getLastInsertId(),
                    'time_block' => '1',
                    'status' => null,
                    'model_status' => null,
                    'label' => null,
                    'created' => $createdData['CalendarInstance'][0]['created'],
                    'created_contact_id' => $createdData['CalendarInstance'][0]['created_contact_id'],
                    'modified' => $createdData['CalendarInstance'][0]['modified'],
                    'modified_contact_id' => $createdData['CalendarInstance'][0]['modified_contact_id'],
                ),

                1 => array(
                    'id' => $createdData['CalendarInstance'][1]['id'],
                    'start_time' => '2012-02-06 09:00:00',
                    'end_time' => '2012-02-06 11:00:00',
                    'model' => 'AdaptiveActivity',
                    'model_id' => '12',
                    'calendar_recursion_id' => $this->CalendarRecursion->getLastInsertId(),
                    'time_block' => '1',
                    'status' => null,
                    'model_status' => null,
                    'label' => null,
                    'created' => $createdData['CalendarInstance'][1]['created'],
                    'created_contact_id' => $createdData['CalendarInstance'][1]['created_contact_id'],
                    'modified' => $createdData['CalendarInstance'][1]['modified'],
                    'modified_contact_id' => $createdData['CalendarInstance'][1]['modified_contact_id'],
                ),

                2 => array(
                    'id' => $createdData['CalendarInstance'][2]['id'],
                    'start_time' => '2012-02-08 09:00:00',
                    'end_time' => '2012-02-08 11:00:00',
                    'model' => 'AdaptiveActivity',
                    'model_id' => '12',
                    'calendar_recursion_id' => $this->CalendarRecursion->getLastInsertId(),
                    'time_block' => '1',
                    'status' => null,
                    'model_status' => null,
                    'label' => null,
                    'created' => $createdData['CalendarInstance'][2]['created'],
                    'created_contact_id' => $createdData['CalendarInstance'][2]['created_contact_id'],
                    'modified' => $createdData['CalendarInstance'][2]['modified'],
                    'modified_contact_id' => $createdData['CalendarInstance'][2]['modified_contact_id'],
                ),

                3 => array(
                    'id' => $createdData['CalendarInstance'][3]['id'],
                    'start_time' => '2012-02-13 09:00:00',
                    'end_time' => '2012-02-13 11:00:00',
                    'model' => 'AdaptiveActivity',
                    'model_id' => '12',
                    'calendar_recursion_id' => $this->CalendarRecursion->getLastInsertId(),
                    'time_block' => '1',
                    'status' => null,
                    'model_status' => null,
                    'label' => null,
                    'created' => $createdData['CalendarInstance'][3]['created'],
                    'created_contact_id' => $createdData['CalendarInstance'][3]['created_contact_id'],
                    'modified' => $createdData['CalendarInstance'][3]['modified'],
                    'modified_contact_id' => $createdData['CalendarInstance'][3]['modified_contact_id'],
                ),

                4 => array(
                    'id' => $createdData['CalendarInstance'][4]['id'],
                    'start_time' => '2012-02-15 09:00:00',
                    'end_time' => '2012-02-15 11:00:00',
                    'model' => 'AdaptiveActivity',
                    'model_id' => '12',
                    'calendar_recursion_id' => $this->CalendarRecursion->getLastInsertId(),
                    'time_block' => '1',
                    'status' => null,
                    'model_status' => null,
                    'label' => null,
                    'created' => $createdData['CalendarInstance'][4]['created'],
                    'created_contact_id' => $createdData['CalendarInstance'][4]['created_contact_id'],
                    'modified' => $createdData['CalendarInstance'][4]['modified'],
                    'modified_contact_id' => $createdData['CalendarInstance'][4]['modified_contact_id'],
                )
            )

        );
        
        $this->assertEqual($createdData, $supposedData);

    }

    /**
     * Method executed after each test
     *
     * @access public
     */
    function endTest() {
            unset($this->CalendarRecursion);
            ClassRegistry::flush();
    }

}
?>