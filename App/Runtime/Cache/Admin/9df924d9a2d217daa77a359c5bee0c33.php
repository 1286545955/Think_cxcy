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
            <li ><a href="<?php echo U('User/tutor');?>">专家组管理</a></li>
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


                    

<div class="row-fluid">

    <div class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">×</button>
        <strong>温馨提示:</strong> 请仔细审核项目材料
    </div>

    <div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">Latest Stats</a>
        <div id="page-stats" class="block-body collapse in">

            <div class="stat-widget-container">
                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title">2,500</p>
                        <p class="detail">Accounts</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title">3,299</p>
                        <p class="detail">Subscribers</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title">$1,500</p>
                        <p class="detail">Pending</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title">$12,675</p>
                        <p class="detail">Completed</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>




     
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