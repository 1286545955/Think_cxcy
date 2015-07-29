<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML>
<html>
<head>
    <meta charset="UTF8">
    <meta charset="utf-8">
    <title>创新项目管理系统</title>
    <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" type="text/css" href="/Public/lib/bootstrap/css/bootstrap.css">
    
    <link rel="stylesheet" type="text/css" href="/Public/stylesheets/theme.css">
    <link rel="stylesheet" href="/Public/lib/font-awesome/css/font-awesome.css">

    <script src="/Public/lib/jquery-1.7.2.min.js" type="text/javascript"></script>

    <!-- Demo page code -->

    <style type="text/css">
        #line-chart {
            height:300px;
            width:800px;
            margin: 0px auto;
            margin-top: 1em;
        }
        .brand { font-family: georgia, serif; }
        .brand .first {
color: #ccc;
            font-style: italic;
        }
        .brand .second {
            color: #fff;
            font-weight: bold;
        }
    </style>

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">

</head>
<body>
    <div class="navbar">
        <div class="navbar-inner">
                <ul class="nav pull-right">
                    
                    <li><a href="#" class="hidden-phone visible-tablet visible-desktop" role="button">设置</a></li>
                    <li id="fat-menu" class="dropdown">
                        <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="icon-user"></i> 逸凡创新团队
                            <i class="icon-caret-down"></i>
                        </a>

                        <ul class="dropdown-menu">
                            <li><a tabindex="-1" href="#">我的项目</a></li>
                            <li class="divider"></li>
                            <li><a tabindex="-1" class="visible-phone" href="#">设置</a></li>
                            <li class="divider visible-phone"></li>
                            <li><a tabindex="-1" href="sign-in.html">登出</a></li>
                        </ul>
                    </li>
                    
                </ul>
                <a class="brand" href="index.html"><span class="first">辽宁工业大学</span> <span class="second">创新项目管理系统</span></a>
        </div>
    </div>

    <block name = "menu" >
 
    <!--div class="copyrights">Collect from <a href="http://www.cssmoban.com/"  title="网站模板">网站模板</a></div-->
    <div class="sidebar-nav">
        <form class="search form-inline">
            <input type="text" placeholder="搜索...">
        </form>
		
		
        <a href="#projects-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>项目管理</a>
                <ul id="projects-menu" class="nav nav-list collapse">
                    <li><a href="users.html" >项目申请查询</a></li>
                    <li><a href="users2.html" >项目审批分配</a></li>
                    <li><a href="help.html"  >项目审批结果汇总</a></li>
                    <li><a href="help.html" >项目进程查询</a></li>
                    <li> <a href="users2.html" >中期审批</a></li>
                    <li><a href="users3.html" >结题审批</a></li>
                </ul>
       
        <a href="terms-and-conditions.html" class="nav-header" ><i class="icon-comment"></i>公告发布、审批</a>
        <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-briefcase"></i>用户管理</a>
        <ul id="accounts-menu" class="nav nav-list collapse">
            <li ><a href="<?php echo U('User/teacher');?>">教师管理</a></li>
            <li ><a href="<?php echo U('User/student');?>">学生管理</a></li>
            <li ><a href="<?php echo U('User/experts_group');?>">专家组管理</a></li>
        </ul>
    </div>

</block>
<div class="content">
        <div class="header">
            <div class="stats">
    <p class="stat"><span class="number">53</span>项目数量</p>
    <p class="stat"><span class="number">27</span>审核数量</p>
    <p class="stat"><span class="number">15</span>等待数量</p>
	</div>

            <h1 class="page-title">校级管理</h1>
        </div>
        


        <div class="container-fluid">
            <div class="row-fluid">


<div class="btn-toolbar">
    <button  class="btn btn-primary" onclick = "submitpost()"><i class="icon-save"></i> <?php echo L('save');?></button>
    <a href="<?php echo U('User/teacher');?>"  class="btn"><?php echo L('cancel');?></a>
  <div class="btn-group">
  </div>
</div>
<div class="well">

    <div id="myTabContent" class="tab-content">

    <form id="tab" <?php if($ope == 'add'): ?>action="<?php echo U('User/insert_teacher');?>" <?php else: ?> action="<?php echo U('user/add_teacher', array('<object></object>pe' => 'update'));?>"<?php endif; ?>  method="post" >
        <input type="hidden" name="token" value="<?php echo ($token); ?>">
        <label><?php echo L('user');?></label>
        <input type="text" id="user" name="user" value="<?php echo ($data["user"]); ?>" class="input-xlarge">
        <label><?php echo L('real_name');?></label>
        <input type="text" id="real_name" name="real_name" value="<?php echo ($data["real_name"]); ?>" class="input-xlarge">
        <label><?php echo L('college');?></label>
        <select class="input-xlarge" name="department">
          <?php if(is_array($college)): $i = 0; $__LIST__ = $college;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["d_id"]); ?>" <?php if($vo['d_id'] = $data['department']): ?>selected="selected"<?php endif; ?> ><?php echo ($vo["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        </select>
        <label>Email</label>
        <input type="text" id="email" name="email" value="<?php echo ($data["email"]); ?>" class="input-xlarge" data-toggle="tooltip" data-placement="right" title="<?php echo L('email'); echo L('error');?>">
         <label><?php echo L('phone');?></label>
        <input type="text" id="phone" name="phone" value="<?php echo ($data["phone"]); ?>" class="input-xlarge" data-toggle="tooltip" data-placement="right" title="<?php echo L('phone'); echo L('error');?>" onkeypress="return (/[\d.]/.test(String.fromCharCode(event.keyCode)))">
        <label><?php echo L('t_title');?></label>
        <input type="text" id="t_title" name="t_title" value="<?php echo ($data["t_title"]); ?>" class="input-xlarge">
    </form>

  </div>

</div>

<script>

function submitpost(){

  var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
  var email_val = $("#email").val();
  var isMobile=/^(?:13\d|15\d)\d{5}(\d{3}|\*{3})$/;   
  var isPhone=/^((0\d{2,3})-)?(\d{7,8})(-(\d{3,}))?$/;
  var phone_val = $('#phone').val();

    if($('#user').val() == ''){
      $('#user').focus();
      return false;
    }
    if( $('#real_name').val() == '' ){
      $('#real_name').focus();
      return false;
    }
    if( $('#email').val() == '' ){
      $('#email').focus();
      return false;
    }
    if( $('#phone').val() == ''){
      $('#phone').focus();
      return false;
    }
    if( $('#t_title').val() == ''){
      $('#t_title').focus();
      return false;
    }
    if(!search_str.test(email_val)){ 
      $('#email').focus();   
      $('#email').tooltip();
      return false;
    }
    if(! isMobile.test(phone_val) && !isPhone.test(phone_val)){
      $('#phone').focus();   
      $('#phone').tooltip();
      return false;
    }
    $('#tab').submit();

}

</script>


     
    <footer>
            <hr>
                        
             <p class="pull-right">© 花鱼片 @ 2013-2016 For 辽宁工业大学 , 锦州鑫利信息技术有限公司  <a href="http://efan.in" title="efan" target="_blank"> </a></p>

    </footer>
                    
    </div>
 </div>
</div>

    
<script src="/Public/lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>

</body>
</html>