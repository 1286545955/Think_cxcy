<?php
namespace Student\Controller;
use Think\Controller;
class IndexController extends Controller {
    
    public function _initialize(){
        if(!is_login()){
	   $this->redirect('/Admin/Public/index');
	}
    }
    public function index(){
        $this->display();
    }
}
