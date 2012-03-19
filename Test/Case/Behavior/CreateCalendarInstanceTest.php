<?php
App::import( 'Core', array( 'AppModel', 'Model' ) );

/**
 * Article class
 *
 * @package       cake
 * @subpackage    cake.tests.cases.libs.model
 */
class Activity extends CakeTestModel {
  /**
   * name property
   *
   * @var string 'Activity'
   * @access public
   */
  public $name = 'Activity';
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
        'plugin.calendar_recursion.activity'
    );

    /**
     * Method executed before each test
     *
     * @access public
     */
    function startTest() {
            $this->CalendarRecursion =& ClassRegistry::init('CalendarRecursion');
            $this->CalendarInstance =& ClassRegistry::init('CalendarInstance');
            $this->Activity =& ClassRegistry::init('Activity');
    }
    
    public function testCreateInstance()
    {
        $activity = array(
            'Activity' => array(
                'start_date' => '2012-06-05 11:00:00',
                'end_date' => '2012-06-05 16:00:00'
            )
        );
        
        $this->Activity->save($activity);
        
        $expextedInstance = array(
            'CalendarInstance' => array(
                'start_time' => '2012-06-05 11:00:00',
                'end_time' => '2012-06-05 16:00:00',
                'model' => 'Activity',
                'model_id' => $this->Activity->id,
                'time_block' => 0,
                'label' => 'Activity',
                'model_status' => NULL,
                'status' => NULL
            )
        );
        
        $actualInstance = $this->CalendarInstance->find('first');        
        unset($actualInstance['CalendarRecursion']);
        unset($actualInstance['CalendarInstance']['id']);
        unset($actualInstance['CalendarInstance']['calendar_recursion_id']);
        unset($actualInstance['CalendarInstance']['created']);
        unset($actualInstance['CalendarInstance']['created_contact_id']);
        unset($actualInstance['CalendarInstance']['modified']);
        unset($actualInstance['CalendarInstance']['modified_contact_id']);
        
        $this->assertEqual($expextedInstance, $actualInstance);
    }
    
    public function testCreateRecursion()
    {
        $activity = array(
            'Activity' => array(
                'start_date' => '2012-06-05 11:00:00',
                'end_date' => '2012-06-05 16:00:00'
            )
        );
        
        $this->Activity->save($activity);
        
        $expextedRecursion = array(
            'CalendarRecursion' => array(
                'start' => '2012-06-05 11:00:00',
                'end' => '2012-06-05 16:00:00',
                'time_block' => 0,
                'dow' => '0100000'
            )
        );
        
        $actualRecursion = $this->CalendarRecursion->find('first');        
        unset($actualRecursion['CalendarInstance']);
        unset($actualRecursion['CalendarRecursion']['id']);
        unset($actualRecursion['CalendarRecursion']['created']);
        unset($actualRecursion['CalendarRecursion']['created_contact_id']);
        unset($actualRecursion['CalendarRecursion']['modified']);
        unset($actualRecursion['CalendarRecursion']['modified_contact_id']);
        
        $this->assertEqual($expextedRecursion, $actualRecursion);
    }


    /**
     * Method executed after each test
     *
     * @access public
     */
    function endTest() {
            unset($this->CalendarRecursion);
            unset($this->CalendarInstance);
            unset($this->Activity);
            ClassRegistry::flush();
    }
}
?>
