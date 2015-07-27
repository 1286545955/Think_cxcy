<?php
namespace Admin\Controller;
use Think\Controller;
class PublicController extends Controller {
    
    //显示登录页
    public function index(){
    	$this->display("sign-in");
    }

    //登录操作
    public function login(){
	
	//判断用户id和密码
	$data = array(
	    'user' => I('user_id'),
            'password' => md5(I('password'))
	);
        $Users = M("Users");
	
	if(!$user_info = $Users->where($data)->find()){
	    $this->error(L('username_or_password_error'));
	}
	//判断用户状态
	if($user_info['state'] != '0'){
	    $this->error(L('userstate_error'));
	}

	//获取用户姓名
	switch($user_info['role']){
	    case '777':
		    $user = array(
		        'real_name' => $user_info['user']	
			);
		    break;
	    case '770':
		    $user = M('teachers')->field('real_name')->where(array('t_id' => $user_info['user']))->find();
		    break;
	    case '700':
		    $user = M('teachers')->field('real_name')->where(array('t_id' => $user_info['user']))->find();
		    break;
            case '000':
		    $user = M('students')->field('real_name')->where(array('s_id' => $user_info['user']))->find();
		    break;

	}

	//注册session
        $_SESSION['user'] = $user_info['user'];
	$_SESSION['real_name'] = $user['real_name'];
	$_SESSION['role'] = $user_info['role'];
	$_SESSION['state'] = $user_info['state'];
	$_SESSION['last_ip'] = $user_info['last_ip'];
	$_SESSION['last_time'] = date('Y-m-d H:i:s' , $user_info['last_time']);

	//更新信息
	$redata = array(
	    'id' => $user_info['id'],
            'last_time' => time(),
            'last_ip' => get_client_ip(),	    
	);
	$Users->data($redata)->save();

	//跳转成功
	switch(session('role')){
	    case '777':
		    $this->success(L('login_success'),U('Index/index'));break;
            case '770':
		    $this->success(L('login_success'),U('Teacher/Index/index'));break;
	    case '700':
		    $this->success(L('login_success'),U('Teacher/Index/index'));break;
	    case '000':
		    $this->success(L('login_success'),U('Student/Index/index'));break;
		    
	}
    } 
}
