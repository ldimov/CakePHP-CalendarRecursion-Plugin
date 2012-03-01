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
 * Syncs the date fields between calendar_instances and associated table. If the start or end dates changes in one table 
 * the behavior changes the date for the corresponding row in the corresponding table
 * @author Lyubomir R Dimov <ldimov@microtrain.net>
 */
class CalendarDayDateSyncBehavior extends ModelBehavior
{
    /**
     * The settings array contains the name of the columns that hold the start and end date for the instance in the 
     * table associted with calendar_instances
     * Available settings:
     *   - start string, 
     *            name of the coliumn which holds the start date
     *   - end  string, 
     *            name of the coliumn which holds the end date
     *
     * @param object $model
     * @param array $setting
     */
    public function setup( $model, $settings = array() ) {
        if( !isset( $this->settings[$model->alias] ) ) {
            $this->settings[$model->alias] = array();
        }
        
        if( is_array( $settings ) ) {
            $this->settings[$model->alias] = array_merge_recursive( $this->settings[$model->alias], $settings );
        }
        
      }
    
    public function afterSave($model, $created) {
        
        //we are not sure if we will need to perform an additional save at this point
        $save = false;
        
        //check which model we are dealing with
        if($model->alias == 'CalendarInstance'){
            //check if start_time or end_time were set in the data array
            if($model->data[$model->alias]['start_time'] || $model->data[$model->alias]['end_time']){
                
                //initiate the associates model and retrieve the corresponding row of data
                $associatedEntityModel = ClassRegistry::init($model->data[$model->alias]['model']);
                $associatedEntity = $associatedEntityModel->find('first', array(
                    'conditions' => array(
                        $model->data[$model->alias]['model'].'.id' => $model->data[$model->alias]['model_id']
                    ),
                    'contain' => array()
                ));
                
                //if(!empty($associatedEntity)){
                    //get the names of the columns the hold the start and end dates in associeated model (this only 
                    //works if the associted model actsAs this behavior with the propper settings) 
                    $start = $associatedEntityModel->actsAs['CalendarDayDateSync']['start'];
                    $end = $associatedEntityModel->actsAs['CalendarDayDateSync']['end'];
                    $modelAlias = $model->data[$model->alias]['model'];

                    //check if start_time is present in the data array and if it's corresponding value in the associated 
                    //table is different
                    if($model->data[$model->alias]['start_time']){                    
                        if($associatedEntity[$modelAlias][$start] != $model->data[$model->alias]['start_time']){
                            $associatedEntity[$modelAlias][$start] = $model->data[$model->alias]['start_time'];
                            //if the corresponding value in the associated table is different an additional save 
                            //operation needs to be performed using the associated model
                            $save = true;
                        }
                    }

                    if($model->data[$model->alias]['end_time']){
                        if($associatedEntity[$modelAlias][$end] != $model->data[$model->alias]['end_time']){
                            $associatedEntity[$modelAlias][$end] = $model->data[$model->alias]['end_time'];
                            $save = true;
                        }
                    }

                    if($save){
                        $associatedEntityModel->save($associatedEntity);
                    }
                //}
            }
        }else{
            //if we are not dealing with the CalendarInstances model get names of the columns that hold the start and 
            //end dates from the behavior's setiing array
            $start = $this->settings[$model->alias]['start'];
            $end = $this->settings[$model->alias]['end'];
            
            //check if either of those fields is passed in the data array
            if($model->data[$model->alias][$start] || $model->data[$model->alias][$end]){
                
                //initiate the CalendarInstance model and retrive the corresponding row of data
                $calendarInstanceModel = ClassRegistry::init('CalendarInstance');
                $calendarInstance = $calendarInstanceModel->find('first', array(
                    'conditions' => array(
                        'CalendarInstance.model_id' => $model->id,
                        'CalendarInstance.model' => $model->alias
                    ),
                    'contain' => array()
                ));

                //check if start date is in the data array and if it is different from the date in the corresponding 
                //CalendarInstance row of data
                if($model->data[$model->alias][$start]){
                    if($calendarInstance['CalendarInstance']['start_time'] != $model->data[$model->alias][$start]){
                        $calendarInstance['CalendarInstance']['start_time'] = $model->data[$model->alias][$start];
                        //if the dates differ a save operation will need to be performed
                        $save = true;
                    }
                }

                if($model->data[$model->alias][$end]){
                    if($calendarInstance['CalendarInstance']['end_time'] != $model->data[$model->alias][$end]){
                        $calendarInstance['CalendarInstance']['end_time'] = $model->data[$model->alias][$end];
                        $save = true;
                    }
                }

                //check if we need to do a save
                if($save){
                    $calendarInstanceModel->save($calendarInstance);
                }
            }
        }
        
    }
}
?>
