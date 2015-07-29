<<<<<<< HEAD
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
=======
<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends Controller {
    
    public function _initialize(){
        if(!is_login()){
	   $this->redirect('Public/index');
	}
    }
    
    /*******学生列表页面*********/
    public function student(){
        
	//获取排序信息
	$page['current'] = $_REQUEST['page'] ? $_REQUEST['page']:1;
	
	if(I('department') > 0)
		$where['department'] = I('department');
	else
		$where = array();
	//获取学生数据
	$student = D('Students');
	$result = $student -> field('user_id')-> limit(15) -> page($page['current']) -> where($where) -> select();
	
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


	//获取学院信息
	$res = M('department') -> field('id, name') -> select();
        foreach($res as $k=>$v){
              $college[] = array(
                        'url' => U('User/teacher',array('page'=>$page['current'], 'department'=> $v['id'])),
                        'name' => $v['name'],
                        );
        }

	//翻页信息
	$page['next_page'] = U('User/student',array('page'=>$page['current']+1, 'department'=>$where['department']));
	$page['last_page'] = U('User/student',array('page'=>$page['current']-1>0 ? $page['current']-1 : 1 , 'department' => $where['department']));

	//传送数据
	$this->assign('list',$list);
	$this->assign('page',$page);
	//显示网页
	$this->display();
    }

    /********添加/编辑学生页面*****************/
    public function addStudent(){
	    $user_id = I('user_id')>0 ? I('user_id') : '';
	    $ope = I('ope') != '' ? I('ope') : 'add';
	    if($ope == 'add'){
		    $this -> assign('ope','add');
	    }else if($ope == 'edit'){
		    //获取用户信息
		    $res = D('students') -> field('user_id') -> find();
		    
		    //传输数据
		    $this -> assign('data', $res);
		    $this -> assign('ope', 'edit');
	    }else{
		    //非法操作
		    $this -> error(L('illeage_operation'));
	    }

	    //获取学院信息
	    $res = M('department') -> field('d_id, name') -> select();

	    $this -> assign('college', $res);
	    
	    $this -> display();

    }

    /********插入学生数据****************************/
    public function insertStudent(){
    
    }

    /********更新学生数据***********************/
    public function updateStudent(){
    }

    /********教师列表页面*******************************/
    public function teacher(){
    
	//获取排列信息
	$page['current'] = $_REQUEST['page']>0 ? $_REQUEST['page']:1;
	
	if(I('department') > 0)
		$where['department'] = I('department');
	else
		$where = array();

	//获取教师数据
	$teacher = D('Teachers');
	$res = $teacher -> field('user_id') -> limit(15) -> page($page['current'])-> where($where) -> select();
	//p($res);die();
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

	//获取学院数据
	$res = M('department') -> field('id, name') -> select();
	foreach($res as $k=>$v){
		$college[] = array(
				'url' => U('User/teacher',array('page'=>$page['current'], 'department'=> $v['id'])),
				'name' => $v['name'],
				);
	}

	$page['next_page'] = U('User/teacher',array('page'=>$page['current']+1, 'department'=>$where['department']));
	$page['last_page'] = U('User/teacher',array('page'=>$page['current']-1>0 ? $page['current']-1 : 1 , 'department' => $where['department']));
	//数据传输
	$this->assign('list',$list);
	$this->assign('college',$college);
	$this->assign('page',$page);

	//显示页面
	$this->display();
    }

    /***********新建教师*******************/
    public function addTeacher(){
	
	//筛选数据
	$data['user'] = $_REQUEST['user_id'] > 0 ? $_REQUEST['user_id'] : '';
	$ope = trim(I('ope')) != '' ? I('ope') : '';
	
	//显示数据
	if($ope == 'edit'){
		//获取数据
		$res = D('teachers') -> field('user_id') -> where($data) -> find();
		
		//传入数据
		$this->assign('data', $res);
		$this->assign('ope', 'edit');
	}else{
		$this->assign('ope','add');
	}

	//获取学院信息
	$res = M('department') -> field('d_id, name') -> select();
	$this->assign('college',$res);

	$this->display();
    
    }

    /*********插入教师数据*************/
    public function insertTeacher(){
   	 
  		
	//初始化数据库
	$user = M('users');
	$teachers = M('teachers');
	
	//判断用户id是否存在
	$data['user'] = trim(I('user'));
	if($res = $user->where($data)->find())
		$this->error(L('user_exist'));

	//验证TOKEN
	if(!$user -> autoCheckToken($_POST)){
		$this->error(L('illegal_operation'));
	}

	//获取user表数据
	$data = array(
		'user' => trim(I('user')),
		'password' => md5(I('user')),
		'state' => 0,
		'role' => 750,
		'department' => I('department')
		);
	$res = $user -> data($data) -> add();

	//获取teachers表到数据
	$college = M('department') -> field('name') ->where(array('id' => $data['department'])) -> find();
	$data = array(
		'user_id' => $res,
		't_id' => I('user'),
		'real_name' => I('real_name'),
		'college' => $college['name'],
		't_title' => I('t_title'),
		'phone' => I('phone'),
		'email' => I('email'),
		);
	$res = $teachers -> data($data) -> add();

	if($res)
		$this->success(L('operation_success'),'teacher');
	else 
		$this->error(L('operation_failed'), 'add_teacher');

   }

    /***********更新教师信息********************/
    public function updateTeacher(){
	    $user = M('users');
	    $teacher = M('teachers');

	    //获取TOKEN
	    if(!$user -> autoCheckToken($_POST))
		    $this->error(L('illegal_operation'));
	    
	
            //判断用户id
	    $data['user'] = trim(I('user'));
	    
	    if($res = $user->where($data)->find() ){

		    if($res['user_id'] != I('post.id') )
			    $this -> error(L('user_exist'));
	    }

	    //获取users表到信息
	    $data = array(
			'id' => I('post.id'),
			'user' => trim(I('post.user')),
			'department' => I('post.department'),
		);
	    $res = $user -> data($data) -> save();

	    //获取teachers表到数据并保存
	    $college = M('department') -> field('name') -> where(array('id' => $data['department'])) -> find();
	    $data = array(
		't_id' => I('post.user'),
		'real_name' => I('post.real_name'),
		'college' => $college['name'],
		't_title' => I('post.t_title'),
		'phone' => I('post.phone'),
		'email' => I('post.email'),
		);
	    $res = $teacher -> data($data) -> where(array('user_id' => I('post.id'))) -> save();

	    if($res)
		    $this->success(L('operation_success'),'teacher');
	    else
		    //$this->error(L('operation_failed'));
		    p($teacher -> getError());
    	    
    }

    /**********删除教师***************/
    public function deleteTeacher(){
	    $user = M('users');
	    $teacher = M('teachers');

	    //获取验证信息
	    if(!$user -> autoCheckToken($_POST))
		    $this -> error(L('illeage_operation'));

	    //删除信息
	    $res = $user -> where(array('id' => I('val'))) -> delete();
	    $res = $teacher -> where(array('user_id' => I('val'))) -> delete();

	    //跳转
	    if($res)
		    $this->success(L('operation_success'));
	    else
		    $this->error(L('operation_failed'));
    }
    /**********专家组页面***********************/
    public function experts_group(){

	//获取数据排序
	$page['current'] = $_REQUEST['page'] ? $_REQUEST['page']:1;
	$page['next_page'] = U('User/experts_group',array('page'=>$page['current']+1));
	$page['last_page'] = U('User/experts_group',array('page'=>$page['current']-1>0 ? $page['current']-1 : 1 ));
	
	//获取数据
	$tutor = M('experts_group');

    }



    /**********专家页面*****************/
    public function experts(){

	    
	//获取数据排序
	$page['current'] = $_REQUEST['page'] ? $_REQUEST['page']:1;
	$page['next_page'] = U('User/experts',array('page'=>$page['current']+1));
	$page['last_page'] = U('User/experts',array('page'=>$page['current']-1>0 ? $page['current']-1 : 1 ));
    
    }

}

>>>>>>> vulpeess/master
