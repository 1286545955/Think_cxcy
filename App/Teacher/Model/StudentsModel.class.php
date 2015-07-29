<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class StudentsModel extends ViewModel{
    protected $pd = 'id';

    public $viewFields = array(
		    'Users' => array('id','user', 'last_ip', 'last_time', 'role', 'state'),
		    'Students' => array('id' => 'uid', '_on'=>'Users.id=Students.user_id', '_type'=>'RIGHT'),
		    );
}
?>
