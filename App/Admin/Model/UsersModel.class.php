<?php
namespace Admin\Model;
use Think\Model\RelationModel;
class UsersModel extends RelationModel{
    protected $fields = array('id', 'user_id', 'password', 'last_ip', 'last_time', 'role');
    protected $pd = 'id';

    protected $_link = array(
		    
		    'students' => array(
			    'mapping_type' => self::HAS_ONE
			    'mapping_name' => 'User',
			    'foreign_key' => 'user_id',
			    'class_name' => 'students',
			    ),
		    );
}
?>
