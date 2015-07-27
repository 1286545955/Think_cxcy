<?php

//判断用户登录状态
function is_login(){
    return session('user') ? session('user') : 0;
}

//检测验证码
function check_verify($code, $id = 1){
    $veriry = new \Think\Verify();
    return $verify->check($code, $id);
}

//输出
function p($array){
    dump($array,1,'<pre>',0);
}
?>
