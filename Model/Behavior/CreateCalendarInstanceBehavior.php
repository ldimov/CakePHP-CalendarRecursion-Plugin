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
 * Creates a calendar instance for for each record created in the table which uses the behavior
 * @author Lyubomir R Dimov <ldimov@microtrain.net>
 */
class CreateCalendarInstanceBehavior extends ModelBehavior
{
    /**
     * The settings array contains the name of the columns that hold the start and end date for the 
     * table which utilizes this behavior
     * Available settings:
     *   - start string, 
     *            name of the column which holds the start date
     *   - end  string, 
     *            name of the column which holds the end date
     *   - auto boolean, 
     *            when set to true, this behavior will create a calendar instance for each record created in the 
     *            corresponding table
     *
     * @param object $model
     * @param array $setting
     */
    public function setup( $model, $settings = array() ) 
    {
        if( !isset( $this->settings[$model->alias] ) ) {
            $this->settings[$model->alias] = array();
        }
        
        if( is_array( $settings ) ) {
            $this->settings[$model->alias] = array_merge_recursive( $this->settings[$model->alias], $settings );
        }
        
        if(!isset($this->settings[$model->alias]['auto'])){
            $this->settings[$model->alias]['auto'] = false;
        }
        
    }

        
    public function afterSave($model, $created) 
    {
        if($this->settings[$model->alias]['auto'] == true){
            //get names of the columns that hold the start and 
            //end dates from the behavior's settings array
            $start = $this->settings[$model->alias]['start'];
            $end = $this->settings[$model->alias]['end'];

            $data = $model->data[$model->alias];


            //if their is no end date, sync end with start
            if(empty($data[$end])){
                $data[$end] = $data[$start];
                //$oneOff = true;
            }

            $data['dow'] = date('l', strtotime($data[$start]));

            $recursionData = array(
                'start'=>$data[$start], 
                'end'=>$data[$end],
                'dow'=>$data['dow']
            );

            return  $this->createRecursion(
                        $recursionData['start'], 
                        $recursionData['end'],
                        $recursionData['dow'],
                        $model->alias,
                        $model->id
                    );
        }
    }
        
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
    public function createRecursion($start, $end, $dow, $model, $model_id)
    {
        $start = date('Y-m-d H:i:s', strtotime($start));
        $end = date('Y-m-d H:i:s', strtotime($end));
        $daysOfWeek = $this->digitizeDOW($dow);
        
        $calendarRecursion = array(
            'CalendarRecursion' => array(
                'start' => $start,
                'end' => $end,
                'dow' => $daysOfWeek
            )
        );
        
        $calendarRecursionModel = ClassRegistry::init('CalendarRecursion');
        if($calendarRecursionModel->save($calendarRecursion)){
                        
            $calendarInstance = array('CalendarInstance' => array(
                'start_time' => $start,
                'end_time' => $end,
                'model' => $model,
                'model_id' => $model_id,
                'calendar_recursion_id' => $calendarRecursionModel->id,
                'label' => $model
            ));
            
            $calendarInstanceModel = ClassRegistry::init('CalendarInstance');
            if($calendarInstanceModel->save($calendarInstance)){
                return true;
            }else{                
                $calendarRecursionModel->delete($calendarRecursionModel->id);
                return false;
            }
            
        }else{
            return false;
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
    
}
?>
