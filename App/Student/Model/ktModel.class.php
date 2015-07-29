<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class ktModel extends ViewModel{
    protected $pd = 'id';

    public $viewFields = array(
		    'kt' => array('id','s_id', 'title', 'files', 'content', 'add_time', 'end_time', 'state'),
		    'Users' => array('id' => 'uid', '_on'=>'Students.user_id=Users.id', '_type'=>'RIGHT'),
		    );
}
?>
