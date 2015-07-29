<?php
namespace Admin\Model;
use Think\Model\ViewModel;
class TeachersModel extends ViewModel{
    protected $pd = 'id';

    public $viewFields = array(
		    'Expert_groups' => array('id','name', 'content', 'add_time', 'state'),
		    'Experts' => array('id' => 'uid', '_on'=>'Expert_groups.id=Experts.e_id', '_type'=>'RIGHT'),
		    'Teachers' => array('id' => 'tid', 't_id' => 'teacher_id', '_on' => 'Experts.t_id = Teachers.t_id', '_type' => 'RIGHT' ),
		    );
}
?>
