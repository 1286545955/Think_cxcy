<<<<<<< HEAD
<?php
namespace Admin\Controller;
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
=======
<?php
namespace Admin\Controller;
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
>>>>>>> vulpeess/master
