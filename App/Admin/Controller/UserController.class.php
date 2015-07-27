<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
    
    public function _initialize(){
        if(!is_login()){
	   $this->redirect('Public/index');
	}
    }
    public function student(){
        
	//获取排序信息
	$page['current'] = $_REQUEST['page'] ? $_REQUEST['page']:1;
	$page['next_page'] = U('User/student',array('page'=>$page['current']+1));
	$page['last_page'] = U('User/student',array('page'=>$page['current']-1>0 ? $page['current']-1 : 1 ));
	
	//获取学生数据
	$student = D('Students');
	$result = $student -> field('user_id')-> limit(15) -> page($page['current']) -> select();
	
	//排列数据
	foreach($result as $key=>$val){
		$fail = $val['fail']==0 ? L('no') : L('yes');
		$state = $val['state']==0 ? L('normal') : L('abnormal');
		$blacklist = $val['blacklist']==0 ? L('no') : L('yes');
		$list[] = array(
			'real_name' => $val['real_name'],
			'user_id' => $val['userd'],
			'major' => $val['major'],
			'college' => $val['college'],
			'fail' => $fail,
			'blacklist' => $blacklist,
			'state' => $state	
			);
	}

	//传送数据
	$this->assign('list',$list);
	$this->assign('page',$page);
	//显示网页
	$this->display();
    }

    public function teacher(){
    
	//获取排列信息
	$page['current'] = $_REQUEST['page'] ? $_REQUEST['page']:1;
	$page['next_page'] = U('User/teacher',array('page'=>$page['current']+1));
	$page['last_page'] = U('User/teacher',array('page'=>$page['current']-1>0 ? $page['current']-1 : 1 ));
	

	//获取数据
	$teacher = D('Teachers');
	$res = $teacher -> field('user_id') -> limit(15) -> page($page['current']) -> select();
	foreach($res as $key=>$val){

		$blacklist = $val['blacklist']==0 ? L('no') : L('yes');
		$state = $val['state']==0 ? L('normal') : L('abnormal');
		
		$list[] = array(
			'user_id' => $val['user'],
			'real_name' => $val['real_name'],
			't_title' => $val['t_title'],
			'college' => $val['college'],
			'blacklist' => $blacklist,
			'state' => $state,
			);
	}

	//数据传输
	$this->assign('list',$list);
	$this->assign('page',$page);

	//显示页面
	$this->display();
    }


    public function tutor(){

	//获取数据排序
	$page['current'] = $_REQUEST['page'] ? $_REQUEST['page']:1;
	$page['next_page'] = U('User/tutor',array('page'=>$page['current']+1));
	$page['last_page'] = U('User/tutor',array('page'=>$page['current']-1>0 ? $page['current']-1 : 1 ));
	
	//获取数据
	$tutor = D('tutor');

    }
}
