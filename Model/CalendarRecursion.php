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
 * Handles calendar recursion data
 * @author Lyubomir R Dimov <ldimov@microtrain.net>
 */
class CalendarRecursion extends AppModel {
    
    /**
     * @var string
     * @access public 
     */
    public $name = 'CalendarRecursion';
    
    /**
     * @var array
     * @access public 
     */
    public $actsAs = array('Log');
    
    /**
     * @var array
     * @access public 
     */
    public $hasMany = array(
        'CalendarInstance' => array(
            'className' => 'CalendarInstance',
            'foreignKey' => 'calendar_recursion_id',
            'dependent' => false
        )
    );
    
    /**
     * Saves calendar recursion data and makes the function which expands that data into calendar instances
     * @param string $start
     * @param string $end
     * @param string $dow
     * @param int $timeBlock
     * @param sting $model
     * @param sting $model_id
     * @return boolean 
     */
    public function createRecursion($start, $end, $dow, $model, $model_ids, $timeBlock = 0)
    {
        $start = date('Y-m-d H:i:s', strtotime($start));
        $end = date('Y-m-d H:i:s', strtotime($end));
        $daysOfWeek = $this->digitizeDOW($dow);
        
        $calendarRecursion = array(
            'CalendarRecursion' => array(
                'start' => $start,
                'end' => $end,
                'dow' => $daysOfWeek,
                'time_block' => $timeBlock
            )
        );
        
        if($this->save($calendarRecursion)){
            $calendarInstances = $this->expandCalendarRecursion($start, $end, $dow);
            
            if($this->saveExpandedRecursion($calendarInstances, $this->id, $model, $model_ids, $timeBlock)){
                return true;
            }else{
                $this->delete($this->id);
                return false;
            }
            
        }
    }
    
    /**
     * Takes a string of week days, separated by comma and converts it into binary representation of a week
     * @param string $dow
     * @return string 
     */
    public function digitizeDOW($dow)
    {
        $daysOfTheWeek = '0000000';
        $dow = explode(',', $dow);
        
        foreach($dow as $day){
            $dayNumber = date('N', strtotime($day));
            $daysOfTheWeek = substr_replace($daysOfTheWeek, '1', $dayNumber-1, 1);
        }
        
        return $daysOfTheWeek;
    }
    
    /**
     * Creates calendar instances from previously saved calendar recursion data
     * @param string $start
     * @param string $end
     * @param string $dow
     * @return boolean 
     */
    public function expandCalendarRecursion($start, $end, $dow)
    {
        $dow = $this->digitizeDOW($dow);
        $daysOfTheWeek = array();
        //we convert the digital day of the week string to an array where each day is an entry
        for ($i = 0; $i<strlen($dow); $i++)  {
            $character = substr($dow, $i,1);
            
            if($character == '1'){
                array_push($daysOfTheWeek, ($i+1));
            }
        }  
        
        //we need to seaprate the date and time since a calendar instance will always start and end at the same time but
        //it will not be on the same date
        $start_date = date('Ymd', strtotime($start));
        $end_date = date('Ymd', strtotime($end));
        $start_time = date('H:i:s', strtotime($start));
        $end_time = date('H:i:s', strtotime($end));
        
        $calendarInstances = array();
        
        //we loop through all date between the start and end date and when a date falls on a day which is in 
        //daysOfTheWeek array we create a calendar instance for that day
        for($i = $start_date; $i <= $end_date; $i = date('Ymd', strtotime($i.'+1 Day'))){
            if(in_array( date('N', strtotime($i)), $daysOfTheWeek) ){
                $calendarInstance = array(
                    'CalendarInstance' => array(
                        'start_time' => date('Y-m-d H:i:s', strtotime($i.' '.$start_time)),
                        'end_time' => date('Y-m-d H:i:s', strtotime($i.' '.$end_time))
                    )
                );
                array_push($calendarInstances, $calendarInstance);
            }
        }
        
        return $calendarInstances;
    }
    
    /**
     * Takes a calendar instances array, adds calendar recursion id, model, model id and timeblock and save the calendar
     * instances
     * @param type $calendarInstances
     * @param type $calendar_recursion_id
     * @param type $model
     * @param type $model_id
     * @param type $timeBlock
     * @return type 
     */
    public function saveExpandedRecursion($calendarInstances, $calendar_recursion_id, $model, $model_ids, $timeBlock)
    {
        $count = 0;
        foreach ($calendarInstances as &$calendarInstance){
            $calendarInstance['CalendarInstance']['model'] = $model;
            $calendarInstance['CalendarInstance']['model_id'] = $model_ids[$count];
            $calendarInstance['CalendarInstance']['time_block'] = $timeBlock;
            $calendarInstance['CalendarInstance']['calendar_recursion_id'] = $calendar_recursion_id;
            $count++;
        }
        
        return $this->CalendarInstance->saveAll($calendarInstances);
    }

}
?>