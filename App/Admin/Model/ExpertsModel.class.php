<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class TeachersModel extends ViewModel{
    protected $pd = 'id';

    public $viewFields = array(
		    'Users' => array('id','user', 'last_ip', 'last_time', 'role', 'state'),
		    'Teachers' => array('id' => 'uid', '_on'=>'Users.id=Teachers.user_id', '_type'=>'RIGHT'),
		    );
}
?>
