<?php
namespace Teacher\Controller;
use Think\Controller;
class IndexController extends Controller {
    
    public function _initialize(){
        if(!is_login()){
	   $this->redirect('Public/index');
	}
    }
    public function index(){
        $this->display();
    }
}
