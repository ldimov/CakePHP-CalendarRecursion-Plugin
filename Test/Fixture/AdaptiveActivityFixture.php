<?php
/* AdaptiveActivity Fixture generated on: 2012-02-29 13:50:30 : 1330545030 */
class AdaptiveActivityFixture extends CakeTestFixture {
    var $name = 'AdaptiveActivity';
    var $fields = array(
        'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary', 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'type' => array('type' => 'string', 'null' => false, 'default' => 'misc', 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => 'The highest level bucket of activties', 'charset' => 'latin1'),
        'subtype' => array('type' => 'string', 'null' => false, 'default' => 'note', 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => 'A more descriptive version of the type', 'charset' => 'latin1'),
        'status' => array('type' => 'string', 'null' => false, 'default' => 'open', 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => 'The current status of the activity', 'charset' => 'latin1'),
        'model' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => 'The model with a direct conection to this activity', 'charset' => 'latin1'),
        'model_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
        'comment' => array('type' => 'text', 'null' => true, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'comment' => 'The chain to which this activity relates', 'charset' => 'latin1'),
        'result' => array('type' => 'string', 'null' => false, 'default' => 'open', 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => 'The result of the activity', 'charset' => 'latin1'),
        'chain' => array('type' => 'string', 'null' => false, 'default' => 'prospecting', 'length' => 100, 'collate' => 'latin1_swedish_ci', 'comment' => 'The chain to which this activity relates', 'charset' => 'latin1'),
        'start' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => 'Datetime on which the activity will start'),
        'end' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => 'Datetime on which the activity will end'),
        'completed' => array('type' => 'datetime', 'null' => true, 'default' => NULL, 'comment' => 'Datetime on which the activity was completed'),
        'completed_contact_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => 'Who completed the activity'),
        'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'Log field'),
        'created_contact_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => 'Log field'),
        'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL, 'comment' => 'Log field'),
        'modified_contact_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'comment' => 'Log field'),
        'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
        'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
    );
    
    var $records = array(
        array(
            'id' => '4f4e8186-d6d0-423e-9dbb-39d505870b28',
            'type' => 'Lorem ipsum dolor sit amet',
            'subtype' => 'Lorem ipsum dolor sit amet',
            'status' => 'Lorem ipsum dolor sit amet',
            'model' => 'Lorem ipsum dolor sit amet',
            'model_id' => 'Lorem ipsum dolor sit amet',
            'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'result' => 'Lorem ipsum dolor sit amet',
            'chain' => 'Lorem ipsum dolor sit amet',
            'start' => '2012-02-29 13:50:30',
            'end' => '2012-02-29 13:50:30',
            'completed' => '2012-02-29 13:50:30',
            'completed_contact_id' => 1,
            'created' => '2012-02-29 13:50:30',
            'created_contact_id' => 1,
            'modified' => '2012-02-29 13:50:30',
            'modified_contact_id' => 1
        ),
        
        array(
            'id' => '12',
            'type' => 'Lorem ipsum dolor sit amet',
            'subtype' => 'Lorem ipsum dolor sit amet',
            'status' => 'Lorem ipsum dolor sit amet',
            'model' => 'Lorem ipsum dolor sit amet',
            'model_id' => 'Lorem ipsum dolor sit amet',
            'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
            'result' => 'Lorem ipsum dolor sit amet',
            'chain' => 'Lorem ipsum dolor sit amet',
            'start' => '2012-02-29 13:50:30',
            'end' => '2012-02-29 13:50:30',
            'completed' => '2012-02-29 13:50:30',
            'completed_contact_id' => 1,
            'created' => '2012-02-29 13:50:30',
            'created_contact_id' => 1,
            'modified' => '2012-02-29 13:50:30',
            'modified_contact_id' => 1
        ),
    );
}